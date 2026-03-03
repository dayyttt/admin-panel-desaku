<?php

namespace App\Filament\Resources\BukuBankResource\Pages;

use App\Filament\Resources\BukuBankResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBukuBanks extends ListRecords
{
    protected static string $resource = BukuBankResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
