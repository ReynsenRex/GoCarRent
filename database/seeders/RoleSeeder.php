<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing roles first
        DB::table('roles')->truncate();
        
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'Admin',
                'description' => 'System administrator with full access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Customer',
                'description' => 'Regular customer who can rent cars',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Staff',
                'description' => 'Staff member who can manage bookings',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
