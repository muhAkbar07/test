<?php

namespace App\Filament\Resources\OutletResource\Pages;

use App\Filament\Resources\OutletResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateOutlet extends CreateRecord
{
    protected static string $resource = OutletResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Outlet created successfully!')
            ->duration(10000) 
            ->body('Berhasil menambahkan outlet.');
    }
}