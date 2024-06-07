<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Filters\Filter;

class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    // protected function getActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }

    protected function getTableFilters(): array
    {
        return [
            Filter::make('start_date')
                ->form([
                    \Filament\Forms\Components\DatePicker::make('start_date_from')
                        ->label('Start Date From'),
                    \Filament\Forms\Components\DatePicker::make('start_date_until')
                        ->label('Start Date Until'),
                ])
                ->query(function ($query, array $data) {
                    return $query
                        ->when($data['start_date_from'], fn($query, $date) => $query->whereDate('start_date', '>=', $date))
                        ->when($data['start_date_until'], fn($query, $date) => $query->whereDate('start_date', '<=', $date));
                }),
            Filter::make('end_date')
                ->form([
                    \Filament\Forms\Components\DatePicker::make('end_date_from')
                        ->label('End Date From'),
                    \Filament\Forms\Components\DatePicker::make('end_date_until')
                        ->label('End Date Until'),
                ])
                ->query(function ($query, array $data) {
                    return $query
                        ->when($data['end_date_from'], fn($query, $date) => $query->whereDate('end_date', '>=', $date))
                        ->when($data['end_date_until'], fn($query, $date) => $query->whereDate('end_date', '<=', $date));
                }),
        ];
    }
}