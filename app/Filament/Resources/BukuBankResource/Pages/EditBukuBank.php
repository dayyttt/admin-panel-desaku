<?php

namespace App\Filament\Resources\BukuBankResource\Pages;

use App\Filament\Resources\BukuBankResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBukuBank extends EditRecord
{
    protected static string $resource = BukuBankResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
