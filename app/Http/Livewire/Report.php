<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Report extends Component
{
    public $startDate;
    public $endDate;
    public $tickets;

    public function render()
    {
        $this->tickets = Ticket::query()
            ->when($this->startDate && $this->endDate, function ($query) {
                return $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->get();

        return view('livewire.report', [
            'tickets' => $this->tickets,
        ]);
    }
}