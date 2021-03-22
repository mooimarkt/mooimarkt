<?php

/*Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push(trans('label-terms.home'), url('/'));
});

Breadcrumbs::register('allads', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('All', url('getAllAds'));
});

Breadcrumbs::register('adsBySubCategory', function ($breadcrumbs) {
    $subCategoryId = session()->get('subCategoryIdForBreadcrumb');
    $subCategoryName = session()->get('subCategoryNameForBreadcrumb');
    $categoryId = session()->get('categoryIdForBreadcrumb');
    $categoryName = session()->get('categoryNameForBreadcrumb');

    $breadcrumbs->parent('home');

    if(count(explode(".", trans('categories.'.$categoryName))) > 1)
        $breadcrumbs->push(explode(".", trans('categories.'.$categoryName))[1], url('getAdsByCategory/'.$categoryId));
    else
        $breadcrumbs->push(trans('categories.'.$categoryName), url('getAdsByCategory/'.$categoryId));

    if(count(explode(".", trans('subcategories.'.$subCategoryName))) > 1)
        $breadcrumbs->push(explode(".", trans('subcategories.'.$subCategoryName))[1], url('getAdsBySubCategory/'.$subCategoryId));
    else
        $breadcrumbs->push(trans('subcategories.'.$subCategoryName), url('getAdsBySubCategory/'.$subCategoryId));
    
    session()->forget('subCategoryIdForBreadcrumb');
    session()->forget('subCategoryNameForBreadcrumb');
    session()->forget('categoryIdForBreadcrumb');
    session()->forget('categoryNameForBreadcrumb');
});

Breadcrumbs::register('adsByCategory', function ($breadcrumbs) {
    $categoryId = session()->get('categoryIdForBreadcrumb');
    $categoryName = session()->get('categoryNameForBreadcrumb');

    $breadcrumbs->parent('home');
    
    if(count(explode(".", trans('categories.'.$categoryName))) > 1)
        $breadcrumbs->push(explode(".", trans('categories.'.$categoryName))[1], url('getAdsByCategory/'.$categoryId));
    else
        $breadcrumbs->push(trans('categories.'.$categoryName), url('getAdsByCategory/'.$categoryId));

    session()->forget('categoryIdForBreadcrumb');
    session()->forget('categoryNameForBreadcrumb');
});

Breadcrumbs::register('adsdetails', function ($breadcrumbs) {
    $adsId = session()->get('adsIdForBreadcrumb');
    $adsName = session()->get('adsNameForBreadcrumb');
    $subCategoryId = session()->get('subCategoryIdForBreadcrumb');
    $subCategoryName = session()->get('subCategoryNameForBreadcrumb');
    $categoryId = session()->get('categoryIdForBreadcrumb');
    $categoryName = session()->get('categoryNameForBreadcrumb');

    $breadcrumbs->parent('home');
    
    if(count(explode(".", trans('categories.'.$categoryName))) > 1)
        $breadcrumbs->push(explode(".", trans('categories.'.$categoryName))[1], url('getAdsByCategory/'.$categoryId));
    else
        $breadcrumbs->push(trans('categories.'.$categoryName), url('getAdsByCategory/'.$categoryId));

    if(count(explode(".", trans('subcategories.'.$subCategoryName))) > 1)
        $breadcrumbs->push(explode(".", trans('subcategories.'.$subCategoryName))[1], url('getAdsBySubCategory/'.$subCategoryId));
    else
        $breadcrumbs->push(trans('subcategories.'.$subCategoryName), url('getAdsBySubCategory/'.$subCategoryId));

    $breadcrumbs->push($adsName, url('getAdsDetails/'.$adsId));
    session()->forget('adsIdForBreadcrumb');
    session()->forget('adsNameForBreadcrumb');
    session()->forget('subCategoryIdForBreadcrumb');
    session()->forget('subCategoryNameForBreadcrumb');
    session()->forget('categoryIdForBreadcrumb');
    session()->forget('categoryNameForBreadcrumb');
});

Breadcrumbs::register('adsdetailsid', function ($breadcrumbs) {
    $adsId = session()->get('adsIdForBreadcrumb');
    $adsName = session()->get('adsNameForBreadcrumb');
    $subCategoryId = session()->get('subCategoryIdForBreadcrumb');
    $subCategoryName = session()->get('subCategoryNameForBreadcrumb');
    $categoryId = session()->get('categoryIdForBreadcrumb');
    $categoryName = session()->get('categoryNameForBreadcrumb');

    $breadcrumbs->parent('home');
    
    if(count(explode(".", trans('categories.'.$categoryName))) > 1)
        $breadcrumbs->push(explode(".", trans('categories.'.$categoryName))[1], url('getAdsByCategory/'.$categoryId));
    else
        $breadcrumbs->push(trans('categories.'.$categoryName), url('getAdsByCategory/'.$categoryId));

    if(count(explode(".", trans('subcategories.'.$subCategoryName))) > 1)
        $breadcrumbs->push(explode(".", trans('subcategories.'.$subCategoryName))[1], url('getAdsBySubCategory/'.$subCategoryId));
    else
        $breadcrumbs->push(trans('subcategories.'.$subCategoryName), url('getAdsBySubCategory/'.$subCategoryId));

    $breadcrumbs->push($adsName, url('getAdsDetails/'.$adsId));
    session()->forget('adsIdForBreadcrumb');
    session()->forget('adsNameForBreadcrumb');
    session()->forget('subCategoryIdForBreadcrumb');
    session()->forget('subCategoryNameForBreadcrumb');
    session()->forget('categoryIdForBreadcrumb');
    session()->forget('categoryNameForBreadcrumb');
});

Breadcrumbs::register('adsByName', function ($breadcrumbs) {
    $adsName = session()->get('adsNameForBreadcrumb');

    $breadcrumbs->parent('home');
    $breadcrumbs->push($adsName, url('getAdsByName/'.$adsName));
    session()->forget('adsNameForBreadcrumb');
});*/

// Home
use App\SubCategory;

Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push(Language::lang('Home'), url('/'));
});

Breadcrumbs::register('category', function($breadcrumbs, $category)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(Language::lang($category->categoryName), url('/category/'.$category->id));
});

Breadcrumbs::register('subCategory', function($breadcrumbs, $subCategory)
{
    $breadcrumbs->parent('category', $subCategory->Category);
    $breadcrumbs->push(Language::lang($subCategory->subCategoryName), url('/category/' . $subCategory->Category->id . '/' . $subCategory->id));
});

Breadcrumbs::register('product', function($breadcrumbs, $product)
{
    $subcategory = SubCategory::find($product->subCategoryId);

    $breadcrumbs->parent('subCategory', $subcategory);
    $breadcrumbs->push($product->adsName, route('product', $product->id));
});

Breadcrumbs::register('page', function($breadcrumbs, $page)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(Language::lang($page->title), route($page->page));
});

?>