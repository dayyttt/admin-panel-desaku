<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DesaConfigResource\Pages;
use App\Models\DesaConfig;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DesaConfigResource extends Resource
{
    protected static ?string $model = DesaConfig::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationLabel = 'Konfigurasi Desa';
    protected static ?string $navigationGroup = 'Info Desa';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Konfigurasi Desa';

    public static function shouldRegisterNavigation(): bool
    {
        // Hanya superadmin yang bisa melihat menu ini
        return auth()->user()->tipe === 'superadmin';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Konfigurasi')->tabs([
                Forms\Components\Tabs\Tab::make('Identitas Desa')->schema([
                    Forms\Components\TextInput::make('nama_desa')->required()->maxLength(255),
                    Forms\Components\TextInput::make('kode_desa')->maxLength(20)->label('Kode Desa (Kemendagri)'),
                    Forms\Components\TextInput::make('kode_pos')->maxLength(10),
                    Forms\Components\TextInput::make('nama_kecamatan')->required(),
                    Forms\Components\TextInput::make('nama_kabupaten')->required(),
                    Forms\Components\TextInput::make('nama_provinsi')->required(),
                    Forms\Components\Textarea::make('alamat_kantor')->rows(2),
                    Forms\Components\TextInput::make('telepon'),
                    Forms\Components\TextInput::make('email')->email(),
                    Forms\Components\TextInput::make('website')->url(),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Visi, Misi & Sejarah')->schema([
                    Forms\Components\Textarea::make('visi')->rows(3),
                    Forms\Components\Textarea::make('misi')->rows(5),
                    Forms\Components\RichEditor::make('sejarah')->columnSpanFull(),
                ]),

                Forms\Components\Tabs\Tab::make('Pimpinan')->schema([
                    Forms\Components\TextInput::make('nama_kepala_desa'),
                    Forms\Components\TextInput::make('nip_kepala_desa'),
                    Forms\Components\FileUpload::make('foto_kepala_desa')->image()->directory('kepala-desa'),
                    Forms\Components\FileUpload::make('ttd_kepala_desa')->label('TTD Digital Kepala Desa')->directory('ttd'),
                    Forms\Components\FileUpload::make('stempel_desa')->image()->directory('stempel'),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Lokasi & Tampilan')->schema([
                    Forms\Components\TextInput::make('latitude')->numeric(),
                    Forms\Components\TextInput::make('longitude')->numeric(),
                    Forms\Components\FileUpload::make('logo_path')->image()->directory('logo')->label('Logo Desa'),
                    Forms\Components\FileUpload::make('foto_kantor_path')->image()->directory('kantor')->label('Foto Kantor'),
                    Forms\Components\ColorPicker::make('tema_warna'),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Surat')->schema([
                    Forms\Components\TextInput::make('format_nomor_surat')->label('Format Nomor Surat')
                        ->helperText('{nomor}/{kode_desa}/{bulan_romawi}/{tahun}'),
                    Forms\Components\TextInput::make('kode_surat_desa'),
                    Forms\Components\TextInput::make('tahun_apbdes_aktif')->numeric()->label('Tahun APBDes Aktif'),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Integrasi')->schema([
                    Forms\Components\TextInput::make('wa_api_key')->password()->label('WhatsApp API Key'),
                    Forms\Components\TextInput::make('wa_api_url')->label('WhatsApp API URL'),
                    Forms\Components\TextInput::make('wa_nomor_desa')->label('Nomor WA Desa'),
                    Forms\Components\TextInput::make('fcm_server_key')->password()->label('FCM Server Key'),
                    Forms\Components\TextInput::make('smtp_host'),
                    Forms\Components\TextInput::make('smtp_port'),
                    Forms\Components\TextInput::make('smtp_user'),
                    Forms\Components\TextInput::make('smtp_pass')->password(),
                    Forms\Components\TextInput::make('smtp_from_name'),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Sosial Media & IDM')->schema([
                    Forms\Components\TextInput::make('facebook')->url(),
                    Forms\Components\TextInput::make('instagram')->url(),
                    Forms\Components\TextInput::make('youtube')->url(),
                    Forms\Components\TextInput::make('twitter')->url(),
                    Forms\Components\TextInput::make('skor_idm_terakhir')->numeric()->label('Skor IDM'),
                    Forms\Components\TextInput::make('status_idm')->label('Status IDM'),
                    Forms\Components\TextInput::make('tahun_idm_terakhir')->numeric()->label('Tahun IDM'),
                ])->columns(2),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nama_desa')->searchable()->weight('bold'),
            Tables\Columns\TextColumn::make('nama_kecamatan'),
            Tables\Columns\TextColumn::make('nama_kabupaten'),
            Tables\Columns\TextColumn::make('nama_provinsi'),
            Tables\Columns\TextColumn::make('nama_kepala_desa'),
            Tables\Columns\TextColumn::make('status_idm')->badge(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDesaConfigs::route('/'),
            'edit' => Pages\EditDesaConfig::route('/{record}/edit'),
        ];
    }
}
