<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            'company_name' => 'Công ty Cổ phần công nghệ Vitex',
            'company_address' => '15 Cầu Giấy',
            'company_domain' => 'IT tech',
            'tax_code' => '123456789',
    }
}
