<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            ['key'     => 'twitter_consumer_key', 'value' => null],
            ['key'     => 'twitter_consumer_secret', 'value' => null],
            ['key'     => 'twitter_access_token', 'value' => null],
            ['key'     => 'twitter_access_token_secret', 'value' => null],
            ['key'     => 'tineye_private_key', 'value' => null],
            ['key'     => 'tineye_public_key', 'value' => null]
        ]);
    }
}
