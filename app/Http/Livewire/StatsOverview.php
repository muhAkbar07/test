<?php

namespace App\Http\Livewire;

use Livewire\Component;

class StatsOverview extends Component
{
    public $start_date;
    public $end_date;

    public function mount($start_date = null, $end_date = null)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function render()
    {
        $data = $this->getData();

        return view('livewire.stats-overview', ['data' => $data]);
    }

    protected function getData()
    {
        // Implementasikan logika untuk mengambil data berdasarkan start_date dan end_date
        return [];
    }
}