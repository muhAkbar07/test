<?php

namespace Database\Seeders;

use App\Models\ProblemCategory;
use Illuminate\Database\Seeder;

class ProblemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProblemCategory::upsert([
            [
                'id' => 1, // Ensure the id is 1
                'unit_id' => 1,
                'name' => 'Information Technology',
            ],
        ], ['id'], ['unit_id', 'name']);
    }
}