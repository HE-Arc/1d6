<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            GroupsTableSeeder::class,
            ItemsTableSeeder::class,
            GroupUsersTableSeeder::class,
            GroupItemsTableSeeder::class,
            ItemDefaultRatingsTableSeeder::class,
            ]);
    }
}
