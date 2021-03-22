<?php

namespace App\Providers;

use App\Language;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use App\SubCategory;
use App\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      /*  view()->composer(['newthemplate.header', 'newthemplate.header-login'], function($view) {
            $categories = Category::select('categories.id', 'categories.categoryName', DB::raw('COUNT(ads.id) as adsnum'))
                ->leftJoin('sub_categories', 'categories.id', '=', 'sub_categories.categoryId')
                ->leftJoin('ads', 'sub_categories.id', '=', 'ads.subCategoryId')
                ->whereNull('sub_categories.deleted_at') // adsnum without deleted subcategories
                ->groupBy('categories.id')
                ->orderBy('categoryStatus', 'desc')
                ->get();
            $view->with('navbarCaregories', $categories);
        });
        view()->composer(['newthemplate.header', 'newthemplate.header-login'], function($view) {
            $subCategories = SubCategory::select('sub_categories.id', 'sub_categories.categoryId', 'sub_categories.subCategoryName', DB::raw('COUNT(ads.id) as adsnum'))
                ->leftJoin('ads', 'sub_categories.id', '=', 'ads.subCategoryId')
                ->groupBy('sub_categories.id')
                ->orderBy('sort', 'desc')
                ->get();
            $view->with('navbarSubCaregories', $subCategories);
        });*/
        view()->composer(['site.inc.header'], function($view) {
            $languages = Language::all();
            $view->with('languages', $languages);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
