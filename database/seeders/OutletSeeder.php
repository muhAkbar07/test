<?php

namespace Database\Seeders;

use App\Models\Outlet;
use Illuminate\Database\Seeder;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Outlet::create(['id' => Outlet::CRITICAL, 'name' => 'GJB-001-Merdeka']);
    }
}