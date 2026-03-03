<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelahiranResource\Pages;
use App\Models\Kelahiran;
use App\Models\Penduduk;
use App\Models\PendudukMutasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class KelahiranResource extends Resource
{
    protected static ?string $model = Kelahiran::class;
    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $navigationLabel = 'Proses Kelahiran';
    protected static ?string $navigationGroup = 'Kependudukan';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Kelahiran';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Bayi')->schema([
                Forms\Components\TextInput::make('nama_bayi')->required()->maxLength(255),
                Forms\Components\Select::make('jenis_kelamin')
                    ->options(['L' => 'Laki-laki', 'P' => 'Perempuan'])->required(),
                Forms\Components\DatePicker::make('tanggal_lahir')->required(),
                Forms\Components\TextInput::make('tempat_lahir')->required(),
                Forms\Components\TimePicker::make('jam_lahir'),
                Forms\Components\Select::make('jenis_kelahiran')
                    ->options(['tunggal' => 'Tunggal', 'kembar_2' => 'Kembar 2', 'kembar_3' => 'Kembar 3', 'lainnya' => 'Lainnya'])
                    ->default('tunggal'),
                Forms\Components\TextInput::make('urutan_kelahiran')->numeric()->default(1),
                Forms\Components\Select::make('penolong_kelahiran')
                    ->options(['dokter' => 'Dokter', 'bidan' => 'Bidan', 'dukun' => 'Dukun', 'lainnya' => 'Lainnya']),
                Forms\Components\TextInput::make('tempat_dilahirkan')->placeholder('RS, Puskesmas, Rumah, dll'),
                Forms\Components\TextInput::make('berat_bayi')->suffix('gram'),
                Forms\Components\TextInput::make('panjang_bayi')->suffix('cm'),
            ])->columns(2),

            Forms\Components\Section::make('Data Orang Tua')->schema([
                Forms\Components\TextInput::make('nama_ayah')->required(),
                Forms\Components\TextInput::make('nik_ayah')->maxLength(16)->label('NIK Ayah'),
                Forms\Components\TextInput::make('nama_ibu')->required(),
                Forms\Components\TextInput::make('nik_ibu')->maxLength(16)->label('NIK Ibu'),
                Forms\Components\Select::make('keluarga_id')
                    ->relationship('keluarga', 'no_kk')
                    ->searchable()->preload()->label('Masuk ke KK'),
                Forms\Components\TextInput::make('no_kk')->maxLength(16)->label('No. KK'),
            ])->columns(2),

            Forms\Components\Section::make('Akta Kelahiran')->schema([
                Forms\Components\TextInput::make('no_akta_lahir'),
                Forms\Components\DatePicker::make('tanggal_akta'),
            ])->columns(2)->collapsed(),

            Forms\Components\Hidden::make('diinput_oleh')->default(fn () => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_bayi')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('jenis_kelamin')->badge()
                    ->color(fn (string $state) => $state === 'L' ? 'info' : 'danger')
                    ->formatStateUsing(fn (string $state) => $state === 'L' ? 'Laki-laki' : 'Perempuan'),
                Tables\Columns\TextColumn::make('tanggal_lahir')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('tempat_lahir'),
                Tables\Columns\TextColumn::make('nama_ayah'),
                Tables\Columns\TextColumn::make('nama_ibu'),
                Tables\Columns\TextColumn::make('keluarga.no_kk')->label('No. KK'),
            ])
            ->defaultSort('tanggal_lahir', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKelahirans::route('/'),
            'create' => Pages\CreateKelahiran::route('/create'),
            'edit' => Pages\EditKelahiran::route('/{record}/edit'),
        ];
    }
}
