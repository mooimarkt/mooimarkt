<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Category;
use App\SubCategory;
use Illuminate\Support\Facades\DB;

class AppComposer
{
    public function compose(View $view)
    {
        $category = Category::where('categoryStatus', '!=', 0)
            ->whereNull('deleted_at')
            ->orderBy('categoryStatus', 'desc')
            ->orderBy('categoryName', 'asc')
            ->get();

        $subCategory = SubCategory::orderBy('sort', 'desc')
            ->orderBy('subCategoryName', 'asc')
            ->get();

        $language = DB::table('translator_languages')->get();

//        $currencyCode = session()->get('currency');
//
//        $conversionRate = session()->get('forexRate');

        $currency = DB::table('currency')->whereNull('deleted_at')->get();

        $view->with('category', $category)
            ->with('subCategory', $subCategory)
            ->with('language', $language)
            ->with('currency', $currency);
    }
}
