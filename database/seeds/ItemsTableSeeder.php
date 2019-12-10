<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            'name' => 'vegan',
            'description' => 'restau végane en face de la gare'
        ]);
        DB::table('items')->insert([
            'name' => 'paprika',
            'url' => 'https://paprika.ch'
        ]);
        DB::table('items')->insert([
            'name' => 'kf',
            'image_url' => 'https://cdn.discordapp.com/icons/628956181922185246/5c74d1ba261f479dfa5ec5a357107ebd.webp?size=128'
        ]);
        DB::table('items')->insert([
            'name' => 'evil dead 2',
        ]);
        DB::table('items')->insert([
            'name' => 'the thing',
        ]);
        DB::table('items')->insert([
            'name' => 'the fly',
        ]);
        DB::table('items')->insert([
            'name' => 'alien',
        ]);
        DB::table('items')->insert([
            'name' => 'the exorcist',
        ]);
        DB::table('items')->insert([
            'name' => 'demain',
        ]);
        DB::table('items')->insert([
            'name' => 'après-demain',
        ]);
        DB::table('items')->insert([
            'name' => 'dans deux jours',
        ]);
    }
}
