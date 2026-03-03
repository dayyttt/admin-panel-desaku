<?php

namespace App\Filament\Resources\WebTeksBerjalanResource\Pages;

use App\Filament\Resources\WebTeksBerjalanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWebTeksBerjalan extends EditRecord
{
    protected static string $resource = WebTeksBerjalanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
