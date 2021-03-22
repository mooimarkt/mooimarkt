<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\ForDisplay;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller as BaseController;

class RegisterController extends BaseController
{
    public function getRegisterPage()
    {
        $displayData = new ForDisplay;

        //Wordings
        $originalWord          = "<span class='tnc-agree-message' style='margin-top:20px;'>" . trans('instruction-terms.iagreetotermsandcondition') . "</span>";
        $fromWord              = array("#", "*");
        $toWord                = array("<a href='getTermsOfUse'>", "</a>");
        $displayData->linksTnc = str_replace($fromWord, $toWord, $originalWord);

        $displayData->lblUserType = 0;

        return view('user/auth/register', ["data" => $displayData]);
    }
}
