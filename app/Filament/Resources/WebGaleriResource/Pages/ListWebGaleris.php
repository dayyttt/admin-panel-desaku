<?php

namespace App\Filament\Resources\WebGaleriResource\Pages;

use App\Filament\Resources\WebGaleriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWebGaleris extends ListRecords
{
    protected static string $resource = WebGaleriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
