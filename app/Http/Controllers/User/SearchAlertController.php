<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\ForDisplay;
use App\SearchCriteria;
use App\Wishlist;
use App\User;
use App\SimpleSave;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use App\Mail\SearchAlertMail;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\View\View;

class SearchAlertController extends BaseController
{
    
    public function getSearchAlertPage(){

        $searchCriteria = SearchCriteria::where('userId', Auth::user()->id)
                                        ->whereNull('deleted_at')
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(8);

        return view('user/searchalert',["data" => $searchCriteria]);
    }

    public function cronSendSearchAlertMail($period){
        //Search Criteria

        $allSC = DB::table('search_criteria')
                    ->where('alertActivated', $period)
                    ->whereNull('deleted_at')
                    ->get();


        foreach($allSC as $searchCriteria){

            $allAds = DB::select(DB::raw($searchCriteria->searchQuery));
            $resultsCount = count($allAds);

            $user = User::find($searchCriteria->userId);
            $searcCriteriaModel = SearchCriteria::find($searchCriteria->id);

            $searchId = \Crypt::encryptString($searcCriteriaModel->id);

            Mail::to($user->email)->send(new SearchAlertMail($allAds, $user, $searcCriteriaModel, $searcCriteriaModel, $searchId ));
        }
    }

    public function addSearchAlert(Request $request){
        
        $jsonFormFieldData = $request->input('formFieldData');
        $jsonMakeModelData = $request->input('makeModelHtmlData');
        $jsonAttributeData = $request->input('attributeHtmlData');
        $formFieldData = json_decode($jsonFormFieldData);
        $searchType = $request->input('searchType1');
        $searchData = $request->input('searchData1');
        $currency = $request->input('dropCurrency');
        $minPrice = $request->input('txtMinPrice');
        $maxPrice = $request->input('txtMaxPrice');
        $country = $request->input('dropDownCountry');
        $region = $request->input('dropDownRegion');
        $subCategoryId = $request->input('subCategoryId');
        $categoryId = $request->input('categoryId');
        $sortType = $request->input('sortType');
        $filterLongitude = $request->input('geolocationLongitude');
        $filterLatitude = $request->input('geolocationLatitude');
        $radiusInKm = $request->input('txtRadius');
        $searchQuery = $request->input('searchQuery');
        $searchHtml = $request->input('searchHtml');
        $searchSummary = $request->input('searchSummary');
        $searchString = $request->input('searchString');

        $categoryName = DB::table('categories')->where('id', $categoryId)->value('categoryName');
        $subCategoryName = DB::table('sub_categories')->where('id', $subCategoryId)->value('subCategoryName');

        $searchCriteria = new SearchCriteria;

        if($categoryId == 'none' && $subCategoryId == 'none'){
            $searchTitle = trans('buttons.all');
        }
        else if($categoryId != 'none' && $subCategoryId == 'none'){
            $searchTitle = $categoryName;
        }
        else{
            $searchTitle = $categoryName.', '.$subCategoryName;
        }

        if($searchString){
            $searchTitle = $searchString." ,".$searchTitle;
        }

        if($searchSummary == ""){
            $searchCriteria->searchString = trans('label-terms.anyconditions');
        }
        else{
            $searchCriteria->searchString = $searchSummary;
        }
        
        $locale = session()->get('locale');

        $searchCriteria->userId = Auth::user()->id;
        $searchCriteria->searchTitle = $searchTitle; 
        $searchCriteria->searchQuery = $searchQuery;
        $searchCriteria->jsonData = $jsonFormFieldData;
        $searchCriteria->makeModelJsonData = $jsonMakeModelData;
        $searchCriteria->attributeJsonData = $jsonAttributeData;
        $searchCriteria->filterHtml = $searchHtml;
        $searchCriteria->attributeJsonData = $jsonAttributeData;
        //$searchCriteria->locale = $locale;
        $searchCriteria->alertActivated = 1;

        $searchCriteria->save();

        return response()->json(["success" => "success"]);

    }

    public function loadSearchCriteria(Request $request){

        $searchCriteria = SearchCriteria::where('id', $request->input('searchId'))
                                        ->first();

        $allAds = DB::select(DB::raw($searchCriteria->searchQuery));
        $resultsCount = count($allAds);

        $currentUrl = ['filter' => 'true'];
        $path = 'http://b4mx/getAdsByCategory/36';
        $perPage = 12;
        $afterPaginateAds = $this->arrayPaginator($allAds, $request, $perPage, $currentUrl, $path);

        if(Auth::check()){
            $favourite = Wishlist::where('userId', Auth::user()->id)
                        ->get();
        }
        else{
            $favourite = 'none';
        }

        $adsDatasArray = array();

        foreach($allAds as $singleAds){

            $adsDatas = DB::table('ads_datas')
                ->join('form_fields', 'form_fields.id', '=', 'ads_datas.formFieldId')
                ->whereNull('ads_datas.deleted_at')
                ->whereNull('form_fields.deleted_at')
                ->where('ads_datas.adsId', $singleAds->id)
                ->where('form_fields.sort', '>', 0)
                ->where('form_fields.sort', '<', 6)
                ->orderBy('form_fields.sort', 'desc')
                ->get();

            if(count($adsDatas) > 0){

                $adsDatasArray[$singleAds->id] = $adsDatas;
            }

        }

        $formFieldData = json_decode($searchCriteria->jsonData);

        $longitude = 0;
        $latitude = 0;

        if(count($formFieldData) > 0){
            foreach($formFieldData as $lngLatData){
                if(isset($lngLatData->id)){
                    if($lngLatData->id == 'geolocationLatitude'){
                        $latitude = $lngLatData->value;
                    }
                    else if($lngLatData->id == 'geolocationLongitude'){
                        $longitude = $lngLatData->value;
                    }
                }
            }
        }

        $view = \View::make('user/adsresult', ['ads' => $afterPaginateAds, 'favourite' => $favourite, 'hiddenQuery' => $searchCriteria->searchQuery, 'searchString' => $searchCriteria->searchString, 'resultsCount' => $resultsCount, 'adsDatas'=> $adsDatasArray ])->render();

        return response()->json([ 'resultView' => $view, 'success' => 'success', 'asd' => $searchCriteria->searchQuery, 'filterHtml' => $searchCriteria->filterHtml, 'jsonData' => $searchCriteria->jsonData, 'resultsCount' => $resultsCount, 'long' => $longitude, 'lat' => $latitude, 'fromSearchCriteriaFlag' => 'true']);

    }

    // public function displayFromMailSearchAlert(Request $request, $searchId){

    //     $searchCriteria = SearchCriteria::where('id', $searchId)
    //                                     ->first();

    //     $allAds = DB::select(DB::raw($searchCriteria->searchQuery));
    //     $resultsCount = count($allAds);

    //     $currentUrl = ['filter' => 'true'];
    //     $path = 'http://b4mx/getAdsByCategory/36';
    //     $perPage = 12;
    //     $afterPaginateAds = $this->arrayPaginator($allAds, $request, $perPage, $currentUrl, $path);

    //     if(Auth::check()){
    //         $favourite = Wishlist::where('userId', Auth::user()->id)
    //                     ->get();
    //     }
    //     else{
    //         $favourite = 'none';
    //     }

    //     $adsDatasArray = array();

    //     foreach($allAds as $singleAds){

    //         $adsDatas = DB::table('ads_datas')
    //             ->join('form_fields', 'form_fields.id', '=', 'ads_datas.formFieldId')
    //             ->whereNull('ads_datas.deleted_at')
    //             ->whereNull('form_fields.deleted_at')
    //             ->where('ads_datas.adsId', $singleAds->id)
    //             ->where('form_fields.sort', '>', 0)
    //             ->where('form_fields.sort', '<', 6)
    //             ->orderBy('form_fields.sort', 'desc')
    //             ->get();

    //         if(count($adsDatas) > 0){

    //             $adsDatasArray[$singleAds->id] = $adsDatas;
    //         }

    //     }

    //     $formFieldData = json_decode($searchCriteria->jsonData);

    //     $longitude = 0;
    //     $latitude = 0;

    //     if(count($formFieldData) > 0){
    //         foreach($formFieldData as $lngLatData){
    //             if(isset($lngLatData->id)){
    //                 if($lngLatData->id == 'geolocationLatitude'){
    //                     $latitude = $lngLatData->value;
    //                 }
    //                 else if($lngLatData->id == 'geolocationLongitude'){
    //                     $longitude = $lngLatData->value;
    //                 }
    //             }
    //         }
    //     }

    //     $view = \View::make('user/adsresult', ['ads' => $afterPaginateAds, 'favourite' => $favourite, 'hiddenQuery' => $searchCriteria->searchQuery, 'searchString' => $searchCriteria->searchString, 'resultsCount' => $resultsCount, 'adsDatas'=> $adsDatasArray ])->render();

    //     return response()->json([ 'resultView' => $view, 'success' => 'success', 'asd' => $searchCriteria->searchQuery, 'filterHtml' => $searchCriteria->filterHtml, 'jsonData' => $searchCriteria->jsonData, 'resultsCount' => $resultsCount, 'long' => $longitude, 'lat' => $latitude, 'fromSearchCriteriaFlag' => 'true']);
    // }

    public function updateAlertActivated(Request $request){

        $searchId = $request->input('searchId');
        $alertActivated = $request->input('alertActivated');

        $searchCriteria = SearchCriteria::find($searchId);

        $searchCriteria->alertActivated = $alertActivated;

        $searchCriteria->save();
    }

    public function deleteSearchAlert(Request $request){

        $searchId = $request->input('searchId');

        $searchCriteria = SearchCriteria::find($searchId);

        $searchCriteria->delete();

        return response()->json(["success" => "success"]);
    }

    public function sendSearchAlertEmail(){

        $allSC = DB::table('search_criteria')
                    ->whereNull('deleted_at')
                    ->get();


        foreach($allSC as $searchCriteria){

            $allAds = DB::select(DB::raw($searchCriteria->searchQuery));
            $resultsCount = count($allAds);

            $currentUrl = ['filter' => 'true'];
            $path = 'http://b4mx/getAdsByCategory/36';
            $perPage = 12;
            $afterPaginateAds = $this->arrayPaginator($allAds, $request, $perPage, $currentUrl, $path);

            $user = User::find($searchCriteria->userId);

            $toPassSearchCriteria = SearchCriteria::find($searchCriteria->id);

            Mail::to($user->email)->send(new SearchALertMail($afterPaginateAds, $user, $toPassSearchCriteria, $searchCriteria->id));
        }

    }

    public function arrayPaginator($array, $request, $perPage, $currentUrl, $path){

        $page = Input::get('page', 1);
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page, ['path' => $request->url(), 'query' => $request->query() ]);
    }

    public function SaveSearchApi(Request $request){

    	if(Auth::check()){

		    $req = $request->validate([
			    'action'=>"required|string"
		    ]);

		    switch ($req['action']){
			    case 'update':

				    if($request->exists('sid') && $request->exists('search')){

					    $SimpleSave = SimpleSave::find($request->sid);

					    if(!is_null($SimpleSave)){

						    $SimpleSave->update($request->search);
						    return response()->json(['status'=>'success','message'=>"updated!"]);

					    }

					    return response()->json(['status'=>'error','message'=>"search with id {$request->sid} not found"]);

				    }

				    return response()->json(['status'=>'error','message'=>"`sid` or `search` is not set"]);

				    break;
			    case 'remove':

				    if($request->exists('sid')){

					    $SimpleSave = SimpleSave::find($request->sid);

					    if(!is_null($SimpleSave)){

						    $SimpleSave->delete();
						    return response()->json(['status'=>'success','message'=>"deleted!"]);

					    }

					    return response()->json(['status'=>'error','message'=>"search with id {$request->sid} not found"]);

				    }

				    return response()->json(['status'=>'error','message'=>"`sid` is not set"]);

				    break;
			    case 'create':
				    if($request->exists('search')){

					    $SimpleSave = SimpleSave::create([
					    	'uid'=>Auth::id(),
					    	'search'=>json_encode($request->search),
					    ]);

					    return response()->json(['status'=>'success','message'=>"`created","search"=>$SimpleSave]);

				    }
				    return response()->json(['status'=>'error','message'=>"`search` is not set"]);

				    break;
			    default:
				    return response()->json(['status'=>'error','message'=>"no such action"]);
				    break;
		    }

		    return response()->json(['status'=>'error','message'=>"wrong request"]);

	    }

	    return response()->json(['status'=>'error','message'=>"Please Auth"]);

    }

    public function MySavedSearches(Request $request){

	    if(!Auth::check()){
	    	return redirect("/");
	    }

		return view("newthemplate.my_seved_searches" ,
			[
				'Searches'=>SimpleSave::with(['Category','SubCategory'])->where("uid",Auth::id())->get(),
				'Page'=>'my_seved_searches',
			]);

    }
}