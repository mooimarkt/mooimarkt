<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QACategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('q_a_items')->delete();
        DB::table('q_a_categories')->delete();

        DB::table('q_a_categories')->insert([
            'image' => '/mooimarkt/img/questions_answers_1.svg',
            'title' => 'GETTING STARTED',
            'slug' => 'getting-started',
            'description' => 'To become a registered user, you first you log in with  Facebook, Instagram or create 
an account using your email address.',
        ]);
        DB::table('q_a_categories')->insert([
            'image' => "/mooimarkt/img/questions_answers_2.svg",
            'title' => 'USING MOOIMARKT',
            'slug' => 'using-mooimarkt',
            'description' => 'You can easily sell, buy or swap your items on the website with other registered users.  /more...',
        ]);
        DB::table('q_a_categories')->insert([
            'image' => "/mooimarkt/img/questions_answers_3.svg",
            'title' => 'ADD PLACEMENT',
            'slug' => 'add-placement',
            'description' => 'The price for one advertisement placed on the website is 0.50 cents and makes it activate for 30 days. /more...',
        ]);
        DB::table('q_a_categories')->insert([
            'image' => "/mooimarkt/img/questions_answers_4.svg",
            'title' => 'FOR BUYERS',
            'slug' => 'for-buyers',
            'description' => 'As a registered user to buy your desired item, you have to  contact the seller by sending a message. more...',
        ]);
        DB::table('q_a_categories')->insert([
            'image' => "/mooimarkt/img/questions_answers_5.svg",
            'title' => 'FOR SELLERS',
            'slug' => 'for-sellers',
            'description' => 'Sign up, upload your virtual wallet, take photos and add items for sale. more…',
        ]);
    }
}
