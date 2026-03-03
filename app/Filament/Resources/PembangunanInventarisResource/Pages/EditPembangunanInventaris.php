<?php

namespace App\Filament\Resources\PembangunanInventarisResource\Pages;

use App\Filament\Resources\PembangunanInventarisResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPembangunanInventaris extends EditRecord
{
    protected static string $resource = PembangunanInventarisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
