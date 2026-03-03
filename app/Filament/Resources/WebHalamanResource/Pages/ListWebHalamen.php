<?php

namespace App\Filament\Resources\WebHalamanResource\Pages;

use App\Filament\Resources\WebHalamanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWebHalamen extends ListRecords
{
    protected static string $resource = WebHalamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
