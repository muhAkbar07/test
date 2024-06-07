<?php

namespace App\Filament\Resources\PriorityResource\Pages;

use App\Filament\Resources\PriorityResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPriority extends EditRecord
{
    protected static string $resource = PriorityResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}