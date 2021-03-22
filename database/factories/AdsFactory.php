<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Ads::class, function (Faker $faker) use ($factory) {
    return [
        'userId' => 9,
        'adsName' => $faker->name,
        'adsPriceType' => 'USD',
        'adsPrice' => $faker->numberBetween($min = 10, $max = 200),
        'adsCostType' => 'USD',
        'adsCost' => $faker->numberBetween($min = 10, $max = 200),
        'adsDescription' => $faker->text(200),
        'adsCountry' => $faker->country,
        'adsCity' => $faker->city,
        'adsStatus' => 'payed',
        'payment' => 'PayPal',
        'swap' => $faker->numberBetween($min = 0, $max = 1),
        'expired_at' => Carbon::now()->addDay(10)
    ];
});