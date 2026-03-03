<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KeuanganBukuKasResource\Pages;
use App\Models\KeuanganBukuKas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KeuanganBukuKasResource extends Resource
{
    protected static ?string $model = KeuanganBukuKas::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Buku Kas Umum';
    protected static ?string $navigationGroup = 'Keuangan';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Buku Kas';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('apbdes_id')
                ->relationship('apbdes', 'tahun')
                ->required()->label('Tahun APBDes')
                ->getOptionLabelFromRecordUsing(fn ($record) => "APBDes {$record->tahun}"),
            Forms\Components\Select::make('transaksi_id')
                ->relationship('transaksi', 'uraian')
                ->searchable()->preload()->label('Transaksi'),
            Forms\Components\DatePicker::make('tanggal')->required()->default(now()),
            Forms\Components\TextInput::make('uraian')->required(),
            Forms\Components\TextInput::make('debit')->numeric()->prefix('Rp')->default(0)->label('Debit (Masuk)'),
            Forms\Components\TextInput::make('kredit')->numeric()->prefix('Rp')->default(0)->label('Kredit (Keluar)'),
            Forms\Components\TextInput::make('saldo')->numeric()->prefix('Rp')->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('uraian')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('debit')->money('IDR')->color('success')->label('Debit (Masuk)'),
                Tables\Columns\TextColumn::make('kredit')->money('IDR')->color('danger')->label('Kredit (Keluar)'),
                Tables\Columns\TextColumn::make('saldo')->money('IDR')->weight('bold'),
            ])
            ->defaultSort('tanggal', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKeuanganBukuKas::route('/'),
            'create' => Pages\CreateKeuanganBukuKas::route('/create'),
            'edit' => Pages\EditKeuanganBukuKas::route('/{record}/edit'),
        ];
    }
}
