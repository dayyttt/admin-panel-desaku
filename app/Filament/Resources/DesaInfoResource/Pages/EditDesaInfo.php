<?php

namespace App\Filament\Resources\DesaInfoResource\Pages;

use App\Filament\Resources\DesaInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditDesaInfo extends EditRecord
{
    protected static string $resource = DesaInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Informasi Desa berhasil diperbarui')
            ->body('Perubahan data telah tersimpan.');
    }
}
