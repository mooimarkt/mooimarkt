<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ColorsTableSeeder::class);
        $this->call(SizesTableSeeder::class);
        $this->call(ConditionsTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(AdsTableSeeder::class);
        $this->call(OptionsTableSeeder::class);
        $this->call(ContactPagesTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(QACategoriesTableSeeder::class);
        $this->call(QAItemsTableSeeder::class);
        $this->call(HowWorksSeeder::class);

    }
}
