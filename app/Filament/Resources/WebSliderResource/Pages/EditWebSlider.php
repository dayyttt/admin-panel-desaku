<?php

namespace App\Filament\Resources\WebSliderResource\Pages;

use App\Filament\Resources\WebSliderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWebSlider extends EditRecord
{
    protected static string $resource = WebSliderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
