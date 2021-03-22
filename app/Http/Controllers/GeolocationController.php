<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ForDisplay;
use App\User;
use Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller as BaseController;

class GeolocationController extends BaseController
{
    public function getGeolocation(Request $request){

            return response()->json('none');

    }

    public function changeState(Request $request){
        $countryName = $request->input('countryName');

        if($countryName == 'none'){
            $states = 'none';
            return $states;
        }
        else{
            try{
                $states = DB::table('world_countries')
                                ->join('states', 'states.country_id', 'world_countries.id')
                                ->whereRaw('LOWER(world_countries.name) like LOWER("%'.$countryName.'%")')
                                ->orderBy('states.name', 'asc')
                                ->pluck('states.name');
            } catch (\Exception $e) {
                $states = 'nostate';
            }

            return $states;
        }

    }
}