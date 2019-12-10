<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    private function createUser()
    {
        return [
            'name' => Str::random(10),
            'email' => Str::random(10) . '@gmail.com',
            'password' => bcrypt('password'),
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [[
            'name' => '1d6',
            'email' => '1d6@1d6.com',
            'password' => bcrypt('1d6')
        ]];
        for ($i = 0; $i < 20; ++$i) {
            array_push($users, $this->createUser());
        }

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
