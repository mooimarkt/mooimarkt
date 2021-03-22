<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\ForDisplay;
use App\Ads;
use App\Category;
use App\User;
use App\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Pricing;
use App\Http\Controllers\Controller as BaseController;

class ActiveAdsController extends BaseController
{
    
    public function getActiveAdsPage(Request $request){

    	$displayData = new ForDisplay;

        $userId = Auth::user()->id;
        $subCategory = SubCategory::all();
        $checkMethod = $request->input('btnMethod');

        if($checkMethod == "draft"){

            $adsValue = DB::table('ads')
                ->join('ads_datas', 'ads_datas.adsId', '=', 'ads.id')
                ->join('form_fields', 'form_fields.id', 'ads_datas.formFieldId')
                ->where('ads.userId', $userId)
                ->where('form_fields.sort', '!=', 0)
                ->where('ads.adsPlaceMethod', 'draft')
                ->where('ads.adsStatus', '!=', 'unavailable')
                ->orderBy('form_fields.sort', 'asc')
                ->paginate(8);

            $ads = DB::table('ads')
                    ->join('package_transaction', 'package_transaction.adsId', '=', 'ads.id')
                    ->select('ads.*', 'package_transaction.referenceId')
                    ->where('userId', $userId)
                    ->where('ads.adsPlaceMethod', 'draft')
                    ->where('ads.adsStatus', '!=',   'unavailable')
                    ->groupBy('package_transaction.referenceId')
                    ->orderBy('ads.created_at', 'desc')
                    ->paginate(8);
        }
        else{

            $adsValue = DB::table('ads')
                ->join('ads_datas', 'ads_datas.adsId', '=', 'ads.id')
                ->join('form_fields', 'form_fields.id', 'ads_datas.formFieldId')
                ->where('ads.userId', $userId)
                ->where('form_fields.sort', '!=', 0)
                ->where('ads.adsPlaceMethod', 'publish')
                ->where('ads.adsStatus', '!=',   'unavailable')
                ->orderBy('form_fields.sort', 'asc')
                ->paginate(8);

            $ads =  Ads::where('userId', $userId)
                    ->where('ads.adsPlaceMethod', 'publish')
                    ->where('ads.adsStatus', '!=',   'unavailable')
                    ->orderBy('ads.created_at', 'desc')
                    ->paginate(8);

            $subCategoryIDAry[] = "0";
            foreach($ads as $ads_data){
                $subCategoryIDAry[$ads_data->subCategoryId] = $ads_data->subCategoryId;
                $basePackage = $ads_data->getBasePackage();

                if($basePackage == "basic"){
                    $packageTypeArray = array("basic-bump-addOn","basic-spotlight-addOn");
                }elseif($basePackage == "spotlight"){
                    $packageTypeArray = array("spotlight-bump-addOn","spotlight-spotlight-addOn");
                    
                }elseif($basePackage == "auto-bump"){
                    $packageTypeArray = array("ab-bump-addOn","ab-spotlight-addOn");
                    
                }else{
                    $packageTypeArray = array("basic-bump-addOn","basic-spotlight-addOn");
                }
                $query = Pricing::where('subCategoryId', $ads_data->subCategoryId);
                $query->whereIn("offer_option",array("all","add_on"));
                $query->whereIn("type",$packageTypeArray);
                $tempPricing = $query->get();

                $pricing[$ads_data->subCategoryId] = $tempPricing;

                if($tempPricing->isEmpty()){
                    $query = Pricing::where('subCategoryId', 0);
                    $query->whereIn("offer_option",array("all","add_on"));
                    $query->whereIn("type",$packageTypeArray);
                    $tempPricing = $query->get();
                    $pricing[$ads_data->id] = $tempPricing;
                }
                //dd($pricing);
            }
            /*$query = Pricing::whereIn('subCategoryId', $subCategoryIDAry);
            $query->whereIn("offer_option",array("all","add_on"));
            $pricing = $query->get();*/

        }
        $add_on_package = [];
        if(isset($pricing)){
            foreach($pricing as $adsID => $temp){
                foreach($temp as $pricing_data){
                    $addOnType = "";
                    if(strpos($pricing_data->type,"spotlight-addOn") == true){
                        $addOnType = "spotlight";
                    }else if(strpos($pricing_data->type,"bump-addOn") == true){
                        $addOnType = "bump";
                    }
                    $add_on_package[$adsID][$addOnType]["packageID"] = $pricing_data->id;
                }
            }
        }
        if($ads->isEmpty()){
            $displayData->checkData = "empty";
        }
        else{
            $displayData->checkData = "not empty";
        }

        return view('user/activeads',["ads" => $ads, "adsValue" => $adsValue, "displayData" => $displayData, "subCategory" => $subCategory, "checkMethod" => $checkMethod,"add_on_package"=>$add_on_package]);
    }

    public function getMailEditAdsPage($encryptAdsId){

        $adsId = \Crypt::decryptString($encryptAdsId);

        $latitude = 0;
            $longitude = 0;

            $ads = Ads::where('id', $adsId)
                        ->where('adsStatus', '!=',   'unavailable')
                        ->get();

            $adsQuery = Ads::find($adsId);
            $subCategoryQuery = SubCategory::find($adsQuery->subCategoryId);
            $categoryId = $subCategoryQuery->categoryId;
            $subCategory = SubCategory::where('categoryId', $subCategoryQuery->categoryId)->get();

            $category = Category::all();

            $imagesPaths = DB::table('adsImages')
                                ->where('adsId', '=', $adsId)
                                ->get();

            $imagesBase64 = array();

            foreach($imagesPaths as $imagePath){
                $path = $imagePath->imagePath;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                $imagesBase64[] = $base64;
            }

            $path = $ads[0]->adsImage;
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $primaryImagesBase64 = $base64;

            if(Auth::check()){
                $userId = Auth::user()->id;
                $user = User::find($userId);

                $socialAcounts = DB::table('social_accounts')
                                ->where('social_accounts.user_id', '=', $userId)
                                ->get();

                $countriesList = DB::table('world_countries')->pluck('name');
                $callingCodeList = DB::table('world_countries')->orderBy('name','asc')->get();

                if($user->country == null){
                    $states = 'none';
                }
                else{

                    if($user->region == "none"){

                        $states = "none";
                    }
                    else{

                        try{
                            $states = DB::table('world_countries')
                                        ->join('states', 'states.country_id', 'world_countries.id')
                                        ->whereRaw('LOWER(world_countries.name) like LOWER("%'.$user->country.'%")')
                                        ->orderBy('states.name', 'asc')
                                        ->pluck('states.name');
                        } catch (\Exception $e) {
                            $states = 'nostate';
                        }
                    }
                }
            }
            else{
                $user = new User;

                $countriesList = DB::table('world_countries')->pluck('name');
                $callingCodeList = DB::table('world_countries')->orderBy('name','asc')->get();
                $states = 'none';
            }

            $currency = DB::table('currency')
                        ->whereNull('deleted_at')
                        ->get();

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
                ->where('ads_datas.adsId', $adsId)
                ->get();

            $summaryString = "";

            foreach($adsDatas as $adsData){
                $summaryString .= $adsData->adsValue;
            }

            $tags = DB::table('tag')->where('adsId', $adsId)->get();

            return view('user/placeads', ["user" => $user, "category" => $category, 'categoryId' => $categoryId, 'ads' => $ads, 'callingCodeList' => $callingCodeList, 'countriesList' => $countriesList, 'states' => $states, 'latitude' => $latitude, 'longitude' => $longitude, 'subCategory' => $subCategory,  'currency' => $currency, 'galleryImages' => $imagesBase64, 'primaryImage' => $primaryImagesBase64, 'summaryString' => $summaryString, 'tags' => $tags]);
    }
}
