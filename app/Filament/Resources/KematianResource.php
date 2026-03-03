<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KematianResource\Pages;
use App\Models\Kematian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class KematianResource extends Resource
{
    protected static ?string $model = Kematian::class;
    protected static ?string $navigationIcon = 'heroicon-o-no-symbol';
    protected static ?string $navigationLabel = 'Proses Kematian';
    protected static ?string $navigationGroup = 'Kependudukan';
    protected static ?int $navigationSort = 4;
    protected static ?string $modelLabel = 'Kematian';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Almarhum')->schema([
                Forms\Components\Select::make('penduduk_id')
                    ->relationship('penduduk', 'nama')
                    ->searchable()->preload()
                    ->label('Pilih Penduduk')
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state) {
                            $penduduk = \App\Models\Penduduk::find($state);
                            if ($penduduk) {
                                $set('nik', $penduduk->nik);
                                $set('nama', $penduduk->nama);
                            }
                        }
                    }),
                Forms\Components\TextInput::make('nik')->required()->maxLength(16)->label('NIK'),
                Forms\Components\TextInput::make('nama')->required(),
                Forms\Components\DatePicker::make('tanggal_kematian')->required(),
                Forms\Components\TimePicker::make('jam_kematian'),
                Forms\Components\TextInput::make('tempat_kematian'),
                Forms\Components\Textarea::make('penyebab_kematian')->rows(2),
                Forms\Components\Select::make('jenis_kematian')
                    ->options([
                        'wajar' => 'Wajar', 'tidak_wajar' => 'Tidak Wajar',
                        'kecelakaan' => 'Kecelakaan', 'lainnya' => 'Lainnya',
                    ])->default('wajar'),
            ])->columns(2),

            Forms\Components\Section::make('Data Pelapor')->schema([
                Forms\Components\TextInput::make('nama_pelapor')->required(),
                Forms\Components\TextInput::make('nik_pelapor')->maxLength(16)->label('NIK Pelapor'),
                Forms\Components\TextInput::make('hubungan_pelapor')->placeholder('Anak, Istri, Suami, dll'),
            ])->columns(2),

            Forms\Components\Section::make('Akta Kematian')->schema([
                Forms\Components\TextInput::make('no_akta_kematian'),
                Forms\Components\DatePicker::make('tanggal_akta'),
            ])->columns(2)->collapsed(),

            Forms\Components\Hidden::make('diinput_oleh')->default(fn () => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('nik')->searchable()->label('NIK'),
                Tables\Columns\TextColumn::make('tanggal_kematian')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('tempat_kematian'),
                Tables\Columns\TextColumn::make('jenis_kematian')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'wajar' => 'gray', 'tidak_wajar' => 'danger',
                        'kecelakaan' => 'warning', default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('nama_pelapor'),
            ])
            ->defaultSort('tanggal_kematian', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKematians::route('/'),
            'create' => Pages\CreateKematian::route('/create'),
            'edit' => Pages\EditKematian::route('/{record}/edit'),
        ];
    }
}
