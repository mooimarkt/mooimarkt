<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ads_color')->delete();
        DB::table('colors')->delete();

        $colors =  ["Red", "Green",  "Blue", "Black"];
        foreach ($colors as $color) {
            DB::table('colors')->insert([
                'title' => $color,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }

    }
}
