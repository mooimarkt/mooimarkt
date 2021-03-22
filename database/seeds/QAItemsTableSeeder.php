<?php

use App\QACategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QAItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('q_a_items')->delete();

        // ==========================================================================

        $idCategory = QACategory::where('slug', 'getting-started')->first()->id;

        DB::table('q_a_items')->insert([
            'q_a_category_id' => $idCategory,
            'question' => null,
            'answer' => 'To become a registered user, you first you log in with  Facebook, Instagram or create 
an account using your email address.',
        ]);

        // ==========================================================================

        $idCategory = QACategory::where('slug', 'using-mooimarkt')->first()->id;

        DB::table('q_a_items')->insert([
            'q_a_category_id' => $idCategory,
            'question' => null,
            'answer' => 'As you are logged in, you will be able to see all listed items for sale. You can select to view the items by categories or to use the search option. You can add items to your favorites, show your interest for buying the item as well as directly contact the seller for any questions you might have about the item. If you want to sell an item, first you have to transfer a certain amount of money into your virtual wallet to pay  euro 0.50 to publish your Using advertisement for your item (information, description, photo, price).'
        ]);

        // ==========================================================================

        $idCategory = QACategory::where('slug', 'add-placement')->first()->id;

        DB::table('q_a_items')->insert([
            'q_a_category_id' => $idCategory,
            'question' => null,
            'answer' => 'You have an option to renew your ad by paying 0.30 cents and make your item available again for another 30 days, or place your advertisement in the first place by paying euro 0.15 cents.'
        ]);

        DB::table('q_a_items')->insert([
            'q_a_category_id' => $idCategory,
            'question' => null,
            'answer' => 'To upload your advertisement, there must be at least one photo per item. The maximum is five photos per item. During the time when advertisement is active photos can be edited.'
        ]);

        DB::table('q_a_items')->insert([
            'q_a_category_id' => $idCategory,
            'question' => null,
            'answer' => 'The description of the item to sell has to be clear and honest so Mooimarkt community is transparent and trustful.'
        ]);

        // ==========================================================================

        $idCategory = QACategory::where('slug', 'for-buyers')->first()->id;

        DB::table('q_a_items')->insert([
            'q_a_category_id' => $idCategory,
            'question' => null,
            'answer' => 'If you have decided to buy the item, you have to contact the seller. Both users discuss and agree about the payment and delivery method (face-to-face meeting, Post.nl or DHL).',
        ]);

        // ==========================================================================

        $idCategory = QACategory::where('slug', 'for-sellers')->first()->id;

        DB::table('q_a_items')->insert([
            'q_a_category_id' => $idCategory,
            'question' => null,
            'answer' => 'You can upload your virtual wallet for 2, 5 or 10 euros. The cost for one advertisement is euro 0.50. and your advertisement will be active for 30 days. The money on your virtual wallet is non - refundable.',
        ]);

        DB::table('q_a_items')->insert([
            'q_a_category_id' => $idCategory,
            'question' => null,
            'answer' => 'To upload your advertisement, there must be at least one photo per item. The maximum is five photos per item. During the time when advertisement is active photos can be edited.',
        ]);

        DB::table('q_a_items')->insert([
            'q_a_category_id' => $idCategory,
            'question' => null,
            'answer' => 'The description of the item to sell has to be clear and honest so mooimarkt community is transparent and trustful.',
        ]);

        // ==========================================================================
    }
}
