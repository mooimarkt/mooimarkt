<?php

use App\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->delete();
        DB::table('languages')->insert([
            'name' => 'English',
            'slug' => 'en'
        ]);

        DB::table('languages')->insert([
            'name' => 'French',
            'slug' => 'fr'
        ]);

        DB::table('languages')->insert([
            'name' => 'Deutsch',
            'slug' => 'de'
        ]);
        DB::table('languages')->insert([
            'name' => 'Spanish',
            'slug' => 'es'
        ]);
        DB::table('languages')->insert([
            'name' => 'Italian',
            'slug' => 'it'
        ]);
    }
}
