<?php

namespace App\Filament\Resources\AsetKategoriResource\Pages;

use App\Filament\Resources\AsetKategoriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAsetKategori extends EditRecord
{
    protected static string $resource = AsetKategoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
