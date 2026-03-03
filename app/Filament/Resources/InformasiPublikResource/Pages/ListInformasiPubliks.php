<?php

namespace App\Filament\Resources\InformasiPublikResource\Pages;

use App\Filament\Resources\InformasiPublikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInformasiPubliks extends ListRecords
{
    protected static string $resource = InformasiPublikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
