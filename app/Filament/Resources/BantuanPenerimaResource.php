<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BantuanPenerimaResource\Pages;
use App\Filament\Resources\BantuanPenerimaResource\RelationManagers;
use App\Models\BantuanPenerima;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BantuanPenerimaResource extends Resource
{
    protected static ?string $model = BantuanPenerima::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Bantuan Sosial';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Penerima Bantuan';
    protected static ?string $pluralModelLabel = 'Penerima Bantuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('program_id')
                    ->relationship('program', 'id')
                    ->required(),
                Forms\Components\Select::make('penduduk_id')
                    ->relationship('penduduk', 'id'),
                Forms\Components\TextInput::make('nik')
                    ->required()
                    ->maxLength(16),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tahun')
                    ->required(),
                Forms\Components\TextInput::make('periode')
                    ->numeric(),
                Forms\Components\TextInput::make('nominal')
                    ->numeric(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_diterima'),
                Forms\Components\Textarea::make('keterangan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('program.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('penduduk.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun'),
                Tables\Columns\TextColumn::make('periode')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nominal')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('tanggal_diterima')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ListBantuanPenerimas::route('/'),
            'create' => Pages\CreateBantuanPenerima::route('/create'),
            'edit' => Pages\EditBantuanPenerima::route('/{record}/edit'),
        ];
    }
}
