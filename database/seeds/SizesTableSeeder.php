<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ads_size')->delete();
        DB::table('sizes')->delete();

        $sizes = [34, 35, 36, 37, 38];
        foreach ($sizes as $size) {
            DB::table('sizes')->insert([
                'title' => $size,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }
    }
}
