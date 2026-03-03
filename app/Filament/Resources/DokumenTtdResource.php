<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DokumenTtdResource\Pages;
use App\Models\DokumenTtd;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DokumenTtdResource extends Resource
{
    protected static ?string $model = DokumenTtd::class;
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationLabel = 'TTD & Stempel';
    protected static ?string $navigationGroup = 'Persuratan';
    protected static ?int $navigationSort = 6;
    protected static ?string $modelLabel = 'TTD & Stempel';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama')->required()->placeholder('H. Ahmad Latuconsina'),
            Forms\Components\TextInput::make('jabatan')->required()->placeholder('Kepala Desa Lesane'),
            Forms\Components\FileUpload::make('ttd_path')
                ->label('File Tanda Tangan')
                ->image()->directory('ttd'),
            Forms\Components\FileUpload::make('stempel_path')
                ->label('File Stempel')
                ->image()->directory('stempel'),
            Forms\Components\Toggle::make('aktif')->default(true),
            Forms\Components\Toggle::make('default')->label('Gunakan Sebagai Default'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->weight('bold')->searchable(),
                Tables\Columns\TextColumn::make('jabatan'),
                Tables\Columns\ImageColumn::make('ttd_path')->label('TTD')->height(40),
                Tables\Columns\ImageColumn::make('stempel_path')->label('Stempel')->height(40),
                Tables\Columns\IconColumn::make('aktif')->boolean(),
                Tables\Columns\IconColumn::make('default')->boolean()->label('Default'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDokumenTtds::route('/'),
            'create' => Pages\CreateDokumenTtd::route('/create'),
            'edit' => Pages\EditDokumenTtd::route('/{record}/edit'),
        ];
    }
}
