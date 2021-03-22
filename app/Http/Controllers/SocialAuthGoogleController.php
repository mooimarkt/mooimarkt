<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Services\SocialGoogleAccountService;

class SocialAuthGoogleController extends Controller
{
   /**
   * Create a redirect method to facebook api.
   *
   * @return void
   */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    /**
     * Return a callback method from facebook api.
     *
     * @return callback URL from facebook
     */
    public function callback(Request $request, SocialGoogleAccountService $service)
    {

        $state = $request->get('state');
        $request->session()->put('state',$state);

        $user = $service->createOrGetUser(Socialite::driver('google')->user());

        auth()->login($user);
        return redirect()->to('/');
    }
}
