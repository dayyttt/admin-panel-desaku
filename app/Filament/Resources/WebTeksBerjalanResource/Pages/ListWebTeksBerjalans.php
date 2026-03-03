<?php

namespace App\Filament\Resources\WebTeksBerjalanResource\Pages;

use App\Filament\Resources\WebTeksBerjalanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWebTeksBerjalans extends ListRecords
{
    protected static string $resource = WebTeksBerjalanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
