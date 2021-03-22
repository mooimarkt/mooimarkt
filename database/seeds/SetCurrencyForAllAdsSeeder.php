<?php

use App\Ads;
use Illuminate\Database\Seeder;

class SetCurrencyForAllAdsSeeder extends Seeder
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
            $ad->adsPriceType = 'EUR';
            $ad->adsCostType = 'EUR';
            $ad->save();
        }
    }
}
