<?php
namespace App\Filament\Resources\SuratArsipResource\Pages;
use App\Filament\Resources\SuratArsipResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuratArsips extends ListRecords
{
    protected static string $resource = SuratArsipResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Surat Baru')
                ->icon('heroicon-o-plus-circle')
                ->color('success'),
        ];
    }
}
