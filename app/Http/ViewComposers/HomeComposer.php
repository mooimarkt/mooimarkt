<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class HomeComposer
{
    public function compose(View $view){

        $view->with('number', 1);
    }
}