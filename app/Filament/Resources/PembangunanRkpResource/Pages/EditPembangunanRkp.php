<?php

namespace App\Filament\Resources\PembangunanRkpResource\Pages;

use App\Filament\Resources\PembangunanRkpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPembangunanRkp extends EditRecord
{
    protected static string $resource = PembangunanRkpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
