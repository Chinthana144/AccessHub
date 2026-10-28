<?php

namespace Database\Seeders;

use App\Models\Camps;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Camps::create([
            'name' =>'First Camp',
            'address' =>'First Camp Address',
            'contactPerson' =>'Camp Boss',
            'contactNo' =>'0512345678',
            'mikrotikHost' =>'192.168.1.1',
            'mikrotikPort' =>'8728',
            'mikrotikUsername' =>'Admin',
            'mikrotikPassword' =>'MikrotikPWD',
            'sheetID' =>'0',
            'is_upload' =>'0',
            'status' =>'1',
        ]);
    }//run
}//class
