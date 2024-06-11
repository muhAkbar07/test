<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    // protected function getActions(): array
    // {
    //     return [
    //         Actions\ButtonAction::make('custom_button')
    //             ->label('Laporan')
    //             ->url(fn() => route('download.tes'))
    //             ->openUrlInNewTab(),
    //         Actions\CreateAction::make(),
    //     ];
    // }

    public function customButtonAction()
    {
        // Logika untuk aksi tombol khusus
    }
}