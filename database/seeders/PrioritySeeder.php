<?php


// database/seeders/PrioritySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Priority;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Priority::create(['id' => 1, 'name' => 'High', 'sla_hours' => 8]); // Contoh nilai untuk sla_hours
        Priority::create(['id' => 2, 'name' => 'Medium', 'sla_hours' => 24]); // Contoh nilai untuk sla_hours
        Priority::create(['id' => 3, 'name' => 'Low', 'sla_hours' => 48]); // Contoh nilai untuk sla_hours
    }
}