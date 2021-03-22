<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Ads;
use App\AdsImages;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller as BaseController;

class ChatController extends BaseController
{
    public function getChatPage()
    {
        return view('user/reply');
    }
}