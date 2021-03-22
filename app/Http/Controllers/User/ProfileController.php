<?php

namespace App\Http\Controllers\User;

use App\Activity;
use App\Ads;
use App\Events\NewNotification;
use App\SavedUsers;
use App\Rules\ImageExtension;
use Carbon\Carbon;
use GeoIp2\Model\Country as GeoCountry;
use Illuminate\Http\Request;
use App\User;
use App\Language;
use App\Country;
use App\Rules\CurrentPassword;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use App\Traits\ImageCropping;
use Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use function Couchbase\defaultDecoder;

class ProfileController extends BaseController
{
    use ImageCropping;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getProfilePage(Request $request)
    {
        $ip_address = $request->ip();

        $json           = file_get_contents('http://ip-api.com/json/' . $ip_address);
        $ip_info_object = json_decode($json);

        if ($ip_info_object->status == "fail") {
            $latitude  = 0;
            $longitude = 0;
        } else {
            $latitude  = $ip_info_object->lat;
            $longitude = $ip_info_object->lon;
        }

        $userId = Auth::user()->id;
        $user   = User::find($userId);

        $socialAcounts = DB::table('social_accounts')
            ->where('social_accounts.user_id', '=', $userId)
            ->get();

        $countriesList   = DB::table('world_countries')->pluck('name');
        $callingCodeList = DB::table('world_countries')->orderBy('name', 'asc')->get();

        if ($user->country == null) {
            $states = 'none';
        } else {

            if ($user->region == "none") {

                $states = "none";
            } else {

                try {
                    $states = DB::table('world_countries')
                        ->join('states', 'states.country_id', 'world_countries.id')
                        ->whereRaw('LOWER(world_countries.name) like LOWER("%' . $user->country . '%")')
                        ->orderBy('states.name', 'asc')
                        ->pluck('states.name');
                } catch (\Exception $e) {
                    $states = 'nostate';
                }
            }
        }

        return view('newthemplate/profile-settings', [
            "user"            => $user,
            "countriesList"   => $countriesList,
            'callingCodeList' => $callingCodeList,
            'states'          => $states,
            'latitude'        => $latitude,
            'longitude'       => $longitude,
            'socialLogin'     => $socialAcounts,
            'Page'            => 'getProfilePage'
        ]);
    }

    public function index()
    {
        $user = User::with(['Ads', 'Ads.image'])->find(auth()->user()->id);
        return view('site.profile.index', compact('user'));
    }

    public function show(User $user, Request $request)
    {
        $followers        = $user->followers()->orderBy('id', 'DESC')->get()->map(function ($savedUser) {
            return User::find($savedUser->saved_userId);
        });
        $followers        = $followers->filter(function ($value) {
            return $value !== null;
        });
        $checkFollower    = SavedUsers::where('saved_userId', auth()->user()->id)->where('userId', $user->id)->get()->isEmpty();
        $ads              = Ads::where('userId', $user->id)
            ->availableForSale()
            ->get();
        $activitiesSeller = $user->getActivity('seller');
        $activitiesBuyer  = $user->getActivity('buyer');

        if (!empty($request->activity)) {
            switch ($request->activity) {
                case 'buyer':
                    $activity = Activity::where('buyer_id', $user->id)
                        ->orderby('id', 'DESC')
                        ->where('status', '=', 'success')
                        ->whereNotNull('seller_mark')->get();
                    break;
                case 'seller':
                    $activity = Activity::where('seller_id', $user->id)
                        ->orderby('id', 'DESC')
                        ->where('status', '=', 'success')
                        ->whereNotNull('buyer_mark')->get();
                    break;
                default:
                    abort(404);
            }

            return view('site.profile.activity', compact('user', 'activitiesSeller', 'activitiesBuyer', 'checkFollower', 'activity'));
        }

        return view('site.profile.index', compact('user', 'ads', 'checkFollower', 'followers', 'activitiesSeller', 'activitiesBuyer'));
    }

    public function followersList(User $user)
    {
        $followers        = $user->followers()->orderBy('id', 'DESC')->get()->map(function ($savedUser) {
            return User::find($savedUser->saved_userId);
        });
        $followers        = $followers->filter(function ($value) {
            return $value !== null;
        });
        $checkFollower    = SavedUsers::where('saved_userId', auth()->user()->id)->where('userId', $user->id)->get()->isEmpty();
        $ads              = Ads::where('userId', $user->id)->availableForSale()->get();
        $activitiesSeller = $user->getActivity('seller');
        $activitiesBuyer  = $user->getActivity('buyer');

        return view('site.profile.followers-list', compact(
            'user',
            'followers',
            'checkFollower',
            'ads',
            'activitiesSeller',
            'activitiesBuyer'
        ));
    }

    public function follower($userId)
    {
        if (Auth::id() === null) {
            return redirect()->back()->with('status', 'You are not authorized');
        }

        $user       = auth()->user();
        $secondUser = User::find($userId);

        $follower = SavedUsers::where('saved_userId', Auth::id())->where('userId', $userId);
        $url      = route('profile.show', $user->id);
        $picture  = [
            'src'  => $user->avatar,
            'link' => $url,
        ];

        if ($follower->get()->isEmpty()) {
            SavedUsers::create([
                'userId'       => $userId,
                'saved_userId' => Auth::id(),
            ]);

            $secondUser->saveNotification('<a href="' . $url . '">' . $user->name . '</a> started to follow you!', $picture);

            return response()->json([
                'success' => 'success',
                'action'  => 'subscribed',
                'message' => 'You have subscribed to this user',
            ]);
        } else {
            $follower->delete();

            $secondUser->saveNotification('<a href="' . $url . '">' . $secondUser->name . '</a> is no longer following you!', $picture);

            return response()->json([
                'success' => 'success',
                'action'  => 'unsubscribed',
                'message' => 'You are unsubscribed from this user',
            ]);
        }
    }

    public function getFollowers($userId)
    {
        $user = User::find($userId);

        $followers = [];
        foreach ($user->followers->sortByDesc('id') as $item) {
            $user = User::find($item->saved_userId);
            if ($user !== null) {
                $followers[] = [
                    'id'     => $user->id,
                    'avatar' => $user->avatar
                ];
            }
        }

        return response()->json([
            'success'   => 'success',
            'followers' => array_reverse($followers),
        ]);
    }

    public function generalSettings(Request $request)
    {
        $user = auth()->user();

        $countries = Country::where('name', 'Netherlands')->get();
        $cities    = $countries->first()->cities ?? [];

        if ($request->isMethod('post')) {
            $request->validate([
                'general.name'            => 'required|string|min:3',
                'general.city'            => 'required|string|min:3',
                'general.receiving_money' => 'required|string',
                'general.delivery'        => 'required|string',
            ]);

            $user->update($request->general);

            return redirect()->back()->with('status', Language::lang('Profile information has been successfully changed'));
        }

        return view('site.profile.settings.general', compact('user', 'countries', 'cities'));
    }

    public function password(Request $request)
    {
        $user = auth()->user();

        if ($request->isMethod('put')) {
            $request->validate([
                'current_password' => ['required', 'string', new CurrentPassword()],
                'new_password'     => 'required|string|confirmed|min:6',
            ]);

            $user->update([
                'password' => bcrypt($request->new_password)
            ]);

            return redirect()->back()->with('status', Language::lang('Password has been successfully changed'));
        }

        return view('site.profile.settings.password', compact('user'));
    }

    public function profilePhoto(Request $request)
    {
        $user = auth()->user();

        if ($request->has('file') && $request->file !== null) {
            $request->validate(['file' => ['required', 'string', new ImageExtension]]);

            $user->update(['avatar' => $request->file]);

            return redirect()->back()->with('success', 'Profile image was updated');
        }

        return view('site.profile.settings.photo', compact('user'));
    }

    public function profileEmail(Request $request)
    {
        $user = auth()->user();

        if ($request->all()) {
            $request->validate([
                'email' => 'required|email|unique:users,email,' . $user->id
            ]);

            $user->update(['email' => $request->email, 'show_email' => $request->show_email ?? 0]);
            return redirect()->back();
        }

        return view('site.profile.settings.email', compact('user'));
    }

    public function blockedUsers()
    {
        $blockedUsers = auth()->user()->blockedUsers;

        $users = User::all()->filter(function ($item) use ($blockedUsers) {
            return !$blockedUsers->contains('id', $item->id);
        });

        return view('site.profile.settings.blocked-users', compact('users', 'blockedUsers'));
    }

    public function updateBlockedUsers(Request $request)
    {
        $blockedUsers = auth()->user()->blockedUsers();

        if (isset($request->id) && isset($request->action)) {
            switch ($request->action) {
                case 'add':
                    $blockedUsers->attach([$request->id]);
                    break;
                case 'remove':
                    $blockedUsers->detach([$request->id]);
                    break;
            }

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function readNotifications(Request $request)
    {
        Auth::user()->readNotifications($request->ids);

        $response = $this->formatResponse('success', null);
        return response($response, 200);
    }

    public function deleteNotification(Request $request)
    {
        Auth::user()->deleteNotification($request->id);

        $response = $this->formatResponse('success', null);
        return response($response, 200);
    }

    public function deleteAccount()
    {
        $user = User::find(auth()->id());
        $user->delete();

        return redirect()->route('logout');
    }
}
