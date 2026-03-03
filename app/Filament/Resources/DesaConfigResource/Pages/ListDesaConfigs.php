<?php

namespace App\Filament\Resources\DesaConfigResource\Pages;

use App\Filament\Resources\DesaConfigResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDesaConfigs extends ListRecords
{
    protected static string $resource = DesaConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
