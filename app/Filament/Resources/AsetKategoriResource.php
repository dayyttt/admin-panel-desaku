<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsetKategoriResource\Pages;
use App\Filament\Resources\AsetKategoriResource\RelationManagers;
use App\Models\AsetKategori;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AsetKategoriResource extends Resource
{
    protected static ?string $model = AsetKategori::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Aset & Inventaris';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Kategori Aset';
    protected static ?string $pluralModelLabel = 'Kategori Aset';

    public static function shouldRegisterNavigation(): bool
    {
        // Kepala Desa tidak perlu akses menu kategori
        return auth()->user()->tipe !== 'kepala_desa';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Contoh: Tanah, Bangunan, Kendaraan'),
                Forms\Components\TextInput::make('kode')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Contoh: TNH, BGN, KND'),
                Forms\Components\Textarea::make('keterangan')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('aset_count')
                    ->counts('aset')
                    ->label('Jumlah Aset')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('nama');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAsetKategoris::route('/'),
            'create' => Pages\CreateAsetKategori::route('/create'),
            'edit' => Pages\EditAsetKategori::route('/{record}/edit'),
        ];
    }
}
