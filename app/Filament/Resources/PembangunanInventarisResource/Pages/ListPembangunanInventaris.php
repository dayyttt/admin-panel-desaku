<?php

namespace App\Filament\Resources\PembangunanInventarisResource\Pages;

use App\Filament\Resources\PembangunanInventarisResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPembangunanInventaris extends ListRecords
{
    protected static string $resource = PembangunanInventarisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
