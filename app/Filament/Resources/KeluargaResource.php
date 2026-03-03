<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KeluargaResource\Pages;
use App\Models\Keluarga;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KeluargaResource extends Resource
{
    protected static ?string $model = Keluarga::class;
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Kartu Keluarga';
    protected static ?string $navigationGroup = 'Kependudukan';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Kartu Keluarga';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Kartu Keluarga')->schema([
                Forms\Components\TextInput::make('no_kk')
                    ->required()->unique(ignoreRecord: true)->maxLength(16)->label('Nomor KK'),
                Forms\Components\TextInput::make('nama_kepala_keluarga')
                    ->required()->label('Nama Kepala Keluarga'),
                Forms\Components\Select::make('wilayah_rt_id')
                    ->relationship('wilayahRt', 'nama')
                    ->searchable()->preload()->label('RT'),
                Forms\Components\Textarea::make('alamat')->required()->rows(2),
                Forms\Components\TextInput::make('kode_pos')->maxLength(10),
                Forms\Components\Select::make('status')
                    ->options([
                        'aktif' => 'Aktif',
                        'tidak_aktif' => 'Tidak Aktif',
                        'pindah' => 'Pindah',
                    ])->default('aktif'),
                Forms\Components\DatePicker::make('tanggal_buat_kk')->label('Tanggal Buat KK'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_kk')->label('No. KK')->searchable()->copyable()->weight('bold'),
                Tables\Columns\TextColumn::make('nama_kepala_keluarga')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('alamat')->limit(40)->toggleable(),
                Tables\Columns\TextColumn::make('wilayahRt.nama')->label('RT'),
                Tables\Columns\TextColumn::make('anggota_count')->counts('anggota')->label('Anggota')
                    ->badge()->color('info'),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'aktif' => 'success', 'pindah' => 'warning', default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'aktif' => 'Aktif',
                        'tidak_aktif' => 'Tidak Aktif',
                        'pindah' => 'Pindah',
                    ]),
            ])
            ->defaultSort('nama_kepala_keluarga');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKeluargas::route('/'),
            'create' => Pages\CreateKeluarga::route('/create'),
            'edit' => Pages\EditKeluarga::route('/{record}/edit'),
        ];
    }
}
