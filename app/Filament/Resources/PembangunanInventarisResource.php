<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembangunanInventarisResource\Pages;
use App\Filament\Resources\PembangunanInventarisResource\RelationManagers;
use App\Models\PembangunanInventaris;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembangunanInventarisResource extends Resource
{
    protected static ?string $model = PembangunanInventaris::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Pembangunan';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Inventaris Hasil';
    protected static ?string $pluralModelLabel = 'Inventaris Hasil Pembangunan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kegiatan_id')
                    ->relationship('kegiatan', 'id'),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('lokasi')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_serah_terima'),
                Forms\Components\TextInput::make('penerima')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kondisi')
                    ->required()
                    ->maxLength(255)
                    ->default('baik'),
                Forms\Components\TextInput::make('nilai')
                    ->numeric(),
                Forms\Components\TextInput::make('foto')
                    ->maxLength(255),
                Forms\Components\Textarea::make('keterangan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kegiatan.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lokasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_serah_terima')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('penerima')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kondisi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nilai')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('foto')
                    ->searchable(),
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
            'index' => Pages\ListPembangunanInventaris::route('/'),
            'create' => Pages\CreatePembangunanInventaris::route('/create'),
            'edit' => Pages\EditPembangunanInventaris::route('/{record}/edit'),
        ];
    }
}
