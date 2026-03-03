<?php

namespace App\Filament\Resources\PendudukMutasiResource\Pages;

use App\Filament\Resources\PendudukMutasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendudukMutasis extends ListRecords
{
    protected static string $resource = PendudukMutasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
