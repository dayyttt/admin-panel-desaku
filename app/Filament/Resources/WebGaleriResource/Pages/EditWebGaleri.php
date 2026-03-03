<?php

namespace App\Filament\Resources\WebGaleriResource\Pages;

use App\Filament\Resources\WebGaleriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWebGaleri extends EditRecord
{
    protected static string $resource = WebGaleriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
