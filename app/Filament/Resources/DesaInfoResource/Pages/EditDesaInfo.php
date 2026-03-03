<?php

namespace App\Filament\Resources\DesaInfoResource\Pages;

use App\Filament\Resources\DesaInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDesaInfo extends EditRecord
{
    protected static string $resource = DesaInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
