<?php

namespace Database\Seeders;

use App\Models\CampAccess;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CampAccess::create([
            'camp_id' => 1,
            'user_id' => 1,
        ]);
    }
}
