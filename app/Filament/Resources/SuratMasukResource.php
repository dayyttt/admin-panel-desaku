<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratMasukResource\Pages;
use App\Models\SuratMasuk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class SuratMasukResource extends Resource
{
    protected static ?string $model = SuratMasuk::class;
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Surat Masuk';
    protected static ?string $navigationGroup = 'Persuratan';
    protected static ?int $navigationSort = 5;
    protected static ?string $modelLabel = 'Surat Masuk';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Surat Masuk')->schema([
                Forms\Components\TextInput::make('nomor_surat')->required(),
                Forms\Components\DatePicker::make('tanggal_surat')->required(),
                Forms\Components\DatePicker::make('tanggal_diterima')->required()->default(now()),
                Forms\Components\TextInput::make('asal_pengirim')->required(),
                Forms\Components\TextInput::make('perihal')->required(),
                Forms\Components\Textarea::make('ringkasan')->rows(2),
                Forms\Components\Select::make('sifat')
                    ->options([
                        'biasa' => 'Biasa', 'segera' => 'Segera',
                        'sangat_segera' => 'Sangat Segera', 'rahasia' => 'Rahasia',
                    ])->default('biasa'),
                Forms\Components\TextInput::make('klasifikasi'),
                Forms\Components\Textarea::make('disposisi')->rows(2),
                Forms\Components\FileUpload::make('file_path')
                    ->directory('surat-masuk')
                    ->label('Scan Surat'),
            ])->columns(2),

            Forms\Components\Hidden::make('diterima_oleh')->default(fn () => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_surat')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('tanggal_surat')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('asal_pengirim')->searchable(),
                Tables\Columns\TextColumn::make('perihal')->searchable()->limit(40),
                Tables\Columns\TextColumn::make('sifat')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'biasa' => 'gray', 'segera' => 'warning',
                        'sangat_segera' => 'danger', 'rahasia' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('tanggal_diterima')->date('d/m/Y'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('sifat')
                    ->options(['biasa' => 'Biasa', 'segera' => 'Segera', 'sangat_segera' => 'Sangat Segera', 'rahasia' => 'Rahasia']),
            ])
            ->defaultSort('tanggal_diterima', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuratMasuks::route('/'),
            'create' => Pages\CreateSuratMasuk::route('/create'),
            'edit' => Pages\EditSuratMasuk::route('/{record}/edit'),
        ];
    }
}
