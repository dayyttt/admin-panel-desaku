<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratKategoriResource\Pages;
use App\Models\SuratKategori;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SuratKategoriResource extends Resource
{
    protected static ?string $model = SuratKategori::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationLabel = 'Kategori Surat';
    protected static ?string $navigationGroup = 'Persuratan';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Kategori Surat';

    public static function shouldRegisterNavigation(): bool
    {
        // Kepala Desa tidak perlu akses menu kategori
        return auth()->user()->tipe !== 'kepala_desa';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama')->required(),
            Forms\Components\TextInput::make('kode')->required()->unique(ignoreRecord: true),
            Forms\Components\Textarea::make('deskripsi')->rows(2),
            Forms\Components\TextInput::make('urutan')->numeric()->default(0),
            Forms\Components\Toggle::make('aktif')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode')->badge()->color('success'),
                Tables\Columns\TextColumn::make('nama')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('jenislist_count')->counts('jenislist')->label('Jumlah Jenis'),
                Tables\Columns\IconColumn::make('aktif')->boolean(),
            ])
            ->reorderable('urutan')
            ->defaultSort('urutan');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuratKategoris::route('/'),
            'create' => Pages\CreateSuratKategori::route('/create'),
            'edit' => Pages\EditSuratKategori::route('/{record}/edit'),
        ];
    }
}
