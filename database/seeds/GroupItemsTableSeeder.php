<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_items')->insert([
            'group_id' => 1,
            'item_id' => 1
        ]);
        DB::table('group_items')->insert([
            'group_id' => 1,
            'item_id' => 2
        ]);
        DB::table('group_items')->insert([
            'group_id' => 1,
            'item_id' => 3
        ]);
        DB::table('group_items')->insert([
            'group_id' => 2,
            'item_id' => 4
        ]);
        DB::table('group_items')->insert([
            'group_id' => 2,
            'item_id' => 5
        ]);
        DB::table('group_items')->insert([
            'group_id' => 2,
            'item_id' => 6
        ]);
        DB::table('group_items')->insert([
            'group_id' => 2,
            'item_id' => 7
        ]);
        DB::table('group_items')->insert([
            'group_id' => 2,
            'item_id' => 8
        ]);
        DB::table('group_items')->insert([
            'group_id' => 3,
            'item_id' => 9
        ]);
        DB::table('group_items')->insert([
            'group_id' => 3,
            'item_id' => 10
        ]);
        DB::table('group_items')->insert([
            'group_id' => 3,
            'item_id' => 11
        ]);
    }
}
