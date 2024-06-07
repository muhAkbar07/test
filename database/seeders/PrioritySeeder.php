<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Priority::create(['id' => Priority::CRITICAL, 'name' => 'Critical/Urgent', 'sla_hours' => 2]);
        Priority::create(['id' => Priority::HIGH, 'name' => 'High', 'sla_hours' => 4]);
        Priority::create(['id' => Priority::MEDIUM, 'name' => 'Medium', 'sla_hours' => 8]);
        Priority::create(['id' => Priority::LOW, 'name' => 'Low', 'sla_hours' => 24]);
    }
}