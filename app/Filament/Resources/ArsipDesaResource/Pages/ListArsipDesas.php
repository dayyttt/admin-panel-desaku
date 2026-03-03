<?php

namespace App\Filament\Resources\ArsipDesaResource\Pages;

use App\Filament\Resources\ArsipDesaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArsipDesas extends ListRecords
{
    protected static string $resource = ArsipDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
