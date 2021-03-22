<?php

namespace App\Http\Controllers;

use Faker\Factory;
use Illuminate\Http\Request;
use App\Services\SocialFacebookAccountService;
use Socialite;
use Illuminate\Support\Facades\Storage;

class SocialAuthFacebookController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(Request $request, SocialFacebookAccountService $service)
    {
        if (!$request->input('code')) {
            return redirect()->to('/')->withErrors('Login failed: '.$request->input('error').' - '.$request->input('error_reason'));
        }
        $state = $request->get('state');
        $request->session()->put('state',$state);

        $provider = Socialite::driver('facebook');
        $soc_user = $provider->user();
        if(!$soc_user->email){
            $soc_user->email = (Factory::create())->email;
        }
        if(!$soc_user->email){
            $faker = Factory::create();
            $soc_user->email = $faker->uniqueEmail;
        }
        if(!$soc_user->getEmail()){
            return redirect()->to( '/' )->with( [ "error" => "Email cannot be accessed." ] );
        }

        $user = $service->createOrGetUser($soc_user);
		if((!$user->avatar || strpos($user->avatar, 'empty_user_img')) && $soc_user->getAvatar()){
            $fileContents = file_get_contents('https://graph.facebook.com/v3.3/'.$soc_user->id.'/picture?type=large&access_token='. $soc_user->token);
            Storage::disk('public')->put('profile/'.$user->id . ".jpg", $fileContents, 'public');
            $user->avatar = '/storage/profile/' . $user->id . ".jpg";
            $user->save();
        }
        auth()->login($user);

        return redirect()->to('/');
    }
}
