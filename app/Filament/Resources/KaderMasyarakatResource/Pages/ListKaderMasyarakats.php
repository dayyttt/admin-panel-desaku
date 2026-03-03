<?php

namespace App\Filament\Resources\KaderMasyarakatResource\Pages;

use App\Filament\Resources\KaderMasyarakatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKaderMasyarakats extends ListRecords
{
    protected static string $resource = KaderMasyarakatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
