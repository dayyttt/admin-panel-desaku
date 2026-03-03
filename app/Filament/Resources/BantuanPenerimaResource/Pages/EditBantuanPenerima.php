<?php

namespace App\Filament\Resources\BantuanPenerimaResource\Pages;

use App\Filament\Resources\BantuanPenerimaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBantuanPenerima extends EditRecord
{
    protected static string $resource = BantuanPenerimaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
