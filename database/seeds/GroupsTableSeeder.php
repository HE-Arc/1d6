<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            'name' => 'Repas de midi'
        ]);
        DB::table('groups')->insert([
            'name' => 'Film du samedi soir'
        ]);
        DB::table('groups')->insert([
            'name' => 'Date du championnat de yo-yo'
        ]);
        DB::table('groups')->insert([
            'name' => 'Attribution des notes pour les projets DevWeb'
        ]);
    }
}
