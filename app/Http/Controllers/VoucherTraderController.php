<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Auth;
// use Datatables;
// use Session;
// use App\Category;
// use App\SubCategory;
// use App\Voucher;
// use App\VoucherRedeem;

use App\VoucherTrader;
use App\Option;
use Illuminate\Http\Request;

class VoucherTraderController extends Controller
{
	public function __construct()
    {
        $this->middleware('AdminCheck')->except('check');
    }

    /**
     * Check if exist voucher Code
     *
     * @param  string $voucher Voucher Code
     * @return Response        new Prices
     */
    public function check(Request $request)
    {
    	$prices = array(
    		0 => Option::getSetting("opt_subscription_1"), // Basic
    		1 => Option::getSetting("opt_subscription_2"), // Auto bump
    		2 => Option::getSetting("opt_subscription_3"), // Spotlight
    	);

    	if ($voucher = VoucherTrader::where([
    		['voucherCode', $request->voucherCode],
    		['status', 1]
    	])->first()) {
    		foreach ($prices as $key => $price) {
	    		if ($voucher->discountType == 'percentage') {
	    			$prices[$key] -= (float)($price * ($voucher->discountValue / 100.00));
	    			if ($prices[$key] < 0) $prices[$key] = 0;
	    		} elseif ($voucher->discountType == 'unit') {
	    			$prices[$key] -= (float)$voucher->discountValue;
	    			if ($prices[$key] < 0) $prices[$key] = 0;
	    		}
	    	}
    	}

    	return $prices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vouchers = VoucherTrader::latest()->paginate(10);
        $Page = 'voucher-trader';
        return view('newthemplate.Admin.voucher-trader', compact(['vouchers', 'Page']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$request->validate([
	        'voucherCode' => 'required|unique:voucher|max:255',
	    ]);
        $request->merge([
        	'multipleRedeem' => ($request->multipleRedeem ? 'yes' : 'no'),
    		'status' => 1
    	]);
        VoucherTrader::create($request->all());
        $request->session()->flash('status', 'Voucher Trader added!');
        return redirect()->route('voucher-trader.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(VoucherTrader $voucher)
    {
        $voucher->delete();
        return response()->json(['status' => 'success', 'msg' => 'Sucessfully delete voucher code']);
    }

	// public function getVoucherPage(){

	//     return view('Admin/VoucherPage');
	// }

	// public function getVoucherTable(){

	//     $voucherTable = DB::table('voucher')
	//                     ->select('id', 'voucherName', 'voucherCode', 'discountValue','discountType','multipleRedeem','status')
	//                     ->where('status',"=","1")
	//                     ->whereNull('voucher.deleted_at')
	//                     ->get();

	//     return Datatables::of($voucherTable)->make(true);
	// }

	// public function updateVoucher(Request $request){
	// 	$voucherID = $request->input('voucher_id');
	// 	$voucherName = $request->input('voucherName');
	// 	$voucherCode = $request->input('voucherCode');
	// 	$discountAmount = $request->input('discountAmount');
	// 	$discountType = $request->input('discountType');
	// 	$multipleRedeem = $request->input('multipleRedeem');

	// 	if(!strlen($voucherName)){
	// 		return response()->json([ 'status' => "error" ,"msg"=>"Please enter voucher name."]);
	// 	}
	// 	if(!strlen($voucherCode)){
	// 		return response()->json([ 'status' => "error" ,"msg"=>"Please enter voucher code."]);
	// 	}
	// 	if(!strlen($discountAmount)){
	// 		return response()->json([ 'status' => "error" ,"msg"=>"Please enter Discount Amount."]);
	// 	}
	// 	if(!$discountType){
	// 		return response()->json([ 'status' => "error" ,"msg"=>"Please select discount type."]);
	// 	}
	// 	if(!$multipleRedeem){
	// 		return response()->json([ 'status' => "error" ,"msg"=>"Please select redeem type."]);
	// 	}

	// 	$existingVoucher = VoucherTrader::WHERE("id","!=",$voucherID)->WHERE("voucherCode","=",$voucherCode)->WHERE("status","=","1")->get();
	// 	if(count($existingVoucher)){
	// 		return response()->json([ 'status' => "error" ,"msg"=>"Voucher Code Exist."]);
	// 	}

 //      	$voucher = VoucherTrader::find($voucherID);
 //      	$voucher->voucherName = $voucherName;
 //      	$voucher->voucherCode = $voucherCode;
 //      	$voucher->discountValue = $discountAmount;
 //      	$voucher->discountType = $discountType;
 //      	$voucher->multipleRedeem = $multipleRedeem;
 //      	$voucher->status = "1";
 //      	$voucher->save();
	// 	return response()->json([ 'status' => "ok" ,"msg"=>"Sucessfully create voucher code"]);

	// }
	// public function save_voucher(Request $request){
	// 	$voucherName = $request->input('voucherName');
	// 	$voucherCode = $request->input('voucherCode');
	// 	$discountAmount = $request->input('discountAmount');
	// 	$discountType = $request->input('discountType');
	// 	$multipleRedeem = $request->input('multipleRedeem');

	// 	if(!strlen($voucherName)){
	// 		return response()->json([ 'status' => "error" ,"msg"=>"Please enter voucher name."]);
	// 	}
	// 	if(!strlen($voucherCode)){
	// 		return response()->json([ 'status' => "error" ,"msg"=>"Please enter voucher code."]);
	// 	}
	// 	if(!strlen($discountAmount)){
	// 		return response()->json([ 'status' => "error" ,"msg"=>"Please enter Discount Amount."]);
	// 	}
	// 	if(!$discountType){
	// 		return response()->json([ 'status' => "error" ,"msg"=>"Please select discount type."]);
	// 	}
	// 	if(!$multipleRedeem){
	// 		return response()->json([ 'status' => "error" ,"msg"=>"Please select redeem type."]);
	// 	}

	// 	$existingVoucher = VoucherTrader::WHERE("voucherCode","=",$voucherCode)->WHERE("status","=","1")->get();
	// 	if(count($existingVoucher)){
	// 		return response()->json([ 'status' => "error" ,"msg"=>"Voucher Code Exist."]);
	// 	}

 //      	$voucher = new Voucher();
 //      	$voucher->voucherName = $voucherName;
 //      	$voucher->voucherCode = $voucherCode;
 //      	$voucher->discountValue = $discountAmount;
 //      	$voucher->discountType = $discountType;
 //      	$voucher->multipleRedeem = $multipleRedeem;
 //      	$voucher->status = "1";
 //      	$voucher->save();
	// 	return response()->json([ 'status' => "ok" ,"msg"=>"Sucessfully create voucher code"]);

	// }

	// public function applyVoucherCode(Request $request){
	// 	$voucherCode = $request->input('voucherCode');
	// 	$voucher = VoucherTrader::WHERE("voucherCode","=",$voucherCode)->where("status","=","1")->first();


	// 	if($voucher){
	// 		if($voucher->multipleRedeem == "no"){
	// 			$voucher_redeem = VoucherRedeem::WHERE("voucherId","=",$voucher->id)->where("userId","=",Auth::user()->id)->get();
	// 			if(count($voucher_redeem)){
	// 				return response()->json([ 'status' => "error" ,"msg"=>"Invalid voucher code"]);
	// 			}
	// 		}
	// 		\Session::put('voucherCode',$voucherCode);
	// 		return response()->json([ 'status' => "ok" ,"msg"=>"Voucher Code Applied"]);
	// 	}else{
	// 		\Session::put('voucherCode',"");
	// 		return response()->json([ 'status' => "error" ,"msg"=>"Invalid voucher code"]);
	// 	}
	// }

	// public function deleteVoucher(Request $request){
	// 	$voucherID = $request->input('voucherID');
	// 	$voucher = VoucherTrader::find($voucherID);

	// 	$voucher->status = 0;
	// 	$voucher->save();
	// 	return response()->json([ 'status' => "ok" ,"msg"=>"Sucessfully delete voucher code"]);
	// }


}
