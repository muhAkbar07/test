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
        // Using upsert to avoid unique constraint violations
        $priorities = [
            ['id' => 1, 'name' => 'High', 'sla_hours' => 8],
            ['id' => 2, 'name' => 'Medium', 'sla_hours' => 24],
            ['id' => 3, 'name' => 'Low', 'sla_hours' => 48],
        ];

        foreach ($priorities as $priority) {
            Priority::updateOrCreate(
                ['id' => $priority['id']],
                ['name' => $priority['name'], 'sla_hours' => $priority['sla_hours']]
            );
        }
    }
}