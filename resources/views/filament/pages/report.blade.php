<x-filament::page>
    <div>
        {{-- @livewire('stats-overview') --}}
    </div>

    {{-- <div>
        <form wire:submit.prevent="render">
            <div>
                <label for="start_date">Start Date</label>
                <input type="date" wire:model="start_date" id="start_date" value="{{ $start_date }}">
            </div>
            <div>
                <label for="end_date">End Date</label>
                <input type="date" wire:model="end_date" id="end_date" value="{{ $end_date }}">
            </div>
            <button type="submit">Apply</button>
        </form>
        @livewire('stats-overview', ['start_date' => $start_date, 'end_date' => $end_date])
    </div> --}}
    

</x-filament::page>
