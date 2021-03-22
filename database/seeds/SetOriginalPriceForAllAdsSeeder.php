<?php

use App\Ads;
use Illuminate\Database\Seeder;

class SetOriginalPriceForAllAdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ads = Ads::all();

        foreach ($ads as $ad) {
            $ad->original_price = $ad->adsPrice;
            $ad->save();
        }
    }
}
