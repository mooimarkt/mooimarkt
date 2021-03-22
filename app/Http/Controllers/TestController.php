<?php

namespace App\Http\Controllers;

use Location;
use DateTime;
use Image;
use App\TranslatorTranslations;
use App\AdsImages;
use App\User;
use App\Category;
use App\SubCategory;
use App\Ads;
use App\Wishlist;
use App\FormField;
use App\FormFieldOption;
use App\SearchCriteria;
use App\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Mail\SearchALertMail;
use App\Mail\PublishAdsMail;
use App\Mail\AdsRemindMail;
use App\Mail\ExpireMail;
use App\Mail\ForgetPasswordMail;
use App\Mail\VerifyUserMail;
use App\Mail\FeedbackReplyMail;
use Share;
use Carbon\Carbon;
use App\Http\Controllers\Controller as BaseController;

class TestController extends BaseController
{
	public function getIp(Request $request){

        //$encryptedUserId = \Crypt::encryptString($user->id);
        //\Crypt::decryptString($encryptedUserId);

        
        // $ads = Ads::find(111);
        // $password = "1234@#$%ABC";
        // $encryptedUserId = "12";
        // $timeStamp = Carbon::now()->timestamp;

        // Mail::to('demouser1997@gmail.com')->send(new ExpireMail( $ads, $user, 4 ));
        // Mail::to('demouser1997@gmail.com')->send(new ForgetPasswordMail($user, $password));
        // Mail::to('demouser1997@gmail.com')->send(new AdsRemindMail( $ads, $user ));
        // Mail::to('demouser1997@gmail.com')->send(new PublishAdsMail( $user, $ads ));
        // Mail::to('demouser1997@gmail.com')->send(new WelcomeMail($user));
        // Mail::to('demouser1997@gmail.com')->send(new VerifyUserMail($user, $encryptedUserId));
        // Mail::to('demouser1997@gmail.com')->send(new FeedbackReplyMail(1523036305));

        //Search Criteria

        // $allSC = DB::table('search_criteria')
        //             ->whereNull('deleted_at')
        //             ->get();


        // foreach($allSC as $searchCriteria){

        //     $allAds = DB::select(DB::raw($searchCriteria->searchQuery));
        //     $resultsCount = count($allAds);

        //     $user = User::find($searchCriteria->userId);
        //     $searcCriteriaModel = SearchCriteria::find($searchCriteria->id);

        //     Mail::to($user->email)->send(new SearchALertMail($allAds, $user, $searcCriteriaModel));
        // }


        // Ads Reminder Mail

        // $Allads = DB::table('ads')
        //         ->where('adsPlaceMethod', 'draft')
        //         ->where('adsStatus', 'available')
        //         ->get();

        // foreach($Allads as $ad){

        //     $user = User::find($ad->userId);
        //     $ads = Ads::find($ad->id);

        //     Mail::to($user->email)->send(new AdsRemindMail( $ads, $user ));
        // }



        //Expire 4 days remind

        // $dueDate4days1 = date("Y-m-d 00:00:00", strtotime('+4 days'));
        // $dueDate4days2 = date("Y-m-d 23:59:59", strtotime('+4 days'));

        // $allExpireAds = DB::table('ads')
        //         ->where('dueDate', '>', $dueDate4days1)
        //         ->where('dueDate', '<', $dueDate4days2)
        //         ->where('adsPlaceMethod', 'draft')
        //         ->where('adsStatus', 'available')
        //         ->get();

        // foreach($allExpireAds as $ad){

        //     $user = User::find($ad->userId);
        //     $ads = Ads::find($ad->id);

        //     Mail::to($user->email)->send(new ExpireMail( $ads, $user, 4 ));
        // }




        //Expire 15 days remind

        // $dueDate15days1 = date("Y-m-d 00:00:00", strtotime('+15 days'));
        // $dueDate15days2 = date("Y-m-d 23:59:59", strtotime('+15 days'));

        // $allExpireAds = DB::table('ads')
        //         ->where('dueDate', '>', $dueDate15days1)
        //         ->where('dueDate', '<', $dueDate15days2)
        //         ->where('adsPlaceMethod', 'draft')
        //         ->where('adsStatus', 'available')
        //         ->get();

        // foreach($allExpireAds as $ad){

        //     $user = User::find($ad->userId);
        //     $ads = Ads::find($ad->id);

        //     Mail::to($user->email)->send(new ExpireMail( $ads, $user, 15 ));
        // }
        

        //return $current_time;

        //Mail::to($user->email)->send(new ExpireMail( $ads, $user, 15 ));
        //Mail::to($user->email)->send(new SearchALertMail($allAds, $user, $searcCriteriaModel));
        //$user = User::find(35);
        //$ads = Ads::find(106);
        //Mail::to($user->email)->send(new AdsRemindMail( $ads, $user ))0

        app('App\Http\Controllers\AdsController')->cronSendCompleteAdsMail();
        app('App\Http\Controllers\AdsController')->cronSendExpireMail();
        app('App\Http\Controllers\User\SearchAlertController')->cronSendSearchAlertMail(1);
    }

    public function arrayPaginator($array, $request, $perPage, $url, $path){

        $page = Input::get('page', 1);
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page, ['path' => $path, 'query' => $url ]);
    }

    public function postIp(Request $request){

  

        return response()->json([ 'resultView' => $view, 'success' => 'success', 'asd' => $fullQuery]);
    }

}


