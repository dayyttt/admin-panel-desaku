<?php

namespace App\Filament\Resources\DesaConfigResource\Pages;

use App\Filament\Resources\DesaConfigResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDesaConfig extends EditRecord
{
    protected static string $resource = DesaConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
