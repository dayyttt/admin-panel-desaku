<?php

namespace App\Filament\Resources\PendudukMutasiResource\Pages;

use App\Filament\Resources\PendudukMutasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendudukMutasi extends EditRecord
{
    protected static string $resource = PendudukMutasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
