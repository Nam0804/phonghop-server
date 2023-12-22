<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Manager Ngố 1',
            'email' => 'manager1@gmail.com',
            'type' => 1,
            'title' => 'Sale Ngố Manager',
            'password' => Hash::make('12345678'),
            'company_id' => 1,
            'is_first_login' => 0,
            'phone' => '0123456789',
        ]);
    }
}
