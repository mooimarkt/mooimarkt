<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ads_condition')->delete();
        DB::table('conditions')->delete();

        $conditions = ['condition 1', 'condition 2', 'condition 3', 'condition 4'];
        foreach ($conditions as $condition) {
            DB::table('conditions')->insert([
                'title' => $condition,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }
    }
}
