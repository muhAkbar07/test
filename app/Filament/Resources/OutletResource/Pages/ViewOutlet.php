<?php

namespace App\Filament\Resources\OutletResource\Pages;

use App\Filament\Resources\OutletResource;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\OutletResource\Pages\Actions\EditAction;

class ViewOutlet extends ViewRecord
{
    protected static string $resource = OutletResource::class;

    protected function getActions(): array
    {
        return [
            // EditAction::make(),
            // Actions\EditAction::make(),
        ];
    }
}