<?php

namespace App\Http\Controllers;

use App\Category;
use App\Mail\ForgetPasswordMail;
use App\Mail\VerifyUserMail;
use App\Http\Requests\ForgotPasswordRequest;
use App\Option;
use App\PayPal;
use App\PayPalAgreements;
use App\Setting;
use App\SocialAccount;
use App\Traits\SendMail;
use App\User;
use Datatables;
use Dompdf\Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Image;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use AuthenticatesUsers, SendMail;

    public function getUser()
    {
        return view('Admin/UserPage');
    }

    public function getUserTable(Request $request)
    {
        $fromDate = $request->input('userFromDate');
        $toDate   = $request->input('userToDate');

        if ($fromDate != "" && $toDate != "") {

            $userTable = DB::table('social_accounts')
                ->join('users', 'users.id', 'social_accounts.user_id')
                ->whereBetween('users.created_at', [$fromDate, $toDate])
                ->orderBy('users.created_at', 'desc')
                ->get();
        } else {

            $userTable = DB::table('social_accounts')
                ->join('users', 'users.id', 'social_accounts.user_id')
                ->orderBy('users.created_at', 'desc')
                ->get();
        }

        return Datatables::of($userTable)
            ->addColumn('userType', function ($row) {

                $socialAccount = DB::table('social_accounts')
                    ->where('user_id', $row->id)
                    ->get();

                if (count($socialAccount) > 0) {

                    foreach ($socialAccount as $social) {

                        return $social->provider;
                    }
                } else {

                    return 'b4mx';
                }
            })
            ->make(true);
    }

    public function addUser(Request $request)
    {
        $user           = new User;
        $user->name     = $request->input('txtUserName');
        $user->email    = $request->input('txtUserEmail');
        $user->password = bcrypt($request->input('password'));

        $user->save();
        auth()->login($user);

        return redirect()->to('/');
    }

    public function updateUser(Request $request)
    {
        $userRole = $request->input('userRole');
        $userId   = $request->input('id');

        $user = User::find($userId);

        $user->userRole = $userRole;
        $user->save();

        $result = array('success' => 1);

        return $result;
    }

    public function deleteUser(Request $request)
    {
        $id   = $request->input('id');
        $user = User::find($id);

        $user->userRole = 'blocked';

        $user->save();

        $result = array('success' => 1);

        return $result;
    }

    public function registerUser(request $request)
    {
        $this->validate($request, [
            //'name' => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|alpha_num|min:7|confirmed',
        ]);

        $email = $request->input('email');

        $checkEmail = User::where('email', $email)
            ->where('isSocial', 'false')
            ->first();

        if ($checkEmail == null) {

            $user = new User;

            $user->email    = $email;
            $user->password = bcrypt($request->input('password'));
            $user->userRole = "pending";
            $user->isSocial = "false";

            $user->save();

            $encryptedUserId = bcrypt($user->id);
            Mail::to($email)->send(new VerifyUserMail($user, $encryptedUserId));

            return redirect()->to('getLoginPage')->with(["success" => "pending"]);
        } else {

            return redirect()->back()->with('fail', '✖ ' . trans('message-box.theemailalreadyexist'));
        }
    }

    public function registerUserAjax(request $request)
    {
        $email = $request->input('email');

        $checkEmail = User::where('email', $email)
            ->where('isSocial', 'false')
            ->first();

        if ($checkEmail == null) {

            $user = new User;

            $user->email    = $email;
            $user->password = bcrypt($request->input('password'));
            $user->userRole = "pending";
            $user->isSocial = "false";

            $user->save();

            $encryptedUserId = \Crypt::encryptString($user->id);
            Mail::to($email)->send(new VerifyUserMail($user, $encryptedUserId));

            return response()->json([
                'status'  => 'success',
                'message' => 'register',

            ]);
        } else {
            return response()->json([
                'status'  => 'error',
                'message' => '✖ ' . trans('message-box.theemailalreadyexist')
            ]);
        }
    }

    public function userLogin(Request $request)
    {
        if (!$request->session()->has('locale')) {
            $request->session()->put('locale', 'en');
        }

        $email    = $request->input('email');
        $password = $request->input('password');

        $currentUserRole = DB::table('users')->where('email', $email)->value('userRole');

        if (Auth::attempt([
            'email'    => $email,
            'password' => $password,
            'userRole' => 'user',
            'isSocial' => 'false'
        ], true)
        ) {
            // Authentication passed...
            return redirect()->intended('/');
        } else if (Auth::attempt([
            'email'    => $email,
            'password' => $password,
            'userRole' => 'unset',
            'isSocial' => 'false'
        ], true)
        ) {
            return redirect()->intended('getProfilePage');
        } else if (Auth::attempt(['email' => $email, 'password' => $password, 'userRole' => 'admin'], true)) {
            return redirect()->intended('/');
        } else if ($currentUserRole == 'pending') {
            return redirect()->back()->with('fail', '✖ ' . trans('message-box.pleaseverifyemail'));
        } else {
            return redirect()->back()->with('fail', '✖ ' . trans('message-box.incorrectlogindetails'));
        }
    }

    public function userLoginAjax(Request $request)
    {
        if (!$request->session()->has('locale')) {
            $request->session()->put('locale', 'en');
        }

        $email    = $request->input('email');
        $password = $request->input('password');

        $currentUserRole = DB::table('users')->where('email', $email)->value('userRole');

        if (Auth::attempt([
            'email'    => $email,
            'password' => $password,
            'userRole' => 'user',
            'isSocial' => 'false'
        ], true)) {
            return response()->json([
                'status'  => 'success',
                'message' => '',
            ]);
        } else if (Auth::attempt([
            'email'    => $email,
            'password' => $password,
            'userRole' => 'unset',
            'isSocial' => 'false'
        ], true)) {
            return response()->json([
                'status'  => 'success',
                'message' => '',
            ]);
        } else if (Auth::attempt(['email' => $email, 'password' => $password, 'userRole' => 'admin'], true)) {
            return response()->json([
                'status'  => 'success',
                'message' => '',
            ]);
        } else if ($currentUserRole == 'pending') {
            return response()->json([
                'status'  => 'error',
                'message' => '✖ ' . trans('message-box.pleaseverifyemail'),
            ]);
        } else {
            return response()->json([
                'status'  => 'error',
                'message' => '✖ ' . trans('message-box.incorrectlogindetails'),
            ]);
        }
    }

    public function newLoginAjax(Request $request)
    {
        $email    = $request->input('email');
        $password = $request->input('pass');

        if (Auth::attempt([
            'email'    => $email,
            'password' => $password,
            'isSocial' => 'false'
        ], true)) {
            return response()->json([
                'status'  => 'success',
                'message' => 'user',
            ]);
        } else if (Auth::attempt([
            'email'    => $email,
            'password' => $password,
            'userRole' => 'admin',
            'isSocial' => 'false'
        ], true)) {
            return response()->json([
                'status'  => 'success',
                'message' => 'admin',
            ]);
        } else {
            return response()->json([
                'status'  => 'error',
                'message' => '✖ Error! Invalid data',
            ]);
        }
    }

    public function newSignUpAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:4|max:255|alpha_num',
            'email'    => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => 'required|min:6|confirmed',
        ]);

        $email    = $request->input('email');
        $username = $request->input('username');
        $password = $request->input('password');


        /*$errors = [];*/
        if ($validator->fails()) {

            /*foreach ($validator->errors()->keys() as $errorKey) {
                switch ($errorKey) {
                    case "username":
                        $errors += [$errorKey => 'Name must be ' . explode('.', $validator->errors()->get($errorKey)[0])[1]];
                        break;
                    case "email":
                        dd($validator->errors()->get($errorKey));
                        $errors += [$errorKey => 'Email must be ' . explode('.', $validator->errors()->get($errorKey)[0])[1]];
                        break;
                    case "password":
                        if (explode('.', $validator->errors()->get($errorKey)[0])[1] === "min") {
                            $errors += [$errorKey => 'Password must be ' . explode('.', $validator->errors()->get($errorKey)[0])[1] . ' 6'];
                        }
                        else {
                            $errors += [$errorKey => 'Password must be ' . explode('.', $validator->errors()->get($errorKey)[0])[1]];
                        }
                        break;
                }
            }*/
            return response()->json(['error' => $validator->errors()->messages()]);
        }

        if ($validator->passes()) {
            $checkEmail = User::where('email', $email)
                ->where('isSocial', 'false')
                ->first();

            if ($checkEmail == null) {
                $user           = new User;
                $user->email    = $email;
                $user->name     = $username;
                $user->password = bcrypt($password);
                $user->userRole = "user";
                $user->isSocial = "false";
                $user->save();

//                $encryptedUserId = \Crypt::encryptString($user->id);
//                Mail::to($email)->send(new VerifyUserMail($user, $encryptedUserId));

                Auth::login($user);

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Welcome!',
                ]);
            } else {
                return response()->json([
                    'status'  => 'error',
                    'message' => '✖ User exists'
                ]);
            }
        }
    }

    public function verifyEmail($encryptedUserId)
    {
        $userId = \Crypt::decryptString($encryptedUserId);
        $user   = User::findOrFail($userId);

        if ($user->userRole == "pending") {
            $user->userRole = "unset";
            $user->save();
        }

        Auth::login($user);

        return redirect()->route('home')->with('status', 'Thanks! Your email verified');
    }

    public function forgetPassword(Request $request)
    {

        $email = $request->input('email');

        $checkUser = User::where('email', $email)
            ->where('isSocial', 'false')
            ->first();

        $user = User::where('email', $email)
            ->where('isSocial', 'false')
            ->get();

        $userId = User::where('email', $email)
            ->where('isSocial', 'false')
            ->value('id');

        $socialAccount = SocialAccount::where('user_id', $userId)->first();

        if ($checkUser == null || $socialAccount != null) {

            return redirect()->back()->with('fail', '✖ ' . trans('message-box.invalidaccountdetails'));
        } else {

            $password = mt_rand(100000, 999999);

            $changePassword = bcrypt($password);

            foreach ($user as $users) {

                $changeUser           = User::find($users->id);
                $changeUser->password = $changePassword;
                $changeUser->save();

                Mail::to($email)->send(new ForgetPasswordMail($changeUser, $password));

                return redirect()->back()->with('success', '✓ ' . trans('message-box.passwordhasbeenretrieved'));
            }
        }
    }

    public function forgetPasswordAjax(ForgotPasswordRequest $request)
    {

        $checkUser = User::where('email', $request->email)->where('isSocial', 'false')->first();

        if ($checkUser == null) {
            if (User::where('email', $request->email)->where('isSocial', 'true')->exists()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => '✖ Please login via social'
                ]);
            }

            return response()->json([
                'status'  => 'error',
                'message' => '✖ User not found'
            ]);
        }

        DB::table('password_resets')
            ->where('email', $request->email)
            ->delete();

        $resetPasswordToken = Str::random(60);

        DB::table('password_resets')->insert([
            'email'      => $request->email,
            'token'      => $resetPasswordToken,
            'created_at' => now(),
        ]);

        Mail::to($request->email)->send(new ForgetPasswordMail($checkUser, $resetPasswordToken));

        return response()->json([
            'status'  => 'success',
            'message' => 'Please check your email.'
        ]);
    }

    public function getChangePassword(string $email, string $token)
    {
        $user           = User::where('email', $email)->first();
        $passwordResets = DB::table('password_resets')
            ->select('token')
            ->where('email', $email)
            ->latest()
            ->first();

        if ($token !== $passwordResets->token || $user === null) {
            abort('404');
        }

        return view('site.auth.passwords.change-password', [
            'authUser'       => \auth()->user(),
            'mainCategories' => Category::all(),
            'email'          => $email,
            'token'          => $token,
        ]);
    }

    public function changePassword(Request $request, string $email, string $token)
    {
        $user           = User::where('email', $email)->first();
        $passwordResets = DB::table('password_resets')
            ->select('token')
            ->where('email', $email)
            ->latest()
            ->first();

        if ($token !== $passwordResets->token || $user === null) {
            abort('404');
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('pages.show', '/');
    }

    public function ResetPassword(Request $request)
    {

        $currentPassword = $request->input('current_password');
        $password        = $request->input('password');
        $confirmPassword = $request->input('password_confirmation');

        $loggedInUserEmail = Auth::user()->email;

        $checkUser = User::where('email', $loggedInUserEmail)
            ->where("isSocial", "=", "false")
            ->whereIn("userRole", array("admin", "user"))
            ->first();

        /*$getUser = User::where('email', $loggedInUserEmail)
                    ->get();*/

        if (!Hash::check($currentPassword, $checkUser->password)) {
            return redirect()->back()->with('fail', '✖ ' . trans('message-box.wrongcurrentpassword'));
        } else if ($password != $confirmPassword) {
            return redirect()->back()->with('fail', '✖ ' . trans('message-box.mismatchnewandconfirmpassword'));
        } else {
            //$changeUser = User::find($user->id);
            $checkUser->password = bcrypt($password);
            $checkUser->save();

            /*foreach($getUser as $user){

            }*/

            return redirect()->back()->with('success', '✓ ' . trans('message-box.passwordhasbeenchangedsuccessfully'));
        }
    }

    public function updateUserProfile(Request $request)
    {

        $errors = [];

        $validation = [
            'FirstName'  => 'required|string|max:191',
            'LastName'   => 'required|string|max:191',
            'City'       => 'required|string|max:191',
            'Region'     => 'required|string|max:191',
            'Country'    => 'required|string|max:191',
            'UserType'   => 'required',
            'Phone'      => 'required|max:191',
            'isRetailer' => 'required|integer',
        ];

        $user = User::find(Auth::user()->id);

        if ($user->email != $request->input('Email')) {
            $validation['Email'] = 'required|string|email|max:191|unique:users';
        }

        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            return redirect('/getProfilePage')
                ->withErrors($validator)
                ->withInput();
        }

        $user->name       = $request->input('FirstName');
        $user->city       = $request->input('City');
        $user->region     = $request->input('Region');
        $user->country    = $request->input('Country');
        $user->email      = $request->input('Email');
        $user->userType   = $request->input('UserType');
        $user->phone      = $request->input('Phone');
        $user->isRetailer = $request->input('isRetailer');

        if ($request->input('vat') != '') {
            if ($this->verifyVat($request->input('vat'))) {
                $user->vat = $request->input('vat');
            } else $errors['vat'] = 'Not valid vat !';
        } else {
            $user->vat = '';
        }

        /*
        $user->name = $request->input('txtName');
        $user->city = $request->input('geolocationCity');
        $user->region = $request->input('geolocationRegion');
        $user->country = $request->input('geolocationCountry');
        $user->longitude = $request->input('geolocationLongitude');
        $user->latitude = $request->input('geolocationLatitude');
        $user->callingCode = $request->input('dropDownCallingCode');
        $user->phone = $request->input('txtPhone');
        $user->userType = $request->input('radioUserType');
        $user->vat = $request->input('txtVat');
        $user->phoneContactType = $request->input('selectPhontType');
        $user->b4mxContactType = $request->input('selectb4mxType');
        $user->emailContactType = $request->input('selectEmailType');
        $user->userRole = 'user';
        */


        $agreements = $user->agreements()->where('status', 'active')->get();
        $paypal     = new PayPal();

        function cancelAgreements($agreements, &$paypal, &$errors)
        {

            $ids = [];

            foreach ($agreements as &$agreement) {

                $res = $paypal->SuspendAgreement($agreement->aid);

                $ids[] = $agreement->id;

                if ($res !== true) {

                    $agreement->status = "suspend-error";
                    $errors[]          = "Suspend Agrement Error id: " . $agreement->aid;

                } else {

                    $agreement->status = "suspended";

                }

                $agreement->save();

            }

            return $ids;

        }

        $user->save();

        if ($user->isRetailer && $user->subscription != $request->input('subscription')) {

            $aids = [];

            if (count($agreements) > 0) {

                $aids = cancelAgreements($agreements, $paypal, $errors);

            }

            $tmp_aid = uniqid('tmp_aid_');

            $agreement = $paypal->CreateAgreement([
                'plan'      => [
                    'name'         => "Trader Subscription",
                    'description'  => "Trader Subscription Description",
                    'amount'       => floatval($request->input('price_subscription')) * intval($request->input('Period')),
                    'currency'     => "EUR",
                    'subscription' => $request->input('subscription'),
                    'frequency'    => "Month",
                    'interval'     => $request->input('Period'),
                    'cycles'       => "12",
                    'max_fail'     => "10",
                    'setup_fee'    => 1,
                    'redirect_url' => url("/") . "/paypal/back/agreement?redir=getProfilePage&aid=" . $tmp_aid . "&sbs=" . urlencode($request->input('subscription')) . "&uid=" . $user->id,
                    'cancel_url'   => is_null($user->subscription) || strlen($user->subscription) <= 0 ? url("/") . "/getProfilePage" : url("/") . "/paypal/renew/agreement?uid=" . $user->id . "&old_subscrib=" . urlencode($user->subscription) . "&redir=getProfilePage&aids=" . implode(',', $aids),
                ],
                'agreement' => [
                    'name'        => "Basic Agreement - " . $request->input('subscription'),
                    'description' => "Basic Agreement",
                    'startDate'   => "2019-06-17T9:45:04Z",
                ],
            ]);

            $user->subscription = "";

            $user->save();


            if (is_string($agreement)) {

                $errors[] = $agreement;

            } else {

                try {

                    PayPalAgreements::create([
                        'uid'    => $user->id,
                        'aid'    => $tmp_aid,
                        'name'   => $request->input('subscription'),
                        'type'   => 'recurring-plan',
                        'status' => 'created',
                        'period' => $request->input('Period'),
                    ]);


                } catch (\Exception $e) {
                    return redirect('/getProfilePage')->withErrors([$e->getMessage()]);
                }

                return redirect($agreement->getApprovalLink());

            }


        } elseif (!$user->isRetailer) {

            if (count($agreements) > 0) {

                cancelAgreements($agreements, $paypal, $errors);

            }

            $user->subscription = "";

            $user->save();

        }

        if (count($errors) > 0) {

            redirect('/getProfilePage')->withErrors($errors);

        }

        return redirect('/getProfilePage');

        // return redirect()->back()->with('success', '✓ '.trans('message-box.profiledetailssavedsuccessfully'));
    }

    public function getBlockedPage()
    {

        return view('user/blockedpage');
    }

    /**
     * Verify Vat by
     * @param string $vat_number vat id
     * @return boolean            verified or not
     */
    public function verifyVat($vat_number)
    {
        // $vat_number = 'GB198332378';
        $apikey = Option::getSetting('opt_vatapi_key');

        $endpoint = 'https://vatapi.com/v1/vat-number-check?vatid=' . $vat_number;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Apikey: ' . $apikey));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);

        $response = json_decode(curl_exec($ch), true);

        curl_close($ch);

        // dd($response['valid']);

        return (isset($response['valid']) && $response['valid'] == true) ? true : false;
    }

    public function sendContactEmail(Request $request)
    {
        $supportEmail = Option::getSetting("opt_support_email");

        if ($request->file !== null) {
            $file = $request->file;

            $ext  = $file->getClientOriginalExtension();
            $name = uniqid() . "." . $ext;
            $url  = '/public/uploads/';

            Storage::putFileAs($url, $file, $name);
            $file_url = storage_path('app' . $url . $name);
        }
        SendMail::sendEmail(
            'New support request',
            $supportEmail,
            $request->email,
            'mail.support',
            ['text' => 'From: ' . $request->email . "<br> Message:" . $request->message_text],
            $file_url ?? null
        );

        return redirect()->back()->with('success', 'Your message was sent');
    }
}
