<?php

namespace App\Filament\Resources\KeuanganBukuKasResource\Pages;

use App\Filament\Resources\KeuanganBukuKasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKeuanganBukuKas extends ListRecords
{
    protected static string $resource = KeuanganBukuKasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
