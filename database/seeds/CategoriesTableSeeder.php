<?php

use App\Category;
use App\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('adsImages')->delete();
        DB::table('adsreport')->delete();
        DB::table('ads_view')->delete();
        DB::table('ads_promo')->delete();
        DB::table('ads_color')->delete();
        DB::table('ads_condition')->delete();
        DB::table('ads_size')->delete();
        DB::table('ads')->delete();

        DB::table('sub_categories')->delete();
        DB::table('categories')->delete();

        $i = 1;
        $category = Category::create([
            'categoryName' => 'Woman',
            'categoryStatus' => $i,
            'categoryImage' => '/mooimarkt/img/photo_camera.svg',
            'shid' => null,
            'lang_id' => null,
            'url' => 'women',
        ]);

/*        $subCategory = SubCategory::create([
            'subCategoryName' => 'Clothes',
            'categoryId' => $category->id,
            'sort' => 0,
            'shrid' => null,
            'filtername' => null,
            'lang_id' => null,
            'url' => 'clothes',
        ]);

        $subCategory = SubCategory::create([
            'subCategoryName' => 'Shoes',
            'categoryId' => $category->id,
            'sort' => 0,
            'shrid' => null,
            'filtername' => null,
            'lang_id' => null,
            'url' => 'shoes',
        ]);*/

        $i++;

        $category = Category::create([
            'categoryName' => 'Men',
            'categoryStatus' => $i,
            'categoryImage' => '/mooimarkt/img/photo_camera.svg',
            'shid' => null,
            'lang_id' => null,
            'url' => 'men',
        ]);

   /*     $subCategory = SubCategory::create([
            'subCategoryName' => 'Clothes',
            'categoryId' => $category->id,
            'sort' => 0,
            'shrid' => null,
            'filtername' => null,
            'lang_id' => null,
            'url' => 'clothes',
        ]);

        $subCategory = SubCategory::create([
            'subCategoryName' => 'Shoes',
            'categoryId' => $category->id,
            'sort' => 0,
            'shrid' => null,
            'filtername' => null,
            'lang_id' => null,
            'url' => 'shoes',
        ]);*/

        $i++;

        $category = Category::create([
            'categoryName' => 'Kids',
            'categoryStatus' => $i,
            'categoryImage' => '/mooimarkt/img/photo_camera.svg',
            'shid' => null,
            'lang_id' => null,
            'url' => 'kids',
        ]);

/*        $subCategory = SubCategory::create([
            'subCategoryName' => 'Clothes',
            'categoryId' => $category->id,
            'sort' => 0,
            'shrid' => null,
            'filtername' => null,
            'lang_id' => null,
            'url' => 'clothes',
        ]);

        $subCategory = SubCategory::create([
            'subCategoryName' => 'Shoes',
            'categoryId' => $category->id,
            'sort' => 0,
            'shrid' => null,
            'filtername' => null,
            'lang_id' => null,
            'url' => 'shoes',
        ]);*/

        $i++;

        $category = Category::create([
            'categoryName' => 'Home',
            'categoryStatus' => $i,
            'categoryImage' => '/mooimarkt/img/photo_camera.svg',
            'shid' => null,
            'lang_id' => null,
            'url' => 'home',
        ]);
        $i++;

        $category = Category::create([
            'categoryName' => 'Bikes',
            'categoryStatus' => $i,
            'categoryImage' => '/mooimarkt/img/photo_camera.svg',
            'shid' => null,
            'lang_id' => null,
            'url' => 'bikes',
        ]);

    }
}
