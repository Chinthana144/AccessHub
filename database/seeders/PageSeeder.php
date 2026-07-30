<?php

namespace Database\Seeders;

use App\Models\Pages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pages::create(['name'=>'dashboard']);
        Pages::create(['name'=>'codes']);
        Pages::create(['name'=>'codeUpload']);
        Pages::create(['name'=>'codeReset']);
        Pages::create(['name'=>'camps']);
        Pages::create(['name'=>'sheets']);
        Pages::create(['name'=>'control']);
        Pages::create(['name'=>'reports']);
        Pages::create(['name'=>'profile']);
    }
}
