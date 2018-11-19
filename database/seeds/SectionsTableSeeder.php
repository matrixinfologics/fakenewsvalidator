<?php

use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sections')->insert([
            ['name' => 'Info'],
            ['name' => 'Post Analysis'],
            ['name' => 'Replies'],
            ['name' => 'Author Profile'],
            ['name' => 'Author Latest Posts'],
            ['name' => 'Post Geo Locations'],
            ['name' => 'Similar Posts'],
            ['name' => 'Similar Posts from Same Area'],
            ['name' => 'Image Search Verification'],
            ['name' => 'Source Cross Checking'],
            ['name' => 'Discussion'],
        ]);
    }
}
