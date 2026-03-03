<?php

namespace App\Filament\Resources\AsetKategoriResource\Pages;

use App\Filament\Resources\AsetKategoriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAsetKategoris extends ListRecords
{
    protected static string $resource = AsetKategoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
