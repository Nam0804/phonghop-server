<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            'adm_name' => 'Admin Bố',
            'adm_email' => 'admin@admin.com',
            'adm_password' => Hash::make('12345678'),
            'adm_phone' => '0123456789',
            'adm_role' => 1,
        ]);
    }
}
