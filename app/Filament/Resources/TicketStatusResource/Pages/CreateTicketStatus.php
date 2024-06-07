<?php

namespace App\Filament\Resources\TicketStatusResource\Pages;

use App\Filament\Resources\TicketStatusResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTicketStatus extends CreateRecord
{
    protected static string $resource = TicketStatusResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}