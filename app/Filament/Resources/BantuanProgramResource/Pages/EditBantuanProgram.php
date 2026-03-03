<?php

namespace App\Filament\Resources\BantuanProgramResource\Pages;

use App\Filament\Resources\BantuanProgramResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBantuanProgram extends EditRecord
{
    protected static string $resource = BantuanProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
