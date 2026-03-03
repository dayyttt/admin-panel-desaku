<?php

namespace App\Filament\Resources\WebPotensiResource\Pages;

use App\Filament\Resources\WebPotensiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWebPotensis extends ListRecords
{
    protected static string $resource = WebPotensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
