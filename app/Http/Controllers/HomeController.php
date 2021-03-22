<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;
use App\Option;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function sharePage(Request $request, $type)
    {
        $count = intval(Option::getSetting("social_count_" . $type));

        Option::setSetting("social_count_" . $type, $count + 1);

        $link = "/";

        switch ($type) {
            case "facebook":
                $link = "https://www.facebook.com/sharer/sharer.php?u=https%3A//moto.cgp.systems/";
                break;
            case "twitter":
                $link = "https://twitter.com/home?status=https%3A//moto.cgp.systems/";
                break;
            case "pinterest":
                $link = "https://pinterest.com/pin/create/button/?url=https%3A//moto.cgp.systems/&media=https://moto.cgp.systems/newthemplate/img/baner-header.png&description=BUY OR SELL ANYTHING ON B4MX";
                break;
            case "instagramm":
                $link = "https://www.facebook.com/sharer/sharer.php?u=https%3A//moto.cgp.systems/";
                break;
        }

        return redirect($link);
    }
}

