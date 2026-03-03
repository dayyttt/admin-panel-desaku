<?php

namespace App\Filament\Resources\KaderMasyarakatResource\Pages;

use App\Filament\Resources\KaderMasyarakatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKaderMasyarakat extends EditRecord
{
    protected static string $resource = KaderMasyarakatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
