<div>
    <x-filament::table>
        <x-slot name="head">
            <x-filament::table-header-cell>Name</x-filament::table-header-cell>
            <x-filament::table-header-cell>Value</x-filament::table-header-cell>
        </x-slot>

        @foreach ($stats as $stat)
            <x-filament::table-row>
                <x-filament::table-cell>{{ $stat->name }}</x-filament::table-cell>
                <x-filament::table-cell>{{ $stat->value }}</x-filament::table-cell>
            </x-filament::table-row>
        @endforeach
    </x-filament::table>

    {{ $stats->links() }}
</div>
