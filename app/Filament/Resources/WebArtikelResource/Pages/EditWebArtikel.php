<?php

namespace App\Filament\Resources\WebArtikelResource\Pages;

use App\Filament\Resources\WebArtikelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWebArtikel extends EditRecord
{
    protected static string $resource = WebArtikelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
