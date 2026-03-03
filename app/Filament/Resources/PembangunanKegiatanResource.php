<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembangunanKegiatanResource\Pages;
use App\Filament\Resources\PembangunanKegiatanResource\RelationManagers;
use App\Models\PembangunanKegiatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembangunanKegiatanResource extends Resource
{
    protected static ?string $model = PembangunanKegiatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'Pembangunan';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Kegiatan Pembangunan';
    protected static ?string $pluralModelLabel = 'Kegiatan Pembangunan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('rkp_id')
                    ->relationship('rkp', 'id'),
                Forms\Components\Select::make('apbdes_bidang_id')
                    ->relationship('apbdesBidang', 'id'),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('lokasi')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('panjang')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar')
                    ->numeric(),
                Forms\Components\TextInput::make('satuan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('anggaran')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('realisasi')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('progres_fisik')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\DatePicker::make('tanggal_mulai'),
                Forms\Components\DatePicker::make('tanggal_selesai_rencana'),
                Forms\Components\DatePicker::make('tanggal_selesai_aktual'),
                Forms\Components\TextInput::make('kontraktor')
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\TextInput::make('foto_progres'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rkp.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('apbdesBidang.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('panjang')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('satuan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('anggaran')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('realisasi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('progres_fisik')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_selesai_rencana')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_selesai_aktual')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kontraktor')
                    ->searchable(),
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
            'index' => Pages\ListPembangunanKegiatans::route('/'),
            'create' => Pages\CreatePembangunanKegiatan::route('/create'),
            'edit' => Pages\EditPembangunanKegiatan::route('/{record}/edit'),
        ];
    }
}
