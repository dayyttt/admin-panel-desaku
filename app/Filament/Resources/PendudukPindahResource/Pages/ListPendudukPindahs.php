<?php

namespace App\Filament\Resources\PendudukPindahResource\Pages;

use App\Filament\Resources\PendudukPindahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendudukPindahs extends ListRecords
{
    protected static string $resource = PendudukPindahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
