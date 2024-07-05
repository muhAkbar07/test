<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket;
use Carbon\Carbon;

class UpdateHighPriorityTickets extends Command
{
    protected $signature = 'tickets:update-high-priority';
    protected $description = 'Perbarui tiket prioritas tinggi yang belum diperbarui dalam 2 jam terakhir';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $duaJamLalu = Carbon::now()->subHours(2);
        $tiketPrioritasTinggi = Ticket::where('priority_id', Priority::HIGH)
            ->where('updated_at', '<', $duaJamLalu)
            ->where('ticket_statuses_id', '!=', TicketStatus::REJECTED)
            ->get();

        foreach ($tiketPrioritasTinggi as $ticket) {
            $ticket->ticket_statuses_id = TicketStatus::REJECTED;
            $ticket->save();
        }

        $this->info('Tiket prioritas tinggi berhasil diperbarui.');
    }
}