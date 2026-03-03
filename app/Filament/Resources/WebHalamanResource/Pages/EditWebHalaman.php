<?php

namespace App\Filament\Resources\WebHalamanResource\Pages;

use App\Filament\Resources\WebHalamanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWebHalaman extends EditRecord
{
    protected static string $resource = WebHalamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
