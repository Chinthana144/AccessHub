<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Roles::Create(['name'=>'Admin']);
        Roles::Create(['name'=>'Owner']);
        Roles::Create(['name'=>'Manager']);
        Roles::Create(['name'=>'Assistant Manager']);
        Roles::Create(['name'=>'Client']);
        Roles::Create(['name'=>'Engineer']);
        Roles::Create(['name'=>'Technician']);
        Roles::Create(['name'=>'Salesman']);
        Roles::Create(['name'=>'Intern']);
        Roles::Create(['name'=>'Fired']);
    }
}
