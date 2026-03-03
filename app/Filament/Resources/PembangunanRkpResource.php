<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembangunanRkpResource\Pages;
use App\Filament\Resources\PembangunanRkpResource\RelationManagers;
use App\Models\PembangunanRkp;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembangunanRkpResource extends Resource
{
    protected static ?string $model = PembangunanRkp::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Pembangunan';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'RKP Desa';
    protected static ?string $pluralModelLabel = 'RKP Desa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tahun')
                    ->required(),
                Forms\Components\TextInput::make('nama_kegiatan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('bidang')
                    ->maxLength(255),
                Forms\Components\Textarea::make('lokasi')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('volume')
                    ->numeric(),
                Forms\Components\TextInput::make('satuan_volume')
                    ->maxLength(255),
                Forms\Components\TextInput::make('anggaran')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('sumber_dana')
                    ->maxLength(255),
                Forms\Components\TextInput::make('prioritas')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\Textarea::make('keterangan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahun'),
                Tables\Columns\TextColumn::make('nama_kegiatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bidang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('volume')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('satuan_volume')
                    ->searchable(),
                Tables\Columns\TextColumn::make('anggaran')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sumber_dana')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prioritas'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPembangunanRkps::route('/'),
            'create' => Pages\CreatePembangunanRkp::route('/create'),
            'edit' => Pages\EditPembangunanRkp::route('/{record}/edit'),
        ];
    }
}
