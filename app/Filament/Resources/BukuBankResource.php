<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BukuBankResource\Pages;
use App\Models\BukuBank;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BukuBankResource extends Resource
{
    protected static ?string $model = BukuBank::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationLabel = 'Buku Bank';
    protected static ?string $navigationGroup = 'Keuangan';
    protected static ?int $navigationSort = 4;
    protected static ?string $modelLabel = 'Buku Bank';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Rekening Bank')->schema([
                Forms\Components\Select::make('apbdes_id')
                    ->relationship('apbdes', 'tahun')
                    ->required()->label('Tahun APBDes')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "APBDes {$record->tahun}"),
                Forms\Components\TextInput::make('nama_bank')->required()->placeholder('BRI'),
                Forms\Components\TextInput::make('nomor_rekening')->required(),
                Forms\Components\TextInput::make('atas_nama')->required(),
            ])->columns(2),

            Forms\Components\Section::make('Mutasi')->schema([
                Forms\Components\DatePicker::make('tanggal')->required()->default(now()),
                Forms\Components\TextInput::make('uraian')->required(),
                Forms\Components\TextInput::make('debit')->numeric()->prefix('Rp')->default(0)->label('Debit (Masuk)'),
                Forms\Components\TextInput::make('kredit')->numeric()->prefix('Rp')->default(0)->label('Kredit (Keluar)'),
                Forms\Components\TextInput::make('saldo')->numeric()->prefix('Rp')->disabled(),
                Forms\Components\Toggle::make('sudah_rekonsiliasi')->label('Sudah Direkonsiliasi'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('nama_bank')->badge()->color('info'),
                Tables\Columns\TextColumn::make('nomor_rekening'),
                Tables\Columns\TextColumn::make('uraian')->searchable()->limit(35),
                Tables\Columns\TextColumn::make('debit')->money('IDR')->color('success'),
                Tables\Columns\TextColumn::make('kredit')->money('IDR')->color('danger'),
                Tables\Columns\TextColumn::make('saldo')->money('IDR')->weight('bold'),
                Tables\Columns\IconColumn::make('sudah_rekonsiliasi')->boolean()->label('Rekon'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('sudah_rekonsiliasi')
                    ->label('Status Rekonsiliasi'),
            ])
            ->defaultSort('tanggal', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBukuBanks::route('/'),
            'create' => Pages\CreateBukuBank::route('/create'),
            'edit' => Pages\EditBukuBank::route('/{record}/edit'),
        ];
    }
}
