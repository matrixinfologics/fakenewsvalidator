<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->insert([
            'first_name'     => 'Super',
            'last_name' => 'Admin',
            'email'    => 'admin@yopmail.com',
            'password' => Hash::make('Matrix@123'),
            'role' => 'admin',
        ]);
    }
}
