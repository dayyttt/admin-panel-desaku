<?php

namespace App\Filament\Resources\BantuanProgramResource\Pages;

use App\Filament\Resources\BantuanProgramResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBantuanPrograms extends ListRecords
{
    protected static string $resource = BantuanProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
