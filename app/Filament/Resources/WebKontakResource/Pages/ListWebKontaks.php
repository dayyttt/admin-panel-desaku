<?php

namespace App\Filament\Resources\WebKontakResource\Pages;

use App\Filament\Resources\WebKontakResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWebKontaks extends ListRecords
{
    protected static string $resource = WebKontakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
