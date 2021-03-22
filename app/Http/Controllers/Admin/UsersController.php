<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use App\User;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends BaseController
{
    public $allowed = [
        'image/gif',
        'image/png',
        'image/jpeg',
    ];

    public function Pages(Request $request, $page)
    {
        if (!Auth::check() || Auth::user()->userRole != "admin") {
            return redirect("/");
        }

        switch ($page) {
            case "all":
                $usersBuilder = User::orderBy('created_at');

                if ($request->has('keyword') && $request->keyword !== null) {
                    $keyword = '%' . $request->keyword . '%';
                    $usersBuilder->where('name', 'LIKE', $keyword)
                        ->orWhere('email', 'LIKE', $keyword)
                        ->orWhere('city', 'LIKE', $keyword)
                        ->orWhere('region', 'LIKE', $keyword)
                        ->orWhere('country', 'LIKE', $keyword)
                        ->orWhere('phone', 'LIKE', $keyword);
                }

                return view('newthemplate.Admin.users', [
                    'Page' => 'users',
                    "AllUsers" => $usersBuilder->paginate(10)
                ]);
            case "add":
                return view('newthemplate.Admin.add-user', [
                    'Page' => 'add-user',
                ]);
            default:
                return redirect("/admin/users/all");
        }
    }

    /**
     * Get user list for admin place_add page
     * @param Request $request query and page
     * @return json                user list
     */
    public function Place_add(Request $request)
    {
        if (!Auth::check() || Auth::user()->userRole != "admin") {
            return redirect("/");
        }
        if ($request->wantsJson())
            return User::select('id', DB::raw('CONCAT(name, " ", lname, " (", email, ")") AS text'))
                ->where('id', 'LIKE', $request->search . '%')
                ->orWhere('name', 'LIKE', '%' . $request->search . '%')
                ->paginate(10);

    }

    public function RemoveUser(Request $request, $uid)
    {

        if (!Auth::check() || Auth::user()->userRole != "admin") {
            return response()->json(['status' => 'error', "message" => "You don`t have permissions!"]);
        }

        $uid = intval($uid);

        $User = User::find($uid);

        if (!is_null($User)) {

            $User->delete();

            return response()->json(['status' => 'success', "message" => "Removed"]);

        }

        return response()->json(['status' => 'error', "message" => "User not find"]);

    }

    public function ConfirmUser(Request $request, $uid)
    {

        if (!Auth::check() || Auth::user()->userRole != "admin") {
            return response()->json(['status' => 'error', "message" => "You don`t have permissions!"]);
        }

        $uid = intval($uid);

        $User = User::find($uid);

        if (!is_null($User)) {

            if ($User->userRole != "pending") {
                return response()->json(['status' => 'success', "message" => "User already confirmed"]);
            }

            $User->userRole = "user";
            $User->save();

            return response()->json(['status' => 'success', "message" => "Confirmed"]);

        }

        return response()->json(['status' => 'error', "message" => "User not find"]);

    }

    public function ChaneUserType(Request $request, $uid)
    {

        if (!Auth::check() || Auth::user()->userRole != "admin") {
            return response()->json(['status' => 'error', "message" => "You don`t have permissions!"]);
        }

        $req = $request->validate([
            'type' => 'required|integer'
        ]);

        $uid = intval($uid);

        $User = User::find($uid);

        if (!is_null($User)) {

            $User->userType = $req['type'];
            $User->save();

            return response()->json(['status' => 'success', "message" => "Changed"]);

        }

        return response()->json(['status' => 'error', "message" => "User not find"]);

    }

    public function ChaneUserRetailer(Request $request, $uid)
    {

        if (!Auth::check() || Auth::user()->userRole != "admin") {
            return response()->json(['status' => 'error', "message" => "You don`t have permissions!"]);
        }

        $req = $request->validate([
            'is_retailer' => 'required|integer'
        ]);

        $uid = intval($uid);

        $User = User::find($uid);

        if (!is_null($User)) {

            $User->isRetailer = $req['is_retailer'];
            $User->save();

            return response()->json(['status' => 'success', "message" => "Changed"]);

        }

        return response()->json(['status' => 'error', "message" => "User not find"]);

    }

    public function User(Request $request)
    {
        if (!Auth::check() || Auth::user()->userRole != "admin") {
            return response()->json(['status' => 'error', "message" => "You don`t have permissions!"]);
        }

        $req = $request->validate([
            'user' => 'required|array',
            'user.name' => 'required|string',
            'user.avatar' => 'file',
            'user.email' => 'required|email',
            'user.password' => 'string',
        ]);

        $user = $req['user'];

        if (isset($user['avatar'])) {

            $file = $request->file('user.avatar');
            $filename = md5(substr(str_replace(' ', '', microtime() . microtime()), 0, 40) . time()) . '.' . $file->getClientOriginalExtension();
            $path = '/storage/avatar/' . str_random(2) . '/' . str_random(2) . '/';
            if (!file_exists(public_path($path))) mkdir(public_path($path), 0775, true);

            $resize = Image::make($file)->fit(170);
            $resize->save(public_path($path . $filename));

            $user['avatar'] = $path . $filename;
        }

        if (isset($user['password'])) {

            $user['password'] = bcrypt($user['password']);

        }

        if (isset($user['id'])) {

            $user = User::find($user['id'])->update($user);
            $user->userRole = 'unset';
            $user->isSocial = 'false';
            $user->save();

            return redirect("/admin/users/all");

        } else {

            $user = User::create($user);
            $user->userRole = 'unset';
            $user->isSocial = 'false';
            $user->save();

            return redirect("/admin/users/all");
        }

    }

    public function UploadImage(Request $request)
    {

        if (!Auth::check() || Auth::user()->userRole != "admin") {
            return response()->json(['status' => 'error', "message" => "You don`t have permissions!"]);
        }

        $images = array();
        foreach ($request->file('files') as $image) {
            try {
                // Check mime
                if (!in_array($image->getClientMimeType(), $this->allowed)) {
                    $errors[] = 'Mime type: ' . $image->getClientMimeType() . ' not allowed';
                    continue;
                }
                // Resize image
                $preview = Image::make($image)
                    ->resize(740, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    }) // resize the image to a width of 740 and constrain aspect ratio (auto height)
                    ->resize(null, 457, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    }); // resize the image to a height of 457 and constrain aspect ratio (auto width)
                $filename = md5(substr(str_replace(' ', '', microtime() . microtime()), 0, 40) . time()) . '.' . $image->getClientOriginalExtension(); // file "uniqname.ext"
                $folder = config('image.folder') . str_random(2) . '/' . str_random(2) . '/'; // save to folder
                $path = public_path($folder); // full path for saving
                if (!file_exists($path)) mkdir($path, 0775, true); // create dir if not exist
                $preview->save($path . $filename); // save resized image

                $images[] = $folder . $filename;


            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $e->getMessage(),
                ]);
            }
        }
        return response()->json([
            'status' => !empty($errors) ? 'error' : 'success',
            'errors' => !empty($errors) ? $errors : 0,
            'images' => $images,
        ]);

    }

    public function adminProfile()
    {
        return view('newthemplate.Admin.admin-profile', [
            'Page' => 'admin-profile',
        ]);
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'avatar' => 'file',
            'email' => 'required|email',
            'password' => 'required|string|confirmed',
        ]);
        $user = auth()->user();

        if ($request->has('avatar')) {

            $file = $request->file('avatar');
            $filename = md5(substr(str_replace(' ', '', microtime() . microtime()), 0, 40) . time()) . '.' . $file->getClientOriginalExtension();
            $path = '/storage/avatar/' . str_random(2) . '/' . str_random(2) . '/';
            if (!file_exists(public_path($path))) mkdir(public_path($path), 0775, true);

            $resize = Image::make($file)->fit(170);
            $resize->save(public_path($path . $filename));

            $user->avatar = $path . $filename;
        }

        if ($request->has('email')) {

            $user->email = $request->get('email');
        }

        if ($request->has('name')) {

            $user->name = $request->get('name');
        }

        if ($request->has('password') && $request->get('password') !== '********') {

            $user->password = bcrypt($request->get('password'));
        }

        $user->save();

        return redirect("/admin/admin-profile");
    }

}
