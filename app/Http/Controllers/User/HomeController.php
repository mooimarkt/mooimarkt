<?php

namespace App\Http\Controllers\User;

use App\Ads;
use App\AdsImages;
use App\AdsView;
use App\Category;
use App\Filter;
use App\FormFieldOption;
use App\Http\Controllers\Controller as BaseController;
use App\SearchCriteria;
use App\SubCategory;
use App\User;
use App\Wishlist;
use App\Option;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Location;

class HomeController extends BaseController
{
    public $locale;

    public function __construct()
    {
        $this->locale = session()->get('locale');
    }

    /**
     * Display a home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Ads::with(['images'])->withCount(['userViews', 'favorites'])->where('adsStatus', 'payed')
            ->where('parent_id', '=', null) // hide child ads
            ->orderBy('ads.created_at', 'desc')
            ->take(8)
            ->get();

        $adsDatasArray = array();
        foreach ($ads as $singleAds) {
            $adsDatas = DB::table('ads_datas')
                ->join('form_fields', 'form_fields.id', '=', 'ads_datas.formFieldId')
                ->join('translator_translations', 'translator_translations.item', 'ads_datas.adsValue')
                ->where('ads_datas.adsId', $singleAds->id)
                ->get();

            if (count($adsDatas) > 0) {
                $adsDatasArray[$singleAds->id] = $adsDatas;
            }
        }

        $categories = Category::select('categories.*', DB::raw('COUNT(ads.id) as adsnum'))
            ->leftJoin('sub_categories', 'categories.id', '=', 'sub_categories.categoryId')
            ->leftJoin('ads', function ($join) {
                $join->on('sub_categories.id', '=', 'ads.subCategoryId');
                $join->whereNull('ads.deleted_at');
                $join->where('ads.adsStatus', 'payed');
            })
            ->groupBy('categories.id')
            ->orderBy('categoryStatus', 'desc')
            ->get();

        $slider = json_decode(Option::getSetting("opt_slider")) ?? [];

        return view('site.index', [
            'categories'    => $categories,
            'ads'           => $ads,
            'adsDatasArray' => $adsDatasArray,
            'slider'        => $slider
        ]);
    }

    public function getAllAds(Request $request)
    {
        $latitude  = 0;
        $longitude = 0;

        $ads = Ads::where('adsStatus', '!=', 'unavailable')
            ->where('ads.adsPlaceMethod', 'publish')
            ->whereDate('ads.dueDate', ">", date("Y-m-d H:i:s"))
            ->orderBy('sortingDate', 'desc')
            ->paginate(12);

        $resultsCount = Ads::where('adsStatus', '!=', 'unavailable')
            ->where('ads.adsPlaceMethod', 'publish')
            ->whereDate('ads.dueDate', ">", date("Y-m-d H:i:s"))
            ->count();

        if (Auth::check()) {
            $userId = Auth::user()->id;
            $user   = User::find($userId);

            DB::table('social_accounts')
                ->where('social_accounts.user_id', '=', $userId)
                ->get();

            $countriesList = DB::table('world_countries')->pluck('name');

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
        } else {
            $user = new User;

            $countriesList = DB::table('world_countries')->pluck('name');
            $states        = 'none';
        }

        if (Auth::check()) {
            $favourite = Wishlist::where('userId', Auth::user()->id)->get();
        } else {
            $favourite = 'none';
        }

        $category = Category::all();

        $searchId = $request->input('searchId');

        if ($searchId != "") {
            $fromSearchCriteria = $searchId;
            $searchCriteria     = SearchCriteria::where('id', $searchId)->first();

            $request->session()->put('locale', $searchCriteria->locale);
        } else {
            $fromSearchCriteria = false;
        }

        $currency = DB::table('currency')
            ->whereNull('deleted_at')
            ->get();

        $adsDatasArray = array();

        foreach ($ads as $singleAds) {
            $adsDatas = DB::table('ads_datas')
                ->join('form_fields', 'form_fields.id', '=', 'ads_datas.formFieldId')
                ->join('translator_translations', 'translator_translations.item', 'ads_datas.adsValue')
                ->where('locale', session()->get('locale'))
                ->where('group', 'options')
                ->whereNull('ads_datas.deleted_at')
                ->whereNull('form_fields.deleted_at')
                ->where('ads_datas.adsId', $singleAds->id)
                ->where('form_fields.displaySort', '>', 0)
                ->where('form_fields.displaySort', '<', 999)
                ->orderBy('form_fields.displaySort', 'desc')
                ->get();

            if (count($adsDatas) > 0) {
                $adsDatasArray[$singleAds->id] = $adsDatas;
            }
        }

        return view('user/browse', [
            "user"               => $user,
            "countriesList"      => $countriesList,
            'fromSearchCriteria' => $fromSearchCriteria,
            'states'             => $states,
            'ads'                => $ads,
            'resultsCount'       => $resultsCount,
            'favourite'          => $favourite,
            'searchType'         => 'all',
            'searchData'         => 'all',
            'latitude'           => $latitude,
            'longitude'          => $longitude,
            'category'           => $category,
            'currency'           => $currency,
            'adsDatas'           => $adsDatasArray
        ]);
    }

    public function getAllAdsWithMailSearchAlert(Request $request, $encryptSearchId)
    {
        $searchId = \Crypt::decryptString($encryptSearchId);

        $latitude  = 0;
        $longitude = 0;

        $ads = Ads::where('adsStatus', '!=', 'unavailable')
            ->where('ads.adsPlaceMethod', 'publish')
            ->whereDate('ads.dueDate', ">", date("Y-m-d H:i:s"))
            ->orderBy('sortingDate', 'desc')
            ->paginate(12);

        $resultsCount = Ads::where('adsStatus', '!=', 'unavailable')
            ->where('ads.adsPlaceMethod', 'publish')
            ->whereDate('ads.dueDate', ">", date("Y-m-d H:i:s"))
            ->count();

        if (Auth::check()) {
            $userId = Auth::user()->id;
            $user   = User::find($userId);

            $socialAcounts = DB::table('social_accounts')
                ->where('social_accounts.user_id', '=', $userId)
                ->get();

            $countriesList = DB::table('world_countries')->pluck('name');

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
        } else {
            $user = new User;

            $countriesList = DB::table('world_countries')->pluck('name');
            $states        = 'none';
        }

        if (Auth::check()) {
            $favourite = Wishlist::where('userId', Auth::user()->id)
                ->get();
        } else {
            $favourite = 'none';
        }

        $category = Category::all();

        $fromSearchCriteria = $searchId;

        $searchCriteria = SearchCriteria::where('id', $searchId)
            ->first();

        $request->session()->put('locale', $searchCriteria->locale);

        $currency = DB::table('currency')
            ->whereNull('deleted_at')
            ->get();

        $adsDatasArray = array();

        foreach ($ads as $singleAds) {

            $adsDatas = DB::table('ads_datas')
                ->join('form_fields', 'form_fields.id', '=', 'ads_datas.formFieldId')
                ->join('translator_translations', 'translator_translations.item', 'ads_datas.adsValue')
                ->where('locale', session()->get('locale'))
                ->where('group', 'options')
                ->whereNull('ads_datas.deleted_at')
                ->whereNull('form_fields.deleted_at')
                ->where('ads_datas.adsId', $singleAds->id)
                ->where('form_fields.displaySort', '>', 0)
                ->where('form_fields.displaySort', '<', 999)
                ->orderBy('form_fields.displaySort', 'desc')
                ->get();

            if (count($adsDatas) > 0) {

                $adsDatasArray[$singleAds->id] = $adsDatas;
            }

        }

        return view('user/browse', [
            "user"               => $user,
            "countriesList"      => $countriesList,
            'fromSearchCriteria' => $fromSearchCriteria,
            'states'             => $states,
            'ads'                => $ads,
            'resultsCount'       => $resultsCount,
            'favourite'          => $favourite,
            'searchType'         => 'all',
            'searchData'         => 'all',
            'latitude'           => $latitude,
            'longitude'          => $longitude,
            'category'           => $category,
            'currency'           => $currency,
            'adsDatas'           => $adsDatasArray
        ]);

    }

    public function getAdsBySubCategory(Request $request, $id)
    {

        $latitude  = 0;
        $longitude = 0;

        $ads = DB::table('sub_categories')
            ->join('ads', 'ads.subCategoryId', '=', 'sub_categories.id')
            ->where('adsStatus', '!=', 'unavailable')
            ->where('ads.adsPlaceMethod', 'publish')
            ->where('ads.subCategoryId', $id)
            ->whereNull('sub_categories.deleted_at')
            ->whereDate('ads.dueDate', ">", date("Y-m-d H:i:s"))
            ->orderBy('sortingDate', 'desc')
            ->paginate(12);

        $resultsCount = DB::table('sub_categories')
            ->join('ads', 'ads.subCategoryId', '=', 'sub_categories.id')
            ->where('adsStatus', '!=', 'unavailable')
            ->where('ads.adsPlaceMethod', 'publish')
            ->where('ads.subCategoryId', $id)
            ->whereNull('sub_categories.deleted_at')
            ->whereDate('ads.dueDate', ">", date("Y-m-d H:i:s"))
            ->orderBy('ads.created_at', 'desc')
            ->count();

        $subCategoryName = Subcategory::where('id', $id)
            ->value('subCategoryName');
        $categoryId      = Subcategory::where('id', $id)
            ->value('categoryId');
        $categoryName    = Category::where('id', $categoryId)
            ->value('categoryName');

        $request->session()->put('subCategoryIdForBreadcrumb', $id);
        $request->session()->put('subCategoryNameForBreadcrumb', $subCategoryName);
        $request->session()->put('categoryIdForBreadcrumb', $categoryId);
        $request->session()->put('categoryNameForBreadcrumb', $categoryName);

        if (Auth::check()) {
            $userId = Auth::user()->id;
            $user   = User::find($userId);

            $socialAcounts = DB::table('social_accounts')
                ->where('social_accounts.user_id', '=', $userId)
                ->get();

            $countriesList = DB::table('world_countries')->pluck('name');

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
        } else {
            $user = new User;

            $countriesList = DB::table('world_countries')->pluck('name');
            $states        = 'none';
        }

        if (Auth::check()) {
            $favourite = Wishlist::where('userId', Auth::user()->id)
                ->get();
        } else {
            $favourite = 'none';
        }

        $currency = DB::table('currency')
            ->whereNull('deleted_at')
            ->get();

        $category = Category::all();

        $adsDatasArray = array();

        foreach ($ads as $singleAds) {

            $adsDatas = DB::table('ads_datas')
                ->join('form_fields', 'form_fields.id', '=', 'ads_datas.formFieldId')
                ->join('translator_translations', 'translator_translations.item', 'ads_datas.adsValue')
                ->where('locale', session()->get('locale'))
                ->where('group', 'options')
                ->whereNull('ads_datas.deleted_at')
                ->whereNull('form_fields.deleted_at')
                ->where('ads_datas.adsId', $singleAds->id)
                ->where('form_fields.displaySort', '>', 0)
                ->where('form_fields.displaySort', '<', 999)
                ->orderBy('form_fields.displaySort', 'desc')
                ->get();

            if (count($adsDatas) > 0) {

                $adsDatasArray[$singleAds->id] = $adsDatas;
            }

        }

        return view('user/browse', [
            "user"               => $user,
            "countriesList"      => $countriesList,
            'states'             => $states,
            'fromSearchCriteria' => 'none',
            'ads'                => $ads,
            'resultsCount'       => $resultsCount,
            'favourite'          => $favourite,
            'searchType'         => 'subCategory',
            'searchData'         => $id,
            'latitude'           => $latitude,
            'longitude'          => $longitude,
            'category'           => $category,
            'currency'           => $currency,
            'adsDatas'           => $adsDatasArray
        ]);
    }

    public function getAdsByCategory(Request $request, $id)
    {

        $latitude  = 0;
        $longitude = 0;

        $ads = DB::table('sub_categories')
            ->join('ads', 'ads.subCategoryId', '=', 'sub_categories.id')
            ->where('sub_categories.categoryId', $id)
            ->where('ads.adsStatus', '!=', 'unavailable')
            ->where('ads.adsPlaceMethod', 'publish')
            ->whereNull('sub_categories.deleted_at')
            ->whereDate('ads.dueDate', ">", date("Y-m-d H:i:s"))
            ->orderBy('sortingDate', 'desc')
            ->paginate(12);

        /*		$resultsCount = DB::table( 'sub_categories' )
                                  ->join( 'ads', 'ads.subCategoryId', '=', 'sub_categories.id' )
                                  ->where( 'sub_categories.categoryId', $id )
                                  ->where( 'ads.adsStatus', '!=', 'unavailable' )
                                  ->where( 'ads.adsPlaceMethod', 'publish' )
                                  ->whereNull( 'sub_categories.deleted_at' )
                                  ->whereDate( 'ads.dueDate', ">", date( "Y-m-d H:i:s" ) )
                                  ->orderBy( 'ads.created_at', 'desc' )
                                  ->count();

                $categoryName = Category::where( 'id', $id )
                                        ->value( 'categoryName' );

                $request->session()->put( 'categoryNameForBreadcrumb', $categoryName );
                $request->session()->put( 'categoryIdForBreadcrumb', $id );

                if ( Auth::check() ) {
                    $userId = Auth::user()->id;
                    $user   = User::find( $userId );

                    $socialAcounts = DB::table( 'social_accounts' )
                                       ->where( 'social_accounts.user_id', '=', $userId )
                                       ->get();

                    $countriesList = DB::table( 'world_countries' )->pluck( 'name' );

                    if ( $user->country == null ) {
                        $states = 'none';
                    } else {

                        if ( $user->region == "none" ) {

                            $states = "none";
                        } else {

                            try {
                                $states = DB::table( 'world_countries' )
                                            ->join( 'states', 'states.country_id', 'world_countries.id' )
                                            ->whereRaw( 'LOWER(world_countries.name) like LOWER("%' . $user->country . '%")' )
                                            ->orderBy( 'states.name', 'asc' )
                                            ->pluck( 'states.name' );
                            } catch ( \Exception $e ) {
                                $states = 'nostate';
                            }
                        }
                    }
                } else {
                    $user = new User;

                    $countriesList = DB::table( 'world_countries' )->pluck( 'name' );
                    $states        = 'none';
                }

                if ( Auth::check() ) {
                    $favourite = Wishlist::where( 'userId', Auth::user()->id )
                                         ->get();
                } else {
                    $favourite = 'none';
                }

                $currency = DB::table( 'currency' )
                              ->whereNull( 'deleted_at' )
                              ->get();

                $category = Category::all();

                $adsDatasArray = array();

                foreach ( $ads as $singleAds ) {

                    $adsDatas = DB::table( 'ads_datas' )
                                  ->join( 'form_fields', 'form_fields.id', '=', 'ads_datas.formFieldId' )
                                  ->join( 'translator_translations', 'translator_translations.item', 'ads_datas.adsValue' )
                                  ->where( 'locale', session()->get( 'locale' ) )
                                  ->where( 'group', 'options' )
                                  ->whereNull( 'ads_datas.deleted_at' )
                                  ->whereNull( 'form_fields.deleted_at' )
                                  ->where( 'ads_datas.adsId', $singleAds->id )
                                  ->where( 'form_fields.displaySort', '>', 0 )
                                  ->where( 'form_fields.displaySort', '<', 999 )
                                  ->orderBy( 'form_fields.displaySort', 'desc' )
                                  ->get();

                    if ( count( $adsDatas ) > 0 ) {

                        $adsDatasArray[ $singleAds->id ] = $adsDatas;
                    }

                }

                return view( 'user/browse', [
                    "user"               => $user,
                    "countriesList"      => $countriesList,
                    'fromSearchCriteria' => 'none',
                    'states'             => $states,
                    'ads'                => $ads,
                    'resultsCount'       => $resultsCount,
                    'favourite'          => $favourite,
                    'searchType'         => 'category',
                    'category'           => $category,
                    'latitude'           => $latitude,
                    'longitude'          => $longitude,
                    'searchData'         => $id,
                    'currency'           => $currency,
                    'adsDatas'           => $adsDatasArray
                ] );*/

    }

    public function getAdsDetails(Request $request, $id)
    {

        $adsName         = Ads::where('id', $id)
            ->value('adsName');
        $subCategoryId   = Ads::where('id', $id)
            ->value('subCategoryId');
        $subCategoryName = Subcategory::where('id', $subCategoryId)
            ->value('subCategoryName');
        $categoryId      = Subcategory::where('id', $subCategoryId)
            ->value('categoryId');
        $categoryName    = Category::where('id', $categoryId)
            ->value('categoryName');

        $request->session()->put('adsNameForBreadcrumb', $adsName);
        $request->session()->put('subCategoryIdForBreadcrumb', $subCategoryId);
        $request->session()->put('subCategoryNameForBreadcrumb', $subCategoryName);
        $request->session()->put('categoryIdForBreadcrumb', $categoryId);
        $request->session()->put('categoryNameForBreadcrumb', $categoryName);

        $request->session()->put('adsIdForBreadcrumb', $id);

        $images = AdsImages::where('adsId', $id)->get();

        $ip = $request->ip();

        $checkNullAdsView = AdsView::where('adsId', $id)
            ->where('ipAddress', $ip)
            ->where('viewAfter', 'true')
            ->get();

        $currentAdsViewId = AdsView::where('adsId', $id)
            ->where('ipAddress', $ip)
            ->where('viewAfter', 'true')
            ->value('id');

        if (count($checkNullAdsView) < 1) {

            $adsView            = new AdsView;
            $adsView->adsId     = $id;
            $adsView->ipAddress = $ip;
            $adsView->viewAfter = 'true';
            $adsView->save();

        } else if (count($checkNullAdsView) > 0) {

            $today = date("Y-m-d H:i:s", strtotime('-1 days'));

            $adsViewCreatedAt = AdsView::where('adsId', $id)
                ->where('ipAddress', $ip)
                ->where('created_at', '>=', $today)
                ->get();

            if (count($adsViewCreatedAt) <= 0) {

                $currentAdsView            = AdsView::find($currentAdsViewId);
                $currentAdsView->viewAfter = "false";
                $currentAdsView->save();

                $adsView            = new AdsView;
                $adsView->adsId     = $id;
                $adsView->ipAddress = $ip;
                $adsView->viewAfter = 'true';
                $adsView->save();
            }

        }

        $ads = DB::table('ads')
            ->join('sub_categories', 'sub_categories.id', '=', 'ads.subCategoryId')
            ->join('users', 'users.id', '=', 'ads.userId')
            ->where('ads.id', $id)
            ->where('ads.adsStatus', '!=', 'unavailable')
            ->where('ads.adsPlaceMethod', 'publish')
            ->whereNull('ads.deleted_at')
            ->whereNull('sub_categories.deleted_at')
            ->whereNull('users.deleted_at')
            ->select('ads.id', 'ads.dueDate', 'ads.sortingDate', 'ads.adsCallingCode', 'ads.adsName', 'ads.userId', 'ads.userId', 'ads.adsRegion', 'ads.adsCountry', 'ads.adsContactNo', 'ads.adsImage', 'ads.adsPriceType', 'ads.adsPrice', 'ads.adsDescription', 'sub_categories.subCategoryName', 'users.name', 'users.email', 'users.phoneContactType', 'users.emailContactType')
            ->get();

        if (!session()->get('locale')) {
            session()->put('locale', 'en');
        }
        $adsDatas = DB::table('ads')
            ->join('ads_datas', 'ads_datas.adsId', '=', 'ads.id')
            ->join('translator_translations', 'translator_translations.item', 'ads_datas.adsValue')
            ->join('form_fields', 'form_fields.id', 'ads_datas.formFieldId')
            ->where('locale', session()->get('locale'))
            ->where('group', 'options')
            ->whereNull('ads.deleted_at')
            ->whereNull('ads_datas.deleted_at')
            ->whereNull('form_fields.deleted_at')
            ->orderBy('form_fields.sort', 'asc')
            ->where('ads_datas.adsId', $id)
            ->get();

        $adsCount = AdsView::where('adsId', $id)->count();


        $adsQuery = Ads::find($id);
        $check    = "";

        if (Auth::check()) {

            if ($adsQuery->userId == Auth::user()->id) {

                $check = "true";
            } else {

                $check = "false";
            }
        } else {

            $check = "false";
        }


        $summaryString = "";
        foreach ($adsDatas as $adsData) {
            $summaryString .= $adsData->adsValue . " | ";
        }

        $summaryString .= $categoryName . " | " . $subCategoryName;
        $summaryString .= " | " . $ads[0]->adsDescription;

        //dd($summaryString);

        return view('user/adsdetails', [
            "images"        => $images,
            "ads"           => $ads,
            "adsDatas"      => $adsDatas,
            "check"         => $check,
            "adsCount"      => $adsCount,
            'summaryString' => $summaryString
        ]);
    }

    public function getAdsByName(Request $request, $name)
    {

        $latitude  = 0;
        $longitude = 0;

        $keywordArray = explode(' ', $name);

        $tagAds   = DB::table('tag');
        $adsTempo = DB::table('ads');

        foreach ($keywordArray as $keyword) {

            $tagAds->orWhere('tagValue', 'like', '%' . $keyword . '%');
            $tagQuery[] = "tagValue LIKE '%" . $keyword . "%'";

            //$adsTempo->Where("adsName","like",'%'.$keyword.'%');
        }

        if ($tagQuery) {
            $tagFullQuery = "SELECT count(*) as result,adsId FROM `tag` WHERE (" . implode(" OR ", $tagQuery) . ") AND type != 'hidden' GROUP BY adsId HAVING result >= " . count($tagQuery);
        }
        //dd($tagFullQuery);
        $resultsAdsIdList = DB::select(DB::raw($tagFullQuery));


        //$tagAds->where("type","!=","hidden");

        //$resultsAdsIdList = $tagAds->select('adsId')->get();


        if (count($resultsAdsIdList) > 0) {

            foreach ($resultsAdsIdList as $id) {
                $tagIDAry[] = $id->adsId;
                //$adsTempo->orWhere('id', $id->adsId)
                /*->where('adsStatus', '!=',   'unavailable')
                         ->where('ads.adsPlaceMethod', 'publish')
                         ->whereDate('ads.dueDate', ">",date("Y-m-d H:i:s"))
                         ->orderBy('sortingDate', 'desc');*/
            }

            $adsTempo->where(function ($query) use ($tagIDAry, $keywordArray) {
                foreach ($keywordArray as $keyword) {
                    $query->where(function ($query2) use ($keyword) {
                        $query2->Where("adsName", "like", '%' . $keyword . '%');
                    });

                }
                $query->orWhereIn("id", $tagIDAry);
            });

            $adsTempo->where(function ($query) {
                $query->where('adsStatus', '!=', 'unavailable')
                    ->where('ads.adsPlaceMethod', 'publish')
                    ->whereDate('ads.dueDate', ">", date("Y-m-d H:i:s"));
                //->orderBy('sortingDate', 'desc');
            });
            //dd($adsTempo->toSql());
            /*$adsTempo->orWhereIn("id",$tagIDAry);
            $adsTempo->where('adsStatus', '!=',   'unavailable')
                ->where('ads.adsPlaceMethod', 'publish')
                ->whereDate('ads.dueDate', ">",date("Y-m-d H:i:s"))
                ->orderBy('sortingDate', 'desc');*/
        } else {

            $adsTempo->where(function ($query) use ($keywordArray) {
                foreach ($keywordArray as $keyword) {
                    $query->where(function ($query2) use ($keyword) {
                        $query2->Where("adsName", "like", '%' . $keyword . '%');
                    });

                }
            });

            $adsTempo->where('adsStatus', '!=', 'unavailable')
                ->where('ads.adsPlaceMethod', 'publish')
                ->whereDate('ads.dueDate', ">", date("Y-m-d H:i:s"));
            //->orderBy('sortingDate', 'desc');
        }

        $ads = $adsTempo->orderBy('sortingDate', 'DESC')
            ->paginate(12);

        $resultsCount = count($ads);

        $request->session()->put('adsNameForBreadcrumb', $name);

        if (Auth::check()) {
            $userId = Auth::user()->id;
            $user   = User::find($userId);

            $socialAcounts = DB::table('social_accounts')
                ->where('social_accounts.user_id', '=', $userId)
                ->get();

            $countriesList = DB::table('world_countries')->pluck('name');

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
        } else {
            $user = new User;

            $countriesList = DB::table('world_countries')->pluck('name');
            $states        = 'none';
        }

        if (Auth::check()) {
            $favourite = Wishlist::where('userId', Auth::user()->id)
                ->get();
        } else {
            $favourite = 'none';
        }

        $currency = DB::table('currency')
            ->whereNull('deleted_at')
            ->get();

        $category = Category::all();

        $adsDatasArray = array();

        if (count($ads) > 0) {
            foreach ($ads as $singleAds) {

                $adsDatas = DB::table('ads_datas')
                    ->join('form_fields', 'form_fields.id', '=', 'ads_datas.formFieldId')
                    ->join('translator_translations', 'translator_translations.item', 'ads_datas.adsValue')
                    ->where('locale', session()->get('locale'))
                    ->where('group', 'options')
                    ->whereNull('ads_datas.deleted_at')
                    ->whereNull('form_fields.deleted_at')
                    ->where('ads_datas.adsId', $singleAds->id)
                    ->where('form_fields.displaySort', '>', 0)
                    ->where('form_fields.displaySort', '<', 999)
                    ->orderBy('form_fields.displaySort', 'desc')
                    ->get();

                if (count($adsDatas) > 0) {

                    $adsDatasArray[$singleAds->id] = $adsDatas;
                }

            }
        }


        return view('user/browse', [
            "user"               => $user,
            "countriesList"      => $countriesList,
            'fromSearchCriteria' => 'none',
            'states'             => $states,
            'ads'                => $ads,
            'resultsCount'       => $resultsCount,
            'favourite'          => $favourite,
            'searchType'         => 'name',
            'searchData'         => $name,
            'latitude'           => $latitude,
            'longitude'          => $longitude,
            'category'           => $category,
            'currency'           => $currency,
            'adsDatas'           => $adsDatasArray,
            'searchString'       => $name
        ]);
    }

    public function filterData(Request $request)
    {

        $jsonFormFieldData = $request->input('formFieldData');
        $formFieldData     = json_decode($jsonFormFieldData);
        $searchType        = $request->input('searchType1');
        $searchData        = $request->input('searchData1');
        $currency          = $request->input('dropCurrency');
        $minPrice          = $request->input('txtMinPrice');
        $maxPrice          = $request->input('txtMaxPrice');
        $country           = $request->input('dropDownCountry');
        $region            = $request->input('dropDownRegion');
        $subCategoryId     = $request->input('subCategoryId');
        $categoryId        = $request->input('categoryId');
        $sortType          = $request->input('sortType');
        $radiusInKm        = $request->input('txtRadius');

        $latitude  = 0;
        $longitude = 0;

        if ($request->input('geolocationLongitude') == null) {
            $filterLongitude = $longitude;
        } else {
            $filterLongitude = $request->input('geolocationLongitude');
        }

        if ($request->input('geolocationLatitude') == null) {
            $filterLatitude = $latitude;
        } else {
            $filterLatitude = $request->input('geolocationLatitude');
        }

        $headQuery        = '';
        $flexiFilterQuery = '';
        $makeModelQuery   = '';
        $finalQuery       = '';
        $searchString     = array();

        if ($searchType == 'category') {

            if ($subCategoryId != "none") {
                $headQuery .= 'select ads.dueDate, ads.spotLightDate, ads.id, ads.adsImage, ads.adsName, ads.adsRegion, ads.adsCountry, ads.adsPriceType, ads.adsPrice, ads.adsPlaceMethod, ads.created_at, ads.adsStatus, ads.adsLongitude, ads.adsLatitude from ads, sub_categories';

                $flexiFilterQuery .= '(ads . subCategoryId = sub_categories . id and sub_categories . id = ' . $subCategoryId . ' and sub_categories . categoryId = ' . $searchData . ' and adsPlaceMethod = "publish" and adsStatus="available"';
            } else {
                $headQuery .= 'select ads.dueDate, ads.spotLightDate, ads.id, ads.adsImage, ads.adsName, ads.adsRegion, ads.adsCountry, ads.adsPriceType, ads.adsPrice, ads.adsPlaceMethod, ads.created_at, ads.adsStatus, ads.adsLongitude, ads.adsLatitude from ads, sub_categories';

                $flexiFilterQuery .= '(ads . subCategoryId = sub_categories . id and sub_categories . categoryId = ' . $searchData . ' and adsPlaceMethod = "publish" and adsStatus="available"';
            }
        } else if ($searchType == 'subCategory') {
            $headQuery .= 'select ads.dueDate, ads.spotLightDate, ads.id, ads.adsImage, ads.adsName, ads.adsRegion, ads.adsCountry, ads.adsPriceType, ads.adsPrice, ads.adsPlaceMethod, ads.created_at, ads.adsStatus, ads.adsLongitude, ads.adsLatitude from ads, sub_categories';

            $flexiFilterQuery .= '(ads . subCategoryId = sub_categories . id and sub_categories . id = ' . $searchData . ' and adsPlaceMethod = "publish" and adsStatus="available"';
        } else if ($searchType == 'name') {

            if ($categoryId == "none" && $subCategoryId == "none") {
                $headQuery .= 'select ads.dueDate, ads.spotLightDate, ads.id, ads.adsImage, ads.adsName, ads.adsRegion, ads.adsCountry, ads.adsPriceType, ads.adsPrice, ads.adsPlaceMethod, ads.created_at, ads.adsStatus, ads.adsLongitude, ads.adsLatitude from ads';

                $flexiFilterQuery .= '(ads.adsName LIKE "%' . $searchData . '%" and adsPlaceMethod = "publish" and adsStatus="available"';
            } else if ($categoryId != "none" && $subCategoryId == "none") {
                $headQuery .= 'select ads.dueDate, ads.spotLightDate, ads.id, ads.adsImage, ads.adsName, ads.adsRegion, ads.adsCountry, ads.adsPriceType, ads.adsPrice, ads.adsPlaceMethod, ads.created_at, ads.adsStatus, ads.adsLongitude, ads.adsLatitude from ads, sub_categories';

                $flexiFilterQuery .= '(ads.adsName LIKE "%' . $searchData . '%" and ads . subCategoryId = sub_categories . id and sub_categories . categoryId = ' . $categoryId . ' and adsPlaceMethod = "publish" and adsStatus="available"';
            } else if ($categoryId != "none" && $subCategoryId != "none") {
                $headQuery .= 'select ads.dueDate, ads.spotLightDate, ads.id, ads.adsImage, ads.adsName, ads.adsRegion, ads.adsCountry, ads.adsPriceType, ads.adsPrice, ads.adsPlaceMethod, ads.created_at, ads.adsStatus, ads.adsLongitude, ads.adsLatitude from ads, sub_categories';

                $flexiFilterQuery .= '(ads.adsName LIKE "%' . $searchData . '%" and ads . subCategoryId = sub_categories . id and sub_categories . id = ' . $subCategoryId . ' and sub_categories . categoryId = ' . $categoryId . ' and adsPlaceMethod = "publish" and adsStatus="available"';
            }
        } else if ($searchType == 'all') {

            if ($categoryId == "none" && $subCategoryId == "none") {
                $headQuery .= 'select ads.dueDate, ads.spotLightDate, ads.id, ads.adsImage, ads.adsName, ads.adsRegion, ads.adsCountry, ads.adsPriceType, ads.adsPrice, ads.adsPlaceMethod, ads.created_at, ads.adsStatus, ads.adsLongitude, ads.adsLatitude from ads';

                $flexiFilterQuery .= '(adsPlaceMethod = "publish" and adsStatus="available"';
            } else if ($categoryId != "none" && $subCategoryId == "none") {
                $headQuery .= 'select ads.dueDate, ads.spotLightDate, ads.id, ads.adsImage, ads.adsName, ads.adsRegion, ads.adsCountry, ads.adsPriceType, ads.adsPrice, ads.adsPlaceMethod, ads.created_at, ads.adsStatus, ads.adsLongitude, ads.adsLatitude from ads, sub_categories';

                $flexiFilterQuery .= '(ads . subCategoryId = sub_categories . id and sub_categories . categoryId = ' . $categoryId . ' and adsPlaceMethod = "publish" and adsStatus="available"';
            } else if ($categoryId != "none" && $subCategoryId != "none") {
                $headQuery .= 'select ads.dueDate, ads.spotLightDate, ads.id, ads.adsImage, ads.adsName, ads.adsRegion, ads.adsCountry, ads.adsPriceType, ads.adsPrice, ads.adsPlaceMethod, ads.created_at, ads.adsStatus, ads.adsLongitude, ads.adsLatitude from ads, sub_categories';

                $flexiFilterQuery .= '(ads . subCategoryId = sub_categories . id and sub_categories . id = ' . $subCategoryId . ' and sub_categories . categoryId = ' . $categoryId . ' and adsPlaceMethod = "publish" and adsStatus="available"';
            }
        }

        if ($filterLatitude && $filterLongitude && $radiusInKm != 'Any' && $radiusInKm != null && $radiusInKm > 0) {

            $flexiFilterQuery .= ' and (degrees(acos((sin(radians(adsLatitude)) * sin(radians(' . $filterLatitude . '))) + (cos(radians(adsLatitude)) * cos(radians(' . $filterLatitude . ')) * cos(radians(adsLongitude - ' . $filterLongitude . '))))) * 60 * 1.1515 * 1.609344) <= ' . $radiusInKm;

            $searchString[] = 'Distance <= ' . $radiusInKm . ' with Coordinates ' . $filterLatitude . '/' . $filterLongitude;
        }

        $conversionRate = DB::table('currency')
            ->where('currencyCode', $currency)
            ->value('conversionRate');

        if ($minPrice != "") {

            $flexiFilterQuery .= ' and adsPrice >= ' . ($minPrice * $conversionRate);
        }

        if ($maxPrice != "") {

            $flexiFilterQuery .= ' and adsPrice <= ' . ($maxPrice * $conversionRate);
        }

        if ($minPrice != "" && $maxPrice == "") {
            $searchString[] = '>=' . $currency . ' ' . number_format($minPrice, "0", ".", ",");
        } else if ($minPrice == "" && $maxPrice != "") {
            $searchString[] = '<=' . $currency . ' ' . number_format($maxPrice, "0", ".", ",");
        } else if ($minPrice != "" && $maxPrice != "") {
            $searchString[] = $currency . ' ' . number_format($minPrice, "0", ".", ",") . ' to ' . number_format($maxPrice, "0", ".", ",");
        }

        if (count($formFieldData) > 0) {

            $hasMin = false;

            foreach ($formFieldData as $formData) {

                if (array_key_exists('special', $formData)) {
                    if (($formData->special == null || $formData->special == 'none' || $formData->special == '') && ($formData->value != "none" && $formData->value != "" && $formData->value != "0")) {

                        if ($formData->type == 'rangeMin') {

                            $flexiFilterQuery .= ' and ads.id in (select adsId from ads_datas where formFieldId = ' . $formData->id . ' and adsValue >= ' . $formData->value . ')';
                            $hasMin           = true;
                            $searchString[]   = $formData->value;
                        } else if ($formData->type == 'rangeMax') {
                            $flexiFilterQuery .= ' and ads.id in (select adsId from ads_datas where formFieldId = ' . $formData->id . ' and adsValue <= ' . $formData->value . ')';

                            if ($hasMin == true) {
                                $searchString[] = ' to ' . $formData->value;
                                $hasMin         = false;
                            } else {
                                $searchString[] = '<=' . $formData->value;
                            }
                        } else if ($formData->type == 'radio') {
                            $flexiFilterQuery .= ' and ads.id in (select adsId from ads_datas where formFieldId = ' . $formData->id . ' and adsValue = "' . $formData->value . '")';
                            if ($hasMin == true) {
                                $searchString[] = ', ' . $formData->value;
                                $hasMin         = false;
                            } else {
                                $searchString[] = $formData->value;
                            }
                        } else if ($formData->type == 'checkBox') {
                            $flexiFilterQuery .= ' and ads.id in (select adsId from ads_datas where formFieldId = ' . $formData->id . ' and adsValue = "' . $formData->value . '")';
                            if ($hasMin == true) {
                                $searchString[] = ', ' . $formData->value;
                                $hasMin         = false;
                            } else {
                                $searchString[] = $formData->value;
                            }
                        } else if ($formData->type == 'input') {
                            $flexiFilterQuery .= ' and ads.id in (select adsId from ads_datas where formFieldId = ' . $formData->id . ' and adsValue LIKE "%' . $formData->value . '%")';
                            if ($hasMin == true) {
                                $searchString[] = ', ' . $formData->value;
                                $hasMin         = false;
                            } else {
                                $searchString[] = $formData->value;
                            }
                        } else if ($formData->type == 'dropdown') {
                            $flexiFilterQuery .= ' and ads.id in (select adsId from ads_datas where formFieldId = ' . $formData->id . ' and adsValue = "' . $formData->value . '")';
                            if ($hasMin == true) {
                                $searchString[] = ', ' . $formData->value;
                                $hasMin         = false;
                            } else {
                                $searchString[] = $formData->value;
                            }
                        } else if ($formData->type == 'multiple') {

                            $count = 0;

                            if (count($formData->value) > 0) {
                                foreach ($formData->value as $multipleValue) {
                                    if ($multipleValue != 'none') {
                                        if ($count > 0) {
                                            $flexiFilterQuery .= ' or';
                                        } else {
                                            $flexiFilterQuery .= ' and (';
                                        }

                                        $flexiFilterQuery .= ' ads.id in (select adsId from ads_datas where formFieldId = ' . $formData->id . ' and adsValue = "' . $multipleValue . '")';
                                        $searchString[]   = $multipleValue;
                                        $count++;
                                    }
                                }

                                if ($count > 0) {
                                    $flexiFilterQuery .= ')';
                                }
                            }
                        }
                    }
                }
            }

            $pairCompleted      = false;
            $makeModelTempQuery = "";

            foreach ($formFieldData as $formData) {

                if (property_exists($formData, 'special')) {

                    if ($formData->special != null && $formData->special != '' && ($formData->special == 'Make' || $formData->special == 'Model') && $formData->value != "none" && $formData->value != "" && $formData->value != null && $formData->value != "0") {

                        if ($pairCompleted == true) {
                            $finalQuery .= ' or ';
                            $pairCompleted == false;
                        }

                        if ($formData->special == 'Make') {
                            if ($formData->value != 'none') {
                                $makeModelQuery .= ' ads.id in (select adsId from ads_datas where formFieldId = ' . $formData->id . ' and adsValue = "' . $formData->value . '")';
                                $pairCompleted  = false;
                                $searchString[] = $formData->value;
                            }
                        } else if ($formData->special == 'Model') {
                            if (count($formData->value) > 1) {
                                $count = 0;

                                $makeModelQuery .= ' and (';

                                foreach ($formData->value as $modelValue) {

                                    if ($modelValue != 'none') {

                                        if ($count > 0) {
                                            $makeModelQuery .= ' or';
                                        }

                                        $makeModelQuery .= ' ads.id in (select adsId from ads_datas where formFieldId = ' . $formData->id . ' and adsValue = "' . $modelValue . '")';
                                        $searchString[] = $modelValue;


                                        $count++;
                                    }
                                }

                                if ($count > 0) {
                                    $makeModelQuery .= ')';
                                }

                                $pairCompleted = true;
                            } else if (count($formData->value) == 1) {

                                foreach ($formData->value as $modelValue) {
                                    if ($modelValue != 'none') {
                                        $makeModelQuery .= ' and ads.id in (select adsId from ads_datas where formFieldId = ' . $formData->id . ' and adsValue = "' . $modelValue . '")';
                                        $searchString[] = $modelValue;
                                    }
                                }

                                $pairCompleted = true;
                            } else {
                                $pairCompleted = true;
                            }
                        }

                        if ($pairCompleted == true) {
                            if ($makeModelQuery != '') {
                                $finalQuery .= $flexiFilterQuery . ' and' . $makeModelQuery . ')';
                            } else {
                                $finalQuery .= $flexiFilterQuery . ')';
                            }
                            $makeModelTempQuery .= $makeModelQuery;
                            $makeModelQuery     = '';
                        }
                    }
                }
            }
        }

        if ($finalQuery != '') {
            $headQuery .= ' where';
        } else {
            $finalQuery .= ' where ' . $flexiFilterQuery . ')';
        }

        $ldate = date('Y-m-d H:i:s');

        $fullQuery = $headQuery . ' ' . $finalQuery . ' and dueDate > "' . $ldate . '"';

        if ($sortType == "fromlowest") {

            $fullQuery .= ' order by ads.adsPrice asc';

            $allAds = DB::select(DB::raw($fullQuery));
        } else if ($sortType == "fromhighest") {

            $fullQuery .= ' order by ads.adsPrice desc';

            $allAds = DB::select(DB::raw($fullQuery));
        } else if ($sortType == "fromoldest") {

            $fullQuery .= ' order by ads.created_at asc';

            $allAds = DB::select(DB::raw($fullQuery));
        } else if ($sortType == "fromnewest") {

            $fullQuery .= ' order by ads.created_at desc';

            $allAds = DB::select(DB::raw($fullQuery));
        }

        $resultsCount     = count($allAds);
        $currentUrl       = ['filter' => 'true'];
        $path             = 'http://b4mx/getAdsByCategory/36';
        $perPage          = 12;
        $afterPaginateAds = $this->arrayPaginator($allAds, $request, $perPage, $currentUrl, $path);

        if (Auth::check()) {
            $favourite = Wishlist::where('userId', Auth::user()->id)
                ->get();
        } else {
            $favourite = 'none';
        }

        $adsDatasArray = array();

        foreach ($allAds as $singleAds) {

            $adsDatas = DB::table('ads_datas')
                ->join('translator_translations', 'translator_translations.item', 'ads_datas.adsValue')
                ->join('form_fields', 'form_fields.id', '=', 'ads_datas.formFieldId')
                ->where('locale', session()->get('locale'))
                ->where('group', 'options')
                ->whereNull('ads_datas.deleted_at')
                ->whereNull('form_fields.deleted_at')
                ->where('ads_datas.adsId', $singleAds->id)
                ->where('form_fields.displaySort', '>', 0)
                ->where('form_fields.displaySort', '<', 999)
                ->orderBy('form_fields.displaySort', 'desc')
                ->get();

            if (count($adsDatas) > 0) {

                $adsDatasArray[$singleAds->id] = $adsDatas;
            }

        }


        $view = \View::make('user/adsresult', [
            'ads'          => $afterPaginateAds,
            'resultsCount' => $resultsCount,
            'favourite'    => $favourite,
            'hiddenQuery'  => $fullQuery,
            'searchString' => implode(", ", $searchString),
            'adsDatas'     => $adsDatasArray
        ])->render();

        return response()->json([
            'resultView' => $view,
            'success'    => 'success',
            'ads'        => $afterPaginateAds,
            'asd'        => $fullQuery
        ]);

    }

    public function getFilterForm(Request $request)
    {

        $subCategoryId     = $request->input('subCategoryId');
        $attributeId       = $request->input('attributeId');
        $formFieldOptionId = $request->input('formFieldOptionId');
        $checkLevel        = false;

        $form = DB::table('subCategory_fields')
            ->join('form_fields', 'form_fields.id', '=', 'subCategory_fields.formFieldId')
            ->join('translator_translations', 'translator_translations.item', 'form_fields.fieldTitle')
            ->where('locale', session()->get('locale'))
            ->where('group', 'formfields')
            ->where('subCategory_fields.subCategoryId', $subCategoryId)
            ->whereNull('subCategory_fields.deleted_at')
            ->whereNull('form_fields.deleted_at')
            ->where('form_fields.fieldTitle', '!=', 'Make')
            ->where('form_fields.fieldTitle', '!=', 'Model')
            ->where('form_fields.fieldTitle', '!=', 'Vehicle')
            ->orderBy('form_fields.sort', 'desc')
            ->orderBy('form_fields.fieldTitle', 'asc')
            ->select('form_fields.id', 'form_fields.fieldType', 'form_fields.fieldTitle', 'form_fields.parentFieldId', 'subCategory_fields.formFieldId', 'form_fields.filterType')
            ->get();

        if ($attributeId != 0) {

            $currentMakeId = DB::table('form_fields')
                ->where('form_fields.fieldTitle', '=', 'Make')
                ->where('form_fields.parentFieldId', $attributeId)
                ->whereNull('form_fields.deleted_at')
                ->value('id');

            $getMakeModelForm = DB::table('form_fields')
                ->where('form_fields.fieldTitle', '=', 'Make')
                ->where('form_fields.parentFieldId', $attributeId)
                ->whereNull('form_fields.deleted_at')
                ->orderBy('form_fields.sort', 'desc')
                ->orderBy('form_fields.fieldTitle', 'asc')
                ->orWhere('form_fields.fieldTitle', '=', 'Model')
                ->where('form_fields.parentFieldId', $currentMakeId)
                ->whereNull('form_fields.deleted_at')
                ->orderBy('form_fields.sort', 'desc')
                ->orderBy('form_fields.fieldTitle', 'asc')
                ->get();

            $value = FormFieldOption::where('parentFieldId', $formFieldOptionId)
                ->whereNull('deleted_at')
                ->join('translator_translations', 'translator_translations.item', 'form_field_options.value')
                ->where('translator_translations.locale', session()->get('locale'))
                ->where('translator_translations.group', 'options')
                ->orderBy('sort', 'desc')
                ->orderBy('value', 'asc')
                ->select('form_field_options.id', 'form_field_options.value', 'form_field_options.formFieldId', 'translator_translations.text')
                ->get();
        } else {

            $getMakeModelForm = DB::table('subCategory_fields')
                ->join('form_fields', 'form_fields.id', '=', 'subCategory_fields.formFieldId')
                ->where('form_fields.fieldTitle', '=', 'Make')
                ->where('subCategory_fields.subCategoryId', $subCategoryId)
                ->whereNull('subCategory_fields.deleted_at')
                ->whereNull('form_fields.deleted_at')
                ->orderBy('form_fields.sort', 'desc')
                ->orderBy('form_fields.fieldTitle', 'asc')
                ->orWhere('form_fields.fieldTitle', '=', 'Model')
                ->where('subCategory_fields.subCategoryId', $subCategoryId)
                ->whereNull('subCategory_fields.deleted_at')
                ->whereNull('form_fields.deleted_at')
                ->orderBy('form_fields.sort', 'desc')
                ->orderBy('form_fields.fieldTitle', 'asc')
                ->get();

            $value = DB::table('subCategory_fields')
                ->join('form_fields', 'form_fields.id', '=', 'subCategory_fields.formFieldId')
                ->join('form_field_options', 'form_field_options.formFieldId', '=', 'form_fields.id')
                ->join('translator_translations', 'translator_translations.item', 'form_field_options.value')
                ->where('translator_translations.locale', session()->get('locale'))
                ->where('translator_translations.group', 'options')
                ->where('subCategory_fields.subCategoryId', $subCategoryId)
                ->where('form_field_options.parentFieldId', 0)
                ->whereNull('subCategory_fields.deleted_at')
                ->whereNull('form_fields.deleted_at')
                ->whereNull('form_field_options.deleted_at')
                ->orderBy('form_field_options.sort', 'desc')
                ->orderBy('form_field_options.value', 'asc')
                ->select('form_field_options.id', 'form_field_options.value', 'form_field_options.formFieldId', 'form_fields.fieldTitle', 'translator_translations.text')
                ->get();
        }
        $countMakeModel = "";

        foreach ($getMakeModelForm as $makeModelForm) {

            if ($makeModelForm->fieldTitle == "Make") {

                $countMakeModel = DB::table('form_field_options')
                    ->where('form_field_options.formFieldId', $makeModelForm->id)
                    ->get();
            }

            if ($makeModelForm->fieldLevel != 1 && $makeModelForm->fieldTitle == "Make") {

                $checkLevel = true;
            }
        }

        $attributeForm = DB::table('subCategory_fields')
            ->join('form_fields', 'form_fields.id', '=', 'subCategory_fields.formFieldId')
            ->where('subCategory_fields.subCategoryId', $subCategoryId)
            ->where('form_fields.fieldLevel', 1)
            ->where('form_fields.fieldTitle', '!=', 'Make')
            ->where('form_fields.fieldTitle', '!=', 'Model')
            ->where('form_fields.fieldTitle', '!=', 'Type')
            ->where('form_fields.fieldTitle', '!=', 'Brand')
            ->whereNull('subCategory_fields.deleted_at')
            ->whereNull('form_fields.deleted_at')
            ->orderBy('form_fields.sort', 'desc')
            ->orderBy('form_fields.fieldTitle', 'asc')
            ->get();

        $final = array();

        foreach ($form as $forms) {

            $data = DB::table('subCategory_fields')
                ->join('form_fields', 'form_fields.id', '=', 'subCategory_fields.formFieldId')
                ->join('form_field_options', 'form_field_options.formFieldId', '=', 'form_fields.id')
                ->where('subCategory_fields.subCategoryId', $subCategoryId)
                ->where('form_fields.fieldTitle', $forms->fieldTitle)
                ->where('form_fields.fieldTitle', '!=', 'Make')
                ->where('form_fields.fieldTitle', '!=', 'Model')
                ->where('form_fields.fieldTitle', '!=', 'Vehicle')
                ->whereNull('subCategory_fields.deleted_at')
                ->whereNull('form_fields.deleted_at')
                ->whereNull('form_field_options.deleted_at')
                ->orderBy('form_field_options.value', 'asc')
                ->select('form_field_options.value')
                ->get()
                ->unique('value');

            if (count($data) > 0) {

                $final[$forms->formFieldId] = $data;
            }
        }

        $childCount  = $request->input('childCount');
        $parentCount = $request->input('parentCount');

        $view          = \View::make('user/OthersForm', ['form' => $form, 'value' => $final])->render();
        $makeModelView = \View::make('user/MakeModelForm', [
            'form'        => $getMakeModelForm,
            'value'       => $value,
            'childCount'  => $childCount,
            'parentCount' => $parentCount
        ])->render();
        $attributeView = \View::make('user/AttributeForm', ['form' => $attributeForm, 'value' => $value])->render();


        return response()->json([
            'resultView'     => $view,
            'makeModelView'  => $makeModelView,
            'success'        => 'success',
            'checkLevel'     => $checkLevel,
            'attributeView'  => $attributeView,
            'countMakeModel' => $countMakeModel
        ]);
    }

    public function getParentValue(Request $request)
    {

        $formOptionId = $request->input('formOptionId');

        $formFieldOption = FormFieldOption::where('parentFieldId', $formOptionId)
            ->whereNull('deleted_at')
            ->join('translator_translations', 'translator_translations.item', 'form_field_options.value')
            ->where('translator_translations.locale', session()->get('locale'))
            ->where('translator_translations.group', 'options')
            ->orderBy('sort', 'desc')
            ->orderBy('value', 'asc')
            ->select('form_field_options.id', 'form_field_options.value', 'form_field_options.formFieldId', 'translator_translations.text')
            ->get();

        return response()->json(['success' => 'success', 'formFieldOption' => $formFieldOption]);
    }

    public function getParentValueWithAds(Request $request)
    {

        $formOptionId = $request->input('formOptionId');
        $adsId        = $request->input('adsId');

        $formFieldOption = FormFieldOption::where('parentFieldId', $formOptionId)
            ->whereNull('deleted_at')
            ->orderBy('sort', 'desc')
            ->orderBy('value', 'asc')
            ->get();

        $adsData = DB::table('ads_datas')
            ->where('ads_datas.adsId', $adsId)
            ->whereNull('ads_datas.deleted_at')
            ->get();

        return response()->json([
            'success'         => 'success',
            'formFieldOption' => $formFieldOption,
            'adsData'         => $adsData
        ]);
    }

    public function filterDropDownCategory(Request $request)
    {

        $categoryId = $request->input('categoryId');

        $subCategory = DB::table('translator_translations')
            ->join('sub_categories', 'sub_categories.subCategoryName', 'translator_translations.item')
            ->where('categoryId', $categoryId)
            ->where('locale', session()->get('locale'))
            ->where('group', 'subcategories')
            ->orderBy('sort', 'desc')
            ->get();

        return response()->json(['success' => 'success', 'subCategory' => $subCategory]);
    }

    public function getSearchSuggestion(Request $request)
    {

        $name = $request->input('searchword');

        $keywordArray = explode(' ', $name);

        $tagAds = DB::table('ads');

        foreach ($keywordArray as $keyword) {

            $tagAds->where('adsName', 'like', '%' . $keyword . '%');
        }

        $resultsAdsIdList = $tagAds->select('id')->get();

        $adsTempo = DB::table('ads');

        $formTempo = DB::table('ads_datas')
            ->join('form_fields', 'form_fields.id', '=', 'ads_datas.formFieldId');

        if (count($resultsAdsIdList) > 0) {

            foreach ($resultsAdsIdList as $id) {

                $adsTempo->orWhere('ads.id', $id->id)
                    ->where('ads.adsStatus', '!=', 'unavailable')
                    ->where('ads.adsPlaceMethod', 'publish')
                    ->whereNotNull('ads.dueDate')
                    ->whereDate('ads.dueDate', ">", date("Y-m-d H:i:s"))
                    ->orderBy('ads.created_at', 'desc');
            }

            foreach ($adsTempo->get() as $filteredAds) {
                $formTempo->orWhere('ads_datas.adsId', $filteredAds->id);
            }

        } else {
            $adsTempo->where('ads.id', -1)
                ->where('ads.adsStatus', '!=', 'unavailable')
                ->where('ads.adsPlaceMethod', 'publish')
                ->whereDate('ads.dueDate', ">", date("Y-m-d H:i:s"))
                ->orderBy('ads.created_at', 'desc');

            $formTempo->Where('ads_datas.adsId', -1);
        }

        $ads = $adsTempo->take(10)->get();

        $formField = $formTempo->get();

        return response()->json([
            'success'   => 'success',
            'ads'       => $ads,
            'test'      => $name,
            'formField' => $formField
        ]);
    }

    // public function reportAds( Request $request ) {

    // 	$adsId   = $request->input( 'adsId' );
    // 	$name    = $request->input( 'name' );
    // 	$email   = $request->input( 'email' );
    // 	$reason  = $request->input( 'reason' );
    // 	$comment = $request->input( 'comment' );

    // 	$adsReport = new AdsReport;

    // 	$adsReport->adsId   = $adsId;
    // 	$adsReport->name    = $name;
    // 	$adsReport->email   = $email;
    // 	$adsReport->reason  = $reason;
    // 	$adsReport->comment = $comment;

    // 	$adsReport->save();

    // 	return response()->json( [ "success" => "success" ] );
    // }

    function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {

        $theta = $lon1 - $lon2;
        $dist  = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist  = acos($dist);
        $dist  = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit  = strtoupper($unit);

        return ($miles * 1.609344);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    public function arrayPaginator($array, $request, $perPage, $currentUrl, $path)
    {

        $page   = Input::get('page', 1);
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page, [
            'path'  => $request->url(),
            'query' => $request->query()
        ]);
    }

    public function QueryAds(Request $request)
    {
        $req = $request->validate([
            's'      => 'string',
            'tags'   => 'array',
            'cat'    => "integer",
            'subcat' => "integer",
        ]);

        $Query = Ads::with(["tag", "subcategory"])
            ->where('parent_id', '=', null) // hide child ads
            ->where('adsStatus', '=', 'payed');

        $Query->join("sub_categories", "sub_categories.id", "=", "ads.subCategoryId")
            ->join("users", "users.id", "=", "ads.userId")
            ->select("sub_categories.*", "ads.*", "users.isRetailer");

        $cat    = isset($req['cat']) ? $req['cat'] : 0;
        $subcat = isset($req['subcat']) ? $req['subcat'] : 0;

        if (isset($req['s'])) {
            $where = "where";

            if (isset($req['s'])) {
                $s = $req['s'];

                $Query = $Query->$where(function ($query) use ($s, $cat, $subcat) {
                    $query->where('adsName', 'like', "%{$s}%");

                    $query->where('parent_id', '=', null) // hide child ads
                    ->where('adsStatus', '=', 'payed');

                    if ($cat != 0) {
                        $query->where('sub_categories.categoryId', $cat);
                    }

                    if ($subcat != 0) {
                        $query->where('sub_categories.id', $subcat);
                    }
                });

                $s_s = explode(' ', $s);
                if (is_array($s_s) and count($s_s) > 1) {
                    foreach ($s_s as $k) {
                        $Query->orWhere(function ($query) use ($k, $cat, $subcat) {
                            $query->where('adsName', 'like', "%{$k}%");
                            $query->where('parent_id', '=', null) // hide child ads
                            ->where('adsStatus', '=', 'payed');

                            if ($cat != 0) {
                                $query->where('sub_categories.categoryId', $cat);
                            }

                            if ($subcat != 0) {
                                $query->where('sub_categories.id', $subcat);
                            }
                        });
                    }
                }
            }
        } else {
            if ($cat != 0) {
                $Query->where('sub_categories.categoryId', $cat);
            }

            if ($subcat != 0) {
                $Query->where('sub_categories.id', $subcat);
            }
        }

        if ($request->input('brand') and $request->input('brand') != 0 and $request->input('brand') != '0')
            $Query->where('ads.brand', $request->input('brand'));

        if ($request->input('type') and $request->input('type') != 0 and $request->input('type') != '0')
            $Query->where('ads.type', $request->input('type'));

        if ($request->input('model') and $request->input('model') != 0 and $request->input('model') != '0')
            $Query->where('ads.model', $request->input('model'));

        $minyear              = $request->input('minyear');
        $maxyear              = $request->input('maxyear');
        $car_type             = $request->input('car_type');
        $minprice             = $request->input('minprice');
        $maxprice             = $request->input('maxprice');
        $currency             = $request->input('currency');
        $minmileage           = $request->input('minmileage');
        $maxmileage           = $request->input('maxmileage');
        $mileage_type         = $request->input('mileage_type');
        $minengine_size       = $request->input('minengine_size');
        $maxengine_size       = $request->input('maxengine_size');
        $transmission         = $request->input('transmission');
        $fuel_type            = $request->input('fuel_type');
        $body_type            = $request->input('body_type');
        $colour               = $request->input('colour');
        $doors                = $request->input('doors');
        $sale_type            = $request->input('sale_type');
        $previous_owners      = $request->input('previous_owners');
        $country              = $request->input('country');
        $city                 = $request->input('city');
        $country_registration = $request->input('country_registration');
        $seller_type          = $request->input('seller_type');

        if ($minyear != NULL and strlen($minyear) > 0)
            $Query->where('year', '>=', $minyear);

        if ($maxyear != NULL and strlen($maxyear) > 0)
            $Query->where('year', '<=', $maxyear);

        if ($minprice != NULL and strlen($minprice) > 0) {
            if ($currency == 'USD') {
                $minprice = $minprice / Option::getSetting("opt_exchange_eur_usd");
            }

            if ($currency == 'GBP') {
                $minprice = $minprice / Option::getSetting("opt_exchange_eur_gbp");
            }

            $Query->where('price_eur', '>=', $minprice);
        }

        if ($maxprice != NULL and strlen($maxprice) > 0) {
            if ($currency == 'USD') {
                $maxprice = $maxprice / Option::getSetting("opt_exchange_eur_usd");
            }

            if ($currency == 'GBP') {
                $maxprice = $maxprice / Option::getSetting("opt_exchange_eur_gbp");
            }

            $Query->where('price_eur', '<=', $maxprice);
        }

        if ($minmileage != NULL and strlen($minmileage) > 0) {
            if ($mileage_type == 'mi') {
                $minmileage = $minmileage / 0.62137;
            }

            $Query->where('mileage_km', '>=', $minmileage);
        }

        if ($maxmileage != NULL and strlen($maxmileage) > 0) {
            if ($mileage_type == 'mi') {
                $maxmileage = $maxmileage / 0.62137;
            }

            $Query->where('price_eur', '<=', $maxmileage);
        }

        if ($minengine_size != NULL and strlen($minengine_size) > 0) {
            $Query->where('engine_size', '>=', $minengine_size);
        }

        if ($maxengine_size != NULL and strlen($maxengine_size) > 0) {
            $Query->where('engine_size', '<=', $maxengine_size);
        }

        if ($transmission != NULL and strlen($transmission) > 0 and $transmission != 'any')
            $Query->where('transmission', $transmission);

        if ($colour != NULL and strlen($colour) > 0 and $colour != 'any')
            $Query->where('ads.сolour', $colour);

        if ($car_type != NULL and strlen($car_type) > 0 and $car_type != 'any')
            $Query->where('type_ad', $car_type);

        if ($seller_type != NULL and strlen($seller_type) > 0 and $seller_type != 'any') {
            if ($seller_type == 'private')
                $Query->where('users.isRetailer', 0);
            else
                $Query->where('users.isRetailer', 1);
        }

        if ($sale_type != NULL and strlen($sale_type))
            $Query->where('sale_type', $sale_type);

        if ($previous_owners != NULL and $previous_owners != 'any')
            $Query->where('previous_owners', $previous_owners);

        if ($country != NULL)
            $Query->where('adsCountry', $country);

        if ($city != NULL)
            $Query->where('adsCity', $city);

        if ($fuel_type != NULL and is_array($fuel_type) > 0 and count($fuel_type) > 0)
            if ((count($fuel_type) == 1 and $fuel_type[0] != 'any') or (count($fuel_type) > 1))
                $Query->whereIn('fuel_type', $fuel_type);

        if ($body_type != NULL and is_array($body_type) > 0 and count($body_type) > 0)
            if ((count($body_type) == 1 and $body_type[0] != 'any') or (count($body_type) > 1))
                $Query->whereIn('body_type', $body_type);

        if ($doors != NULL and is_array($doors) > 0 and count($doors) > 0)
            if ((count($doors) == 1 and $doors[0] != 'any') or (count($doors) > 1))
                $Query->whereIn('doors', $doors);

        if ($country_registration != NULL)
            $Query->where('country_registration', $country_registration);

        $Query = $Query->orderBy('ads.created_at', 'ads')->paginate(6);

        if (isset($s_s)) {
            if (is_array($s_s) and count($s_s) > 1) {
                $Query_sort       = json_decode(json_encode($Query));
                $Query_sort->data = [];
                $n                = 0;
                $ids              = [];

                foreach ($Query as $query) {
                    if (strtolower($query->adsName) == strtolower($req['s'])) {
                        $Query_sort->data[] = (object)$query;
                        $ids[]              = $query->id;
                    }
                }

                foreach ($Query as $query) {
                    if (!in_array($query->id, $ids)) {
                        $Query_sort->data[] = (object)$query;
                    }
                }

                return response()->json((object)$Query_sort);
            }
        }

        return response()->json($Query);
    }

    public function myAds()
    {

        if (!Auth::check()) {

            return redirect("/");

        }

        return view('newthemplate.my-ads-listing', [
            'Page'            => 'my-ads-listing',
            'UserAds'         => Ads::where('userId', Auth::id())->get(),
            'UserListedAds'   => Ads::where('userId', Auth::id())->where("adsStatus", "payed")->get(),
            'UserNoListedAds' => Ads::where('userId', Auth::id())->where("adsStatus", "pending for payment")->get(),
        ]);

    }

    public function category($id)
    {
        $ads = DB::table('sub_categories')
            ->join('ads', 'ads.subCategoryId', '=', 'sub_categories.id')
            ->where('sub_categories.categoryId', $id)
            ->where('ads.adsStatus', '!=', 'unavailable')
            ->where('ads.adsPlaceMethod', 'publish')
            ->whereNull('sub_categories.deleted_at')
            ->whereDate('ads.dueDate', ">", date("Y-m-d H:i:s"))
            ->orderBy('sortingDate', 'desc')
            ->paginate(12);

        return view('site.category', compact('ads'));
    }

    public function set_language(Request $request)
    {
        app()->setLocale($request->lang);
        session()->put('language', $request->lang);

        return redirect()->back();
    }
}
