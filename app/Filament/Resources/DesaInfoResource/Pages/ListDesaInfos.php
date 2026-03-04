<?php

namespace App\Filament\Resources\DesaInfoResource\Pages;

use App\Filament\Resources\DesaInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDesaInfos extends ListRecords
{
    protected static string $resource = DesaInfoResource::class;

    public function getHeading(): string
    {
        return 'Konten Profil Desa';
    }

    public function getSubheading(): ?string
    {
        return 'Kelola konten tambahan untuk halaman profil website. Data identitas desa (nama, logo, alamat) ada di menu Info Desa → Konfigurasi Desa.';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
