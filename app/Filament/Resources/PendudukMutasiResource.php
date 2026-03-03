<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendudukMutasiResource\Pages;
use App\Models\PendudukMutasi;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class PendudukMutasiResource extends Resource
{
    protected static ?string $model = PendudukMutasi::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Log Mutasi';
    protected static ?string $navigationGroup = 'Kependudukan';
    protected static ?int $navigationSort = 6;
    protected static ?string $modelLabel = 'Mutasi Penduduk';

    public static function shouldRegisterNavigation(): bool
    {
        // Hanya superadmin dan operator yang bisa melihat log mutasi
        return in_array(auth()->user()->tipe, ['superadmin', 'operator']);
    }

    public static function canCreate(): bool
    {
        return false; // Mutasi dibuat otomatis oleh sistem
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nik')->searchable()->label('NIK'),
                Tables\Columns\TextColumn::make('penduduk.nama')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('jenis_mutasi')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'lahir' => 'success',
                        'mati' => 'danger',
                        'pindah_keluar' => 'warning',
                        'datang' => 'info',
                        'ubah_data' => 'gray',
                        'hapus' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'lahir' => '👶 Lahir',
                        'mati' => '⚰️ Meninggal',
                        'pindah_keluar' => '🚪 Pindah Keluar',
                        'datang' => '📥 Datang',
                        'ubah_data' => '✏️ Ubah Data',
                        'hapus' => '🗑️ Dihapus',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('keterangan')->limit(50)->toggleable(),
                Tables\Columns\TextColumn::make('operator.name')->label('Oleh'),
                Tables\Columns\TextColumn::make('tanggal_mutasi')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_mutasi')
                    ->options([
                        'lahir' => 'Lahir', 'mati' => 'Meninggal',
                        'pindah_keluar' => 'Pindah Keluar', 'datang' => 'Datang',
                        'ubah_data' => 'Ubah Data', 'hapus' => 'Dihapus',
                    ]),
            ])
            ->defaultSort('tanggal_mutasi', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendudukMutasis::route('/'),
        ];
    }
}
