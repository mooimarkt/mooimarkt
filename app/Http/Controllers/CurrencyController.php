<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Currency;
// use Illuminate\Support\Facades\DB;
// use Datatables;

class CurrencyController extends Controller
{

    /**
     * set session currency
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function currency(Request $request)
    {
        $request->session()->put('currency', $request->currency);
        return redirect()->back();
    }

    // public function getCurrencyPage(){

    //     return view('Admin/CurrencyPage');
    // }

    // public function getCurrencyTable(){

    //     $currencyTable = DB::table('currency')
    //                     ->whereNull('currency.deleted_at')
    //                     ->get();

    //     return Datatables::of($currencyTable)->make(true);
    // }

    // public function addCurrency(Request $request){

    //     $currencyName = $request->input('currencyName');
    //     $currencyCode = $request->input('currencyCode');
    //     $currencyRate = $request->input('currencyRate');

    //     $currency = new Currency;

    //     $currency->currencyName = $currencyName;
    //     $currency->currencyCode = $currencyCode;
    //     $currency->conversionRate = $currencyRate;

    //     $currency->save();

    //     $result = array('success' => 1);
    //     return $result;
    // }

    // public function updateCurrency(Request $request){

    //     $currencyId = $request->input('currencyId');
    //     $currencyName = $request->input('currencyName');
    //     $currencyCode = $request->input('currencyCode');
    //     $currencyRate = $request->input('currencyRate');

    //     $currency = Currency::find($currencyId);

    //     $currency->currencyName = $currencyName;
    //     $currency->currencyCode = $currencyCode;
    //     $currency->conversionRate = $currencyRate;
    //     $currency->save();

    //     $result = array('success' => 1);
    //     return $result;
    // }

    // public function deleteCurrency(Request $request){

    //     $currencyId = $request->input('currencyId');

    //     $currency = Currency::find($currencyId);

    //     $currency->delete();

    //     $result = array('success' => 1);
    //     return $result;
    // }

    // public function changeCurrency(Request $request){

    //     $currencyCode = $request->input('currency');

    //     $request->session()->put('currency', $currencyCode);

    //     $conversionRate = DB::table('currency')->where('currencyCode', $currencyCode)->value('conversionRate');

    //     $request->session()->put('forexRate', $conversionRate);

    //     return response()->json(['success' => 'success']);
    // }

    // public function getSessionConversionRate(Request $request){

    //     $currencyCode = $request->input('currency');
    // }

}
