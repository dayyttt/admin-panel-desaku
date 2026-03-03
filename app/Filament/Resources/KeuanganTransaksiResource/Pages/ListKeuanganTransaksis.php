<?php

namespace App\Filament\Resources\KeuanganTransaksiResource\Pages;

use App\Filament\Resources\KeuanganTransaksiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKeuanganTransaksis extends ListRecords
{
    protected static string $resource = KeuanganTransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
