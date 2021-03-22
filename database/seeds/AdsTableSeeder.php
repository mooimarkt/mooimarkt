<?php

use App\Ads;
use App\Color;
use App\Condition;
use App\Size;
use App\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdsTableSeeder extends Seeder
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

        $faker = Faker\Factory::create();
        $subCategory = SubCategory::first();
        $color = Color::first();
        $size = Size::first();
        $condition = Condition::first();

        \App\Ads::unguard();
        for ($i = 1; $i <= 12; $i++) {
            DB::table('ads')->insert([
                'userId' => 9,
                'subCategoryId' => $subCategory->id,
                'adsName' => $faker->name,
                'adsPriceType' => 'USD',
                'adsPrice' => $faker->numberBetween($min = 10, $max = 200),
                'adsCostType' => 'USD',
                'adsCost' => $faker->numberBetween($min = 10, $max = 200),
                'adsDescription' => $faker->text(200),
                'adsCountry' => 'Ukraine',
                'adsCity' => 'Kyiv',
                'adsStatus' => 'payed',
                'adsViews' => 'payed',
                'brand' => 'Nike',
                'payment' => 'PayPal',
                'swap' => $faker->numberBetween($min = 0, $max = 1),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'expired_at' => \Carbon\Carbon::now()->addDay($i)
            ]);
        }

        foreach (Ads::all() as $ads) {
            $ads->colors()->sync([$color->id]);
            $ads->sizes()->sync([$size->id]);
            $ads->conditions()->sync([$condition->id]);
            $ads->images()->create([
                'imagePath' => '/mooimarkt/img/p-gallery-img-4.jpg',
                'cover' => 1
            ]);
            $ads->images()->create([
                'imagePath' => '/mooimarkt/img/p-gallery-img-1.jpg',
                'cover' => 1
            ]);
            $ads->images()->create([
                'imagePath' => '/mooimarkt/img/p-gallery-img-3.jpg',
                'cover' => 1
            ]);
            $ads->images()->create([
                'imagePath' => '/mooimarkt/img/p-gallery-img-2.jpg',
                'cover' => 1
            ]);
            $ads->save();
        }

        \App\Ads::reguard();
    }
}
