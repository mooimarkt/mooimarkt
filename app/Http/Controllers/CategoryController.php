<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;
use App\Category;
use App\TranslatorTranslations;

class CategoryController extends Controller
{
    
    public function getCategory(){

        return view('Admin/CategoryPage');

    }

    public function getCategoryTable(){

        $categoryTable = DB::table('categories')
                        ->select('id', 'categoryName', 'categoryStatus', 'categoryImage')
                        ->whereNull('categories.deleted_at')
                        ->get();

        return Datatables::of($categoryTable)->make(true);
    }

    public function addCategory(Request $request){  

        $categoryName = $request->input('categoryName');
        $categoryStatus = $request->input('categoryStatus');
        $categoryImage = $request->file('categoryImage');
        $checkCategoryName = Category::where('categoryName', $categoryName)->first();
        

        if($checkCategoryName == null){
            
            $category = new Category;

            $path = $categoryImage->store('public/img');
            $pathImage = str_replace("public", "storage", $path);

            $category->categoryName = $categoryName;
            $category->categoryStatus = $categoryStatus;
            $category->categoryImage = $pathImage;
            $category->save();

            $trans = new TranslatorTranslations;
            $trans->addTranslation('categories', $categoryName);

            // $allLocales = DB::table('translator_languages')->get();

            // foreach($allLocales as $locale){
            //     $exists = DB::table('translator_translations')
            //                 ->where('locale', $locale)
            //                 ->where('group', 'categories')
            //                 ->where('item', $categoryName)
            //                 ->select()->get();

            //     if(count($exists) <= 0){
            //         $translationData = new TranslatorTranslations;
            //         $translationData->locale = $locale;
            //         $translationData->namespace = '*';
            //         $translationData->group = 'categories';
            //         $translationData->item = $categoryName;
            //         $translationData->text = $categoryName;
            //         $translationData->unstable = 0;
            //         $translationData->locked = 0;
            //         $translationData->save();
            //     }
            // }

            $result = array('success' => 1);
            return $result;
        }
        else{
            $result = array('success' => 0);
            return $result;
        }
    }

    public function updateCategory(Request $request){

        $categoryId = $request->input('categoryId');
        $categoryName = $request->input('modaltxtCategoryName');
        $categoryStatus = $request->input('modaltxtCategoryStatus');
        $needUpdate = $request->input('needUpdate');

        $checkCategoryName = Category::where('categoryName', $categoryName)->first();

        $checkCategoryNameQuery = Category::find($categoryId);

        if($checkCategoryName == null || $categoryName == $checkCategoryNameQuery->categoryName ){

            $category = Category::find($categoryId);

            if($needUpdate == "true"){

                $categoryImage = $request->file('modalInputFileCategory');
                $path = $categoryImage->store('public/img');
                $pathImage = str_replace("public", "storage", $path);
                $category->categoryImage = $pathImage;
            }
            
            $category->categoryName = $categoryName;
            $category->categoryStatus = $categoryStatus;
            $category->save();

            $result = array('success' => 1);
            return $result;
        }
        else{
            $result = array('success' => 0);
            return $result;
        }
    }

    public function deleteCategory(Request $request){

        $categoryId = $request->input('categoryId');
        $category = Category::find($categoryId);

        $category->delete();
        $result = array('success' => 1);
        return $result;
    }


    /**
     * Display a listing of the category subcategories.
     *
     * @return \Illuminate\Http\Response
     */
    public function subCategories()
    {
        if (request()->wantsJson())
            return \App\SubCategory::select('id', 'subCategoryName', 'filtername')
            ->where('categoryId', request()->categoryId)
            ->orderBy('sort', 'desc')
            ->get();
    }

}
