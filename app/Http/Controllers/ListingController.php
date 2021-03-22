<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;
use Illuminate\Support\Facades\Auth;
use App\Ads;

class ListingController extends Controller
{
    public function getAdsPage(){

        return view('Admin/AdsListingPage');
    }

    public function ajax_filter_country(Request $request) {
      $response = [
         'results' => [],
         'pagination' => ["more" => false]
      ];

      if ($request->input('country') == NULL) {
         $countries = DB::table('countries')
            ->orderBy('name', 'asc')
            ->get();

         foreach ($countries as $key => $value) {

               if ($request->input('term') != NULL) {
                  if (stripos($value->name, $request->input('term')) === 0)
                     $response['results'][] = [
                        'id' => $value->id,
                        'text' => $value->name,
                     ];
               } else
                  $response['results'][] = [
                     'id' => $value->id,
                     'text' => $value->name,
                  ];
         }

      } else {
         $cities = DB::table('cities')
            ->where('country_id', $request->input('country'))
            ->get();

         foreach ($cities as $key => $value) {
            if ($request->input('term') != NULL) {
               if (stripos($value->name, $request->input('term')) === 0)
                  $response['results'][] = [
                     'id' => $value->name,
                     'text' => $value->name,
                  ];
            } else
               $response['results'][] = [
                  'id' => $value->name,
                  'text' => $value->name,
               ];
         }
      }

      return response()->json($response);

    }

    public function ajax_filter(Request $request) {
      $response = [
         'results' => [],
         'pagination' => ["more" => false]
      ];

      if ($request->input('type') == 'brand') {
         $brands = DB::table('filter')
            ->orderBy('brand', 'asc')
            ->get();

         foreach ($brands as $key => $value) {

            if ($request->input('type_val_sub') != NULL and strlen($request->input('type_val_sub')) > 0) {
               $models = json_decode($value->models);
               $isset = false;
               foreach ($models as $key_tmp => $value_tmp)
                  if ($key_tmp == $request->input('type_val_sub'))
                     $isset = true;

               if ($isset) {
                  if ($request->input('term') != NULL) {
                     if (stripos($value->brand, $request->input('term')) === 0)
                        $response['results'][] = [
                           'id' => $value->brand,
                           'text' => $value->brand,
                        ];
                  } else
                     $response['results'][] = [
                        'id' => $value->brand,
                        'text' => $value->brand,
                     ];
               }

            } else {
               if ($request->input('term') != NULL) {
                  if (stripos($value->brand, $request->input('term')) === 0)
                     $response['results'][] = [
                        'id' => $value->brand,
                        'text' => $value->brand,
                     ];
               } else
                  $response['results'][] = [
                     'id' => $value->brand,
                     'text' => $value->brand,
                  ];
            }

         }
      }

      if ($request->input('type') == 'type') {
         $brand = DB::table('filter')
            ->where('brand', $request->input('brand'))
            ->first();

         $models = json_decode($brand->models);

         foreach ($models as $key => $value) {
            if ($request->input('term') != NULL) {
               if (stripos($key, $request->input('term')) === 0)
                  $response['results'][] = [
                     'id' => $key,
                     'text' => $key,
                  ];
            } else
               $response['results'][] = [
                  'id' => $key,
                  'text' => $key,
               ];
         }
      }

      if ($request->input('type') == 'model') {
         $brand = DB::table('filter')
            ->where('brand', $request->input('brand'))
            ->first();

         $models = json_decode($brand->models);

         foreach ($models as $key => $value) {
            if ($key == $request->input('type_val') or $key == $request->input('type_val_sub')) {
               foreach ($value as $val) {
                  if ($request->input('term') != NULL) {
                     if (stripos($val, $request->input('term')) === 0)
                        $response['results'][] = [
                           'id' => $val,
                           'text' => $val,
                        ];
                  } else
                     $response['results'][] = [
                        'id' => $val,
                        'text' => $val,
                     ];
               }
           }
         }
      }

      return response()->json($response);
    }

    public function getDashBoardPage(){

    	if(!Auth::check() || !Auth::user()->userRole == "admin"){

    		return redirect("/admin");

	    }

    	$adsCount = DB::table('ads')
    				// ->where('adsStatus', 'available')
                    ->where('deleted_at', null)         
    				->count();

    	$userCount = DB::table('users')
    				->where('deleted_at', null)
    				->count();

        $meetingCount = DB::table('activities')
                    ->where('type', 'meeting')
                    // ->where('deleted_at', null)
                    ->count();

        $totalTransaction = DB::table('package_transaction')
                    ->where('deleted_at', null)
                    ->count();

        $lastAds = Ads::latest()
                    ->where( 'adsStatus', '=', 'payed' )
                    ->take(5)
                    ->get();

        // SELECT COUNT(*) as num, MONTH(created_at), YEAR(created_at) FROM `ads`
        // WHERE created_at > DATE_SUB(now(), INTERVAL 6 MONTH)
        // GROUP BY MONTH(created_at), YEAR(created_at)
        $monthData = DB::table('ads')
                    ->select(DB::raw('COUNT(*) as num, MONTH(created_at) as month, YEAR(created_at) as year'))
                    ->where('created_at', '>', DB::raw('DATE_SUB(now(), INTERVAL 6 MONTH)'))
                    ->where('adsStatus', '=', 'payed')
                    ->groupBy('month', 'year')
                    ->get();


    	return view('newthemplate.Admin.index', [
            'Page'=>'dashboard',
            'adsCount' => $adsCount,
            'userCount' => $userCount,
            'meetingCount' => $meetingCount,
            'totalTransaction' => $totalTransaction,
            'lastAds' => $lastAds,
            'monthData' => $monthData
        ]);
    }

    public function getAdsTable(Request $request){

        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        if($fromDate != "" && $toDate != ""){

            $ads = DB::table('ads')
                        ->whereBetween('created_at', [ $fromDate, $toDate ])
                        ->orderBy('created_at', 'desc')
                        ->where('adsStatus', 'available')
                        ->get();
        }
        else{

            $ads = DB::table('ads')
            			->orderBy('created_at', 'desc')
                        ->where('adsStatus', 'available')
                        ->get();
        }

        return Datatables::of($ads)->make(true);
    }

    public function deleteAds(Request $request){

    	$adsId = $request->input('adsId');
    	$ads = Ads::find($adsId);

    	$ads->adsStatus = "unavailable";
    	$ads->save();

    	$result = array('success' => 1);

    	return $result;
    }

    public function pauseAds(Request $request){

    	$response = [
			'status' => 'error',
			'message' => 'Something went wrong.',
		];

    	$adsId = $request->input('adsId');
    	$ads = Ads::find($adsId);

    	if (auth()->check() && $ads->userId == auth()->user()->id){
			$ads->adsStatus = "paused";
			$ads->save();

            $response = [
                'status' => 'success',
                'message' => 'Success.',
            ];
		} else {
			$response['message'] = 'Access denied.';
		}

		return response()->json($response);
    }

    public function resumeAds(Request $request){

		$response = [
			'status' => 'error',
			'message' => 'Something went wrong.',
		];

		$adsId = $request->input('adsId');
		$ads = Ads::find($adsId);

		if (auth()->check() && $ads->userId == auth()->user()->id){
			$ads->adsStatus = "available";
			$ads->save();

            $response = [
                'status' => 'success',
                'message' => 'Success.',
            ];
		} else {
			$response['message'] = 'Access denied.';
		}

		return response()->json($response);
    }

    public function getAdminLoginPage(){

       // return view('Admin/adminLoginPage');
        if(Auth::check()){
            return redirect('getDashBoardPage');
        } else {
            return view('newthemplate.Admin.login');
        }
    }

    public function adminLogin(Request $request){
        $name = $request->input('name');
        $password = $request->input('password');

        $checkAdmin = DB::table('users')
                        ->where('name', $name)
                        ->where('userRole', 'admin')
                        ->get();
                        
        if(count($checkAdmin) > 0){

            if (Auth::attempt(['name' => $name, 'password' => $password, 'userRole' => 'admin' ])) {
                // Authentication passed...
                return redirect()->intended('getDashBoardPage');
            } else {
                return redirect()
                    ->back()
                    ->withInput($request->input())
                    ->withErrors(['password' => 'Wrong password']);
            }

        }
        else{

	        $request->session()->flash('fail', 'Wrong credentials');
            return redirect()
                ->back()
                ->withInput($request->input())
                ->withErrors(['name' => 'Wrong Name']);
        }
    }

    // NEW Functions
    public function adminLoginAjax(Request $request){

        $email    = $request->input('email');
        $password = $request->input('password');

        $checkAdmin = DB::table('users')
                        ->where('email', $email)
                        ->where('userRole', 'admin')
                        ->get();

        if(count($checkAdmin) > 0){

            if (Auth::attempt(['email' => $email, 'password' => $password, 'userRole' => 'admin' ],$request->has('remember'))) {

	            return response()->json([
		            'status'=>'success',
		            'message'=>'logined',

	            ]);

            }

	        return response()->json([
		        'status'=>'error',
		        'message'=>'Wrong password'
	        ]);

        }

        return response()->json([
        	'status'=>'error',
        	'hash'=>bcrypt("admin@admin.com"),
	        'message'=>'admin not find'
        ]);

    }

    public function LogOut(Request $request){
	    if(Auth::check()){
	    	Auth::logout();
	    }

	    return redirect("/");
    }

    public function AdminPages(Request $request,$page){

    	if(!Auth::check()){
    		return redirect("/");
	    }

	    if (view()->exists('newthemplate.Admin.'.$page)){
		    return view('newthemplate.Admin.'.$page,[
			    'Page' => $page,
		    ]);
	    } else{
		    return view('newthemplate.Admin.index',[
			    'Page' => 'dashboard',
		    ]);
	    }
    }
}
