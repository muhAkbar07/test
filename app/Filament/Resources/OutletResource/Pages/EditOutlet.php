<?php

namespace App\Filament\Resources\OutletResource\Pages;

use App\Filament\Resources\OutletResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;


class EditOutlet extends EditRecord
{
    protected static string $resource = OutletResource::class;

    protected function getActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
            // Actions\ForceDeleteAction::make(),
            // Actions\RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Outlet updated successfully!')
            ->duration(10000) 
            ->body('Berhasil Menugubah Outlet.');
    }
}