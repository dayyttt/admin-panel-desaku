<?php

namespace App\Filament\Resources\KeuanganTransaksiResource\Pages;

use App\Filament\Resources\KeuanganTransaksiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKeuanganTransaksi extends EditRecord
{
    protected static string $resource = KeuanganTransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
