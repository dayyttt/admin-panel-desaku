<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendudukPindahResource\Pages;
use App\Models\PendudukPindah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PendudukPindahResource extends Resource
{
    protected static ?string $model = PendudukPindah::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-start-on-rectangle';
    protected static ?string $navigationLabel = 'Pindah Keluar/Masuk';
    protected static ?string $navigationGroup = 'Kependudukan';
    protected static ?int $navigationSort = 5;
    protected static ?string $modelLabel = 'Data Pindah';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Jenis & Data Penduduk')->schema([
                Forms\Components\Select::make('jenis')
                    ->options(['pindah_keluar' => '🚪 Pindah Keluar', 'datang' => '📥 Pindah Masuk (Datang)'])
                    ->required()->reactive()->label('Jenis Perpindahan'),
                Forms\Components\Select::make('penduduk_id')
                    ->relationship('penduduk', 'nama')
                    ->searchable()->preload()->label('Penduduk')
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state) {
                            $p = \App\Models\Penduduk::find($state);
                            if ($p) { $set('nik', $p->nik); $set('nama', $p->nama); }
                        }
                    }),
                Forms\Components\TextInput::make('nik')->required()->maxLength(16)->label('NIK'),
                Forms\Components\TextInput::make('nama')->required(),
                Forms\Components\DatePicker::make('tanggal_pindah')->required(),
                Forms\Components\TextInput::make('no_surat_pindah'),
                Forms\Components\TextInput::make('no_kk_baru')->maxLength(16)->label('No. KK Baru'),
            ])->columns(2),

            Forms\Components\Section::make('Tujuan (Pindah Keluar)')
                ->schema([
                    Forms\Components\Textarea::make('alamat_tujuan')->rows(2),
                    Forms\Components\TextInput::make('desa_tujuan'),
                    Forms\Components\TextInput::make('kecamatan_tujuan'),
                    Forms\Components\TextInput::make('kabupaten_tujuan'),
                    Forms\Components\TextInput::make('provinsi_tujuan'),
                    Forms\Components\Textarea::make('alasan_pindah')->rows(2),
                    Forms\Components\Select::make('klasifikasi_pindah')
                        ->options([
                            'dalam_desa' => 'Dalam Desa', 'antar_desa' => 'Antar Desa',
                            'antar_kecamatan' => 'Antar Kecamatan', 'antar_kabupaten' => 'Antar Kabupaten',
                            'antar_provinsi' => 'Antar Provinsi',
                        ]),
                ])->columns(2)
                ->visible(fn (Forms\Get $get) => $get('jenis') === 'pindah_keluar'),

            Forms\Components\Section::make('Asal (Pindah Masuk)')
                ->schema([
                    Forms\Components\Textarea::make('alamat_asal')->rows(2),
                    Forms\Components\TextInput::make('desa_asal'),
                    Forms\Components\TextInput::make('kecamatan_asal'),
                    Forms\Components\TextInput::make('kabupaten_asal'),
                    Forms\Components\TextInput::make('provinsi_asal'),
                    Forms\Components\TextInput::make('alasan_datang'),
                ])->columns(2)
                ->visible(fn (Forms\Get $get) => $get('jenis') === 'datang'),

            Forms\Components\Hidden::make('diinput_oleh')->default(fn () => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('nik')->searchable()->label('NIK'),
                Tables\Columns\TextColumn::make('jenis')->badge()
                    ->color(fn (string $state) => $state === 'pindah_keluar' ? 'warning' : 'success')
                    ->formatStateUsing(fn (string $state) => $state === 'pindah_keluar' ? 'Pindah Keluar' : 'Pindah Masuk'),
                Tables\Columns\TextColumn::make('tanggal_pindah')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('desa_tujuan')->label('Tujuan/Asal')
                    ->formatStateUsing(fn ($record) => $record->jenis === 'pindah_keluar'
                        ? ($record->desa_tujuan . ', ' . $record->kabupaten_tujuan)
                        : ($record->desa_asal . ', ' . $record->kabupaten_asal)),
                Tables\Columns\TextColumn::make('no_surat_pindah')->label('No. Surat'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis')
                    ->options(['pindah_keluar' => 'Pindah Keluar', 'datang' => 'Pindah Masuk']),
            ])
            ->defaultSort('tanggal_pindah', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendudukPindahs::route('/'),
            'create' => Pages\CreatePendudukPindah::route('/create'),
            'edit' => Pages\EditPendudukPindah::route('/{record}/edit'),
        ];
    }
}
