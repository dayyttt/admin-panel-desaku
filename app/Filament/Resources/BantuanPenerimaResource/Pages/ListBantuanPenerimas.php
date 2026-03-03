<?php

namespace App\Filament\Resources\BantuanPenerimaResource\Pages;

use App\Filament\Resources\BantuanPenerimaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBantuanPenerimas extends ListRecords
{
    protected static string $resource = BantuanPenerimaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
