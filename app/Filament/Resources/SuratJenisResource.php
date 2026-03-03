<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratJenisResource\Pages;
use App\Filament\Resources\SuratJenisResource\RelationManagers;
use App\Models\SuratJenis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SuratJenisResource extends Resource
{
    protected static ?string $model = SuratJenis::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Jenis Surat';
    protected static ?string $navigationGroup = 'Persuratan';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Jenis Surat';

    public static function shouldRegisterNavigation(): bool
    {
        // Kepala Desa tidak perlu akses menu jenis surat
        return auth()->user()->tipe !== 'kepala_desa';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Jenis Surat')->tabs([
                Forms\Components\Tabs\Tab::make('Informasi Umum')->schema([
                    Forms\Components\Select::make('kategori_id')
                        ->relationship('kategori', 'nama')
                        ->searchable()->preload()->label('Kategori'),
                    Forms\Components\TextInput::make('nama')->required()->placeholder('Surat Keterangan Tidak Mampu'),
                    Forms\Components\TextInput::make('kode')->required()->unique(ignoreRecord: true)->placeholder('SKT-001'),
                    Forms\Components\TextInput::make('singkatan')->placeholder('SKTM'),
                    Forms\Components\Textarea::make('deskripsi')->rows(2),
                    Forms\Components\Toggle::make('aktif')->default(true),
                    Forms\Components\TextInput::make('urutan')->numeric()->default(0),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Template & Variabel')->schema([
                    Forms\Components\FileUpload::make('template_path')
                        ->label('Template Surat (.docx)')
                        ->directory('surat-template')
                        ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.wordprocessingml.document']),
                    Forms\Components\KeyValue::make('variabel')
                        ->label('Variabel Template')
                        ->keyLabel('Nama Variabel')
                        ->valueLabel('Label / Keterangan')
                        ->addActionLabel('+ Tambah Variabel')
                        ->helperText('Variabel yang bisa digunakan di template surat, contoh: {nama_pemohon}, {alamat}'),
                    Forms\Components\KeyValue::make('field_tambahan')
                        ->label('Field Tambahan (diisi operator)')
                        ->keyLabel('Nama Field')
                        ->valueLabel('Tipe (text/textarea/date/select)')
                        ->addActionLabel('+ Tambah Field'),
                ]),

                Forms\Components\Tabs\Tab::make('Penomoran')->schema([
                    Forms\Components\TextInput::make('format_nomor')
                        ->placeholder('{nomor}/{kode}/{romawi}/{tahun}')
                        ->helperText('Variabel: {nomor}, {kode}, {singkatan}, {romawi}, {tahun}'),
                    Forms\Components\TextInput::make('nomor_terakhir')->numeric()->default(0)->disabled(),
                    Forms\Components\TextInput::make('tahun_nomor')->disabled(),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Pengaturan')->schema([
                    Forms\Components\Toggle::make('perlu_ttd_kades')
                        ->label('Perlu TTD Kepala Desa')
                        ->default(true),
                    Forms\Components\Toggle::make('aktif_permohonan_online')
                        ->label('Bisa Diajukan Online')
                        ->default(true),
                ])->columns(2),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode')->badge()->color('info')->searchable(),
                Tables\Columns\TextColumn::make('singkatan')->badge()->color('warning'),
                Tables\Columns\TextColumn::make('nama')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('kategori.nama')->label('Kategori'),
                Tables\Columns\IconColumn::make('perlu_ttd_kades')->boolean()->label('TTD Kades'),
                Tables\Columns\IconColumn::make('aktif_permohonan_online')->boolean()->label('Online'),
                Tables\Columns\TextColumn::make('nomor_terakhir')->label('No. Terakhir'),
                Tables\Columns\IconColumn::make('aktif')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori_id')
                    ->relationship('kategori', 'nama')->label('Kategori'),
            ])
            ->reorderable('urutan')
            ->defaultSort('urutan');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PersyaratanRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuratJenis::route('/'),
            'create' => Pages\CreateSuratJenis::route('/create'),
            'edit' => Pages\EditSuratJenis::route('/{record}/edit'),
        ];
    }
}
