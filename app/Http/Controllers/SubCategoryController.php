<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;
use App\SubCategory;
use App\Pricing;
use App\Category;
use App\TranslatorTranslations;

class SubCategoryController extends Controller
{
    
    public function getSubCategory(){

        $categories = Category::all();
        return view('Admin/SubCategoryPage', ["categories" => $categories]);

    }

    public function getSubCategoryTable(){

        $categoryTable = DB::table('categories')
                            ->join('sub_categories', 'categories.id', '=', 'sub_categories.categoryId')
                            ->join('pricing', 'pricing.subCategoryId', '=', 'sub_categories.id')
                            ->whereNull('sub_categories.deleted_at')
                            ->get();

        return Datatables::of($categoryTable)->make(true);
    }

    public function addSubCategory(Request $request){

        $categoryId = $request->input('categoryId');
        $subCategoryName = $request->input('subCategoryName');

        $basicAdsPrice = $request->input('basicPrice');
        $autoBumpPrice = $request->input('autoBumpPrice');
        $spotlightPrice = $request->input('spotlightPrice');
        $sort = $request->input('subCategorySort');

        $checkSubCategoryName = SubCategory::where('subCategoryName', $subCategoryName)
                                ->where('categoryId', $categoryId)
                                ->first();

        if($checkSubCategoryName == null){
            $subCategory = new SubCategory;
            $subCategory->categoryId = $categoryId;
            $subCategory->subCategoryName = $subCategoryName;
            $subCategory->sort = $sort;
            $subCategory->save();
            $result = array('success' => 1);

            $getAddedSubcategory = SubCategory::where('subCategoryName', $subCategoryName)
                                ->where('categoryId', $categoryId)
                                ->first();

            $subcategoryId = $getAddedSubcategory->id;

            $pricing = new Pricing;
            $pricing->subCategoryId = $subcategoryId;
            $pricing->basic = $basicAdsPrice;
            $pricing->autoBump = $autoBumpPrice;
            $pricing->spotlight = $spotlightPrice;
            $pricing->save();

            $trans = new TranslatorTranslations;
            $trans->addTranslation('subcategories', $subCategoryName);

            return $result;
        }
        else{
            $result = array('success' => 0);
            return $result;
        }
    }

    public function updateSubCategory(Request $request){

        $subCategoryId = $request->input('subCategoryId');
        $categoryId = $request->input('categoryId');
        $subCategoryName = $request->input('subCategoryName');
        $pricingId = $request->input('pricingId');
        $sort = $request->input('subCategorySort');

        $basicAdsPrice = $request->input('basicPrice');
        $autoBumpPrice = $request->input('autoBumpPrice');
        $spotlightPrice = $request->input('spotlightPrice');

        $checkSubCategoryName = SubCategory::where('subCategoryName', $subCategoryName)
                                ->where('categoryId', $categoryId)
                                ->first();

        $checkSubCategoryNameQuery = SubCategory::find($subCategoryId);

        if($checkSubCategoryName == null || $subCategoryName == $checkSubCategoryNameQuery->subCategoryName){

            $subCategory = SubCategory::find($subCategoryId);
            $subCategory->subCategoryName = $subCategoryName;
            $subCategory->sort = $sort;
            $subCategory->save();

            $pricing = Pricing::find($pricingId);
            $pricing->basic = $basicAdsPrice;
            $pricing->autoBump = $autoBumpPrice;
            $pricing->spotlight = $spotlightPrice;
            $pricing->save();

            $result = array('success' => 1);
            return $result;
        }
        else{
            $result = array('success' => 2);
            return $result;
        }
    }

    public function deleteSubCategory(Request $request){

        $subCategoryId = $request->input('subCategoryId');
        $subCategory = SubCategory::find($subCategoryId);

        $subCategory->delete();
        $result = array('success' => 1);

        return $result;
    }
}
