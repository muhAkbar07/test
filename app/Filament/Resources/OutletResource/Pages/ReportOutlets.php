<?php  


namespace App\Filament\Resources\OutletResource\Pages;

use App\Models\Outlet;
use Filament\Resources\Pages\Page;
use Filament\Resources\Tables\Table;
use Filament\Tables\Columns;

class ReportOutlets extends Page
{
    public static $title = 'Report Outlets';

    public static $view = 'filament.pages.report-outlets';

    public function table()
    {
        return Table::new()
            ->model(Outlet::class)
            ->columns([
                Columns\Text::make('outlet_code'),
                Columns\Text::make('company_name'),
                Columns\Text::make('name'),
            ]);
    }
}