<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Http\Livewire\StatsOverview;
use Filament\Tables\Filters\SelectFilter;


class Report extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.report';

    protected static ?string $navigationGroup = 'Laporan NEW';

    public $start_date;
    public $end_date;
    
    
    
}   