<?php

namespace App\Filament\Resources\TanahKasDesaResource\Pages;

use App\Filament\Resources\TanahKasDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTanahKasDesa extends EditRecord
{
    protected static string $resource = TanahKasDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
