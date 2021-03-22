<?php

namespace App\Http\Controllers;

use App\Country;
use App\Language;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function get_cities($countryId)
    {
        $country = Country::find($countryId);
        $cities = isset($country) ? $country->cities : [];

        return response()->json(['success' => true, 'data' => $cities]);
    }

    public function translate(Request $request)
    {
        $translate = Language::lang($request->trans);

        return response()->json(['success' => true, 'data' => $translate]);
    }
}