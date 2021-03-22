<?php

namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

    public function boot()
    {
        View::composer('layouts.app', 'App\Http\ViewComposers\AppComposer');
    }


    public function register()
    {
        //
    }
}