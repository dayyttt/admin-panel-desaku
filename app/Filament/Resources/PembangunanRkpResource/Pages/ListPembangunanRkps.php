<?php

namespace App\Filament\Resources\PembangunanRkpResource\Pages;

use App\Filament\Resources\PembangunanRkpResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPembangunanRkps extends ListRecords
{
    protected static string $resource = PembangunanRkpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
