<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NormalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'User Ngố 1',
            'email' => 'user@gmail.com',
            'type' => 2,
            'title' => 'Dev Ngố',
            'password' => Hash::make('12345678'),
            'company_id' => 1,
            'is_first_login' => 0,
            'phone' => '0123456789',
        ]);
    }
}
