<?php

namespace App\Filament\Resources\PriorityResource\Pages;

use App\Filament\Resources\PriorityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPriorities extends ListRecords
{
    protected static string $resource = PriorityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
