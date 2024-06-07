<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables;
use App\Models\Ticket;
use Filament\Tables\Columns\TextColumn;
use App\Http\Livewire\Report as LivewireReport;

class Report extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-report';
    protected static string $view = 'filament.pages.report';
    protected static ?string $navigationGroup = 'Report Ticket';

    public $tickets;

    public function mount()
    {
        $this->tickets = Ticket::all();
    }

    protected function getTableQuery()
    {
        return Ticket::query();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')->label('ID')->searchable(),
            TextColumn::make('title')->label('Judul')->searchable(),
            TextColumn::make('description')
                ->label('Deskripsi')
                ->searchable()
                ->formatStateUsing(function ($state) {
                    return strip_tags($state);
                }),
            TextColumn::make('status.name')->label('Status')->searchable(),
            TextColumn::make('created_at')->label('Dibuat Pada')->dateTime()->searchable(),
            TextColumn::make('updated_at')->label('Diperbarui Pada')->dateTime()->searchable(),
            TextColumn::make('solved_at')->label('Diselesaikan Pada')->dateTime()->searchable()
        ];
    }
    
    protected function getTableFilters(): array
    {
        return [
        //
        ];
    }

}