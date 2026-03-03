<?php

namespace App\Filament\Resources\PembangunanKegiatanResource\Pages;

use App\Filament\Resources\PembangunanKegiatanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPembangunanKegiatan extends EditRecord
{
    protected static string $resource = PembangunanKegiatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
