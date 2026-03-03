<?php

namespace App\Filament\Resources\KeuanganBukuKasResource\Pages;

use App\Filament\Resources\KeuanganBukuKasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKeuanganBukuKas extends EditRecord
{
    protected static string $resource = KeuanganBukuKasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
