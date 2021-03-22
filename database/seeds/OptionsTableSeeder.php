<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $slider = [
            ['image_url' => '/mooimarkt/img/main_slider_img.jpg',
                'slider_content' => '<img src="/mooimarkt/img/text_slider.png" alt=""><p>On Thousands of Items</p>',
                'url_link' => '#',
                'url_name' => 'Save now'],
            ['image_url' => '/mooimarkt/img/main_slider_img.jpg',
                'slider_content' => '<img src="/mooimarkt/img/text_slider.png" alt=""><p>On Thousands of Items</p>',
                'url_link' => '#',
                'url_name' => 'Save now'],
            ['image_url' => '/mooimarkt/img/main_slider_img.jpg',
                'slider_content' => '<img src="/mooimarkt/img/text_slider.png" alt=""><p>On Thousands of Items</p>'],
            ['image_url' => '/mooimarkt/img/main_slider_img.jpg',
                'slider_content' => '<img src="/mooimarkt/img/text_slider.png" alt=""><p>On Thousands of Items</p>',
                'url_link' => '#',
                'url_name' => 'Save now'],
        ];

        DB::table('options')->where('name', 'opt_slider')->delete();

        DB::table('options')->insert([
            'name' => 'opt_slider',
            'value' => json_encode($slider),
            'entity_id' => 0,
            'entity_type' => 'settings',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
