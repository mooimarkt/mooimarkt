<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Ads;
use App\AdsImages;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller as BaseController;

class LoginController extends BaseController
{
    public function getLoginPage(){
    /*	$success = session('success');
        return view('newthemplate/login', ['success'=>$success]);   */
        return redirect()->to('/');

        return view('newthemplate/login');
    }
}
