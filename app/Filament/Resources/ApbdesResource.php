<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApbdesResource\Pages;
use App\Filament\Resources\ApbdesResource\RelationManagers;
use App\Models\Apbdes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ApbdesResource extends Resource
{
    protected static ?string $model = Apbdes::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'APBDes';
    protected static ?string $navigationGroup = 'Keuangan';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'APBDes';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Tahun Anggaran')->schema([
                Forms\Components\TextInput::make('tahun')->numeric()->required()
                    ->default(date('Y'))->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('nama')->default('APBDes'),
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => '📝 Draft',
                        'aktif' => '✅ Aktif',
                        'tutup_buku' => '🔒 Tutup Buku',
                    ])->default('draft'),
                Forms\Components\Textarea::make('keterangan')->rows(2),
            ])->columns(2),

            Forms\Components\Section::make('Ringkasan Anggaran')->schema([
                Forms\Components\TextInput::make('total_pendapatan')
                    ->numeric()->prefix('Rp')->disabled()->label('Total Pendapatan'),
                Forms\Components\TextInput::make('total_belanja')
                    ->numeric()->prefix('Rp')->disabled()->label('Total Belanja'),
                Forms\Components\TextInput::make('total_pembiayaan')
                    ->numeric()->prefix('Rp')->disabled()->label('Total Pembiayaan'),
                Forms\Components\TextInput::make('surplus_defisit')
                    ->numeric()->prefix('Rp')->disabled()->label('Surplus / Defisit'),
            ])->columns(4)->collapsed(),

            Forms\Components\Hidden::make('dibuat_oleh')->default(fn () => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahun')->badge()->color('info')->size('lg')->sortable(),
                Tables\Columns\TextColumn::make('nama'),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'draft' => 'gray', 'aktif' => 'success', 'tutup_buku' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'draft' => '📝 Draft', 'aktif' => '✅ Aktif', 'tutup_buku' => '🔒 Tutup Buku',
                    }),
                Tables\Columns\TextColumn::make('total_pendapatan')->money('IDR')->label('Pendapatan'),
                Tables\Columns\TextColumn::make('total_belanja')->money('IDR')->label('Belanja'),
                Tables\Columns\TextColumn::make('surplus_defisit')->money('IDR')->label('Surplus/Defisit')
                    ->color(fn ($state) => $state >= 0 ? 'success' : 'danger'),
            ])
            ->defaultSort('tahun', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\BidangRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApbdes::route('/'),
            'create' => Pages\CreateApbdes::route('/create'),
            'edit' => Pages\EditApbdes::route('/{record}/edit'),
        ];
    }
}
