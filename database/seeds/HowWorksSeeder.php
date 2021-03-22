<?php

use App\HowWorksCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HowWorksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('how_works_items')->delete();
        DB::table('how_works_categories')->delete();

        DB::table('how_works_categories')->insert([
            'title' => 'HOW TO BUY ITEMS',
        ]);
        DB::table('how_works_categories')->insert([
            'title' => 'HOW TO SELL ITEMS',
        ]);

        $idCategory = HowWorksCategory::where('title', 'HOW TO BUY ITEMS')->first()->id;
        DB::table('how_works_items')->insert([
            'how_works_category_id' => $idCategory,
            'image' => '/mooimarkt/img/icon_work_1.svg',
            'title' => 'Sign Up',
            'description' => 'Become a member of the best clothing flow community',
        ]);
        DB::table('how_works_items')->insert([
            'how_works_category_id' => $idCategory,
            'image' => '/mooimarkt/img/icon_work_2.svg',
            'title' => 'Pick Item',
            'description' => 'Discover the best closet treasures and select your favorite one',
        ]);
        DB::table('how_works_items')->insert([
            'how_works_category_id' => $idCategory,
            'image' => '/mooimarkt/img/icon_work_3.svg',
            'title' => 'Buy It',
            'description' => 'Contact seller to get your desired item',
        ]);

        $idCategory = HowWorksCategory::where('title', 'HOW TO SELL ITEMS')->first()->id;
        DB::table('how_works_items')->insert([
            'how_works_category_id' => $idCategory,
            'image' => '/mooimarkt/img/icon_work_1.svg',
            'title' => 'Sign Up',
            'description' => 'Become a member of the best clothing flow community',
        ]);
        DB::table('how_works_items')->insert([
            'how_works_category_id' => $idCategory,
            'image' => '/mooimarkt/img/icon_work_4.svg',
            'title' => 'Take Photos',
            'description' => 'Take a picture of your closet treasure',
        ]);
        DB::table('how_works_items')->insert([
            'how_works_category_id' => $idCategory,
            'image' => '/mooimarkt/img/icon_work_5.svg',
            'title' => 'Add Item on Site',
            'description' => 'Click “Sell” and make sure the world sees your beautiful item!',
        ]);

    }
}
