<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use Illuminate\Database\Seeder;

class TicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TicketStatus::upsert([
            ['id' => TicketStatus::OPEN, 'name' => 'Open'],
            ['id' => TicketStatus::PENDING, 'name' => 'Pending'],
            ['id' => TicketStatus::PROGRES, 'name' => 'Progres'],
            ['id' => TicketStatus::CLOSE, 'name' => 'Close'],
        ], ['id'], ['name']);
    }
}