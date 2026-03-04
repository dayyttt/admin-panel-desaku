<?php

namespace App\Filament\Resources\DesaInfoResource\Pages;

use App\Filament\Resources\DesaInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateDesaInfo extends CreateRecord
{
    protected static string $resource = DesaInfoResource::class;
    
    public function getSubheading(): ?string
    {
        return '💡 Catatan: Data identitas desa (nama, logo, alamat, visi, misi) dikelola di menu Info Desa → Konfigurasi Desa. Menu ini untuk konten tambahan website saja.';
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Pastikan data field tidak null
        if (!isset($data['data']) || $data['data'] === null) {
            $data['data'] = [];
        }
        
        return $data;
    }
    
    protected function getRedirectUrl(): string
    {
        // Redirect ke list setelah create
        return $this->getResource()::getUrl('index');
    }
    
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Informasi Desa berhasil dibuat')
            ->body('Data telah tersimpan dengan baik.');
    }
    
    protected function getCreateAnotherFormAction(): Actions\Action
    {
        return parent::getCreateAnotherFormAction()
            ->label('Buat & buat lainnya');
    }
    
    protected function getCreateFormAction(): Actions\Action
    {
        return parent::getCreateFormAction()
            ->label('Buat');
    }
}
