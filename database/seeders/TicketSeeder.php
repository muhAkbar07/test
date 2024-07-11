<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ticket::insert([
            [
                'priority_id' => 1,
                'unit_id' => 1,
                'owner_id' => 1,
                'problem_category_id' => 1, // Ensure this matches the inserted problem category
                'title' => 'This is a sample ticket',
                'description' => 'This is a description',
                'ticket_statuses_id' => 1,
                'updated_at' => now(),
                'created_at' => now(),
            ],
        ]);
    }
}