<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemDefaultRatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('item_default_ratings')->insert([
            'item_id' => 1,
            'user_id' => 1,
            'rating' => 10
        ]);
        DB::table('item_default_ratings')->insert([
            'item_id' => 2,
            'user_id' => 1,
            'rating' => 0
        ]);
        DB::table('item_default_ratings')->insert([
            'item_id' => 3,
            'user_id' => 1,
            'rating' => 5
        ]);
        DB::table('item_default_ratings')->insert([
            'item_id' => 5,
            'user_id' => 3,
            'rating' => 7
        ]);
        DB::table('item_default_ratings')->insert([
            'item_id' => 5,
            'user_id' => 1,
            'rating' => 10
        ]);
        DB::table('item_default_ratings')->insert([
            'item_id' => 5,
            'user_id' => 2,
            'rating' => 8
        ]);
    }
}
