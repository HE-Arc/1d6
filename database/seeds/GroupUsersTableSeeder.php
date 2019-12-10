<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('group_users')->insert([
            'user_id' => 1,
            'group_id' => 1,
            'admin' => true,
        ]);
        DB::table('group_users')->insert([
            'user_id' => 2,
            'group_id' => 1,
            'admin' => false,
        ]);
        DB::table('group_users')->insert([
            'user_id' => 3,
            'group_id' => 1,
            'admin' => false,
        ]);
        DB::table('group_users')->insert([
            'user_id' => 1,
            'group_id' => 2,
            'admin' => false,
        ]);
        DB::table('group_users')->insert([
            'user_id' => 5,
            'group_id' => 2,
            'admin' => true,
        ]);
        DB::table('group_users')->insert([
            'user_id' => 7,
            'group_id' => 2,
            'admin' => true,
        ]);
        DB::table('group_users')->insert([
            'user_id' => 11,
            'group_id' => 2,
            'admin' => false,
        ]);
        DB::table('group_users')->insert([
            'user_id' => 1,
            'group_id' => 3,
            'admin' => true,
        ]);
        DB::table('group_users')->insert([
            'user_id' => 19,
            'group_id' => 3,
            'admin' => true,
        ]);
        DB::table('group_users')->insert([
            'user_id' => 18,
            'group_id' => 3,
            'admin' => false,
        ]);
    }
}
