<?php  

// ReportOutlets.php

namespace App\Filament\Resources\OutletResource\Pages;

use App\Models\Outlet;
use Filament\Resources\Pages\Page;
use Filament\Resources\Tables\Table;
use Filament\Tables\Columns;

class ReportOutlets extends Page
{
    public static ?string $title = 'Report Outlets'; // Perbaiki tipe data dari static $title

    // public static $view = 'filament.pages.report-outlets';
    public static string $view = 'filament.pages.report-outlets'; 

    public function table()
    {
        $query = Outlet::query();

        // Filter tanggal jika tersedia dalam parameter query
        if (request()->filled('tableFilters.start_date.start_date_from')) {
            $startDateFrom = request()->input('tableFilters.start_date.start_date_from');
            $startDateUntil = request()->input('tableFilters.start_date.start_date_until');

            $query->whereBetween('start_date', [$startDateFrom, $startDateUntil]);
        }

        return Table::new()
            ->query($query)
            ->columns([
                Columns\Text::make('outlet_code'),
                Columns\Text::make('company_name'),
                Columns\Text::make('name'),
            ]);
    }
}