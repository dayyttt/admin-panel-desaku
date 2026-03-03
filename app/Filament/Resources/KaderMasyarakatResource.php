<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KaderMasyarakatResource\Pages;
use App\Filament\Resources\KaderMasyarakatResource\RelationManagers;
use App\Models\KaderMasyarakat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KaderMasyarakatResource extends Resource
{
    protected static ?string $model = KaderMasyarakat::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationGroup = 'Pembangunan';
    protected static ?int $navigationSort = 4;
    protected static ?string $modelLabel = 'Kader Masyarakat';
    protected static ?string $pluralModelLabel = 'Kader Masyarakat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('penduduk_id')
                    ->relationship('penduduk', 'id'),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik')
                    ->maxLength(16),
                Forms\Components\TextInput::make('jenis_kader')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('wilayah')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_bergabung'),
                Forms\Components\Toggle::make('aktif')
                    ->required(),
                Forms\Components\TextInput::make('sertifikat')
                    ->maxLength(255),
                Forms\Components\Textarea::make('keterangan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('penduduk.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_kader')
                    ->searchable(),
                Tables\Columns\TextColumn::make('wilayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_bergabung')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sertifikat')
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
            'index' => Pages\ListKaderMasyarakats::route('/'),
            'create' => Pages\CreateKaderMasyarakat::route('/create'),
            'edit' => Pages\EditKaderMasyarakat::route('/{record}/edit'),
        ];
    }
}
