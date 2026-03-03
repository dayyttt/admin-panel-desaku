<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WilayahResource\Pages;
use App\Models\Wilayah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WilayahResource extends Resource
{
    protected static ?string $model = Wilayah::class;
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationLabel = 'Wilayah';
    protected static ?string $navigationGroup = 'Info Desa';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Wilayah';
    protected static ?string $pluralModelLabel = 'Wilayah';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('parent_id')
                ->label('Induk Wilayah')
                ->relationship('parent', 'nama')
                ->searchable()
                ->preload()
                ->nullable()
                ->helperText('Kosongkan jika ini adalah Dusun (level teratas)'),
            Forms\Components\TextInput::make('nama')->required()->maxLength(255),
            Forms\Components\Select::make('tipe')
                ->options([
                    'dusun' => 'Dusun',
                    'rw' => 'RW',
                    'rt' => 'RT',
                ])
                ->required(),
            Forms\Components\TextInput::make('kode')->required()->maxLength(10),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('tipe')->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'dusun' => 'success',
                        'rw' => 'info',
                        'rt' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('kode'),
                Tables\Columns\TextColumn::make('parent.nama')->label('Induk'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tipe')
                    ->options([
                        'dusun' => 'Dusun',
                        'rw' => 'RW',
                        'rt' => 'RT',
                    ]),
            ])
            ->defaultSort('tipe');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWilayahs::route('/'),
            'create' => Pages\CreateWilayah::route('/create'),
            'edit' => Pages\EditWilayah::route('/{record}/edit'),
        ];
    }
}
