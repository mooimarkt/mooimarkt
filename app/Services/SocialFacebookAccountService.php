<?php
namespace App\Services;
use App\SocialAccount;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Illuminate\Support\Facades\DB;
class SocialFacebookAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = SocialAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->orderBy('id', 'asc')
            ->first();

        if ($account) {

	        if(is_null(User::find($account->user))){

		        $account->provider_user_id = "unset";

		        $user = new User;
		        $user->email = $providerUser->getEmail();
		        $user->name = $providerUser->getName();
		        $user->password = md5(rand(1,10000));
		        $user->userRole = 'unset';
		        $user->isSocial = "true";
		        $user->save();

		        $account = new SocialAccount;
		        $account->provider_user_id = $providerUser->getId();
		        $account->provider = 'google';
		        $account->user_id = $user->id;
		        $account->save();
		        return $user;
	        }

            return $account->user;
        } else {

            $user = new User;
            $user->email = $providerUser->getEmail();
            $user->name = $providerUser->getName();
            $user->password = md5(rand(1,10000));
            $user->userRole = 'unset';
            $user->isSocial = "true";
            $user->save();

            $account = new SocialAccount;
            $account->provider_user_id = $providerUser->getId();
            $account->provider = 'facebook';
            $account->user_id = $user->id;
            $account->save();
            return $user;
        }
    }
}