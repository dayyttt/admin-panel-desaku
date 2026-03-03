<?php

namespace App\Filament\Resources\WebSliderResource\Pages;

use App\Filament\Resources\WebSliderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWebSliders extends ListRecords
{
    protected static string $resource = WebSliderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
