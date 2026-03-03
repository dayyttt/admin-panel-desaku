<?php

namespace App\Filament\Widgets;

use App\Models\SuratArsip;
use App\Models\KeuanganTransaksi;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class AktivitasTerbaru extends BaseWidget
{
    protected static ?string $heading = 'Transaksi Keuangan Terbaru';
    protected static ?int $sort = 6;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(KeuanganTransaksi::query()->latest('tanggal')->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')->date('d/m/Y'),
                Tables\Columns\TextColumn::make('jenis')->badge()
                    ->color(fn (string $state) => $state === 'penerimaan' ? 'success' : 'danger')
                    ->formatStateUsing(fn (string $state) => $state === 'penerimaan' ? '💰 Masuk' : '💸 Keluar'),
                Tables\Columns\TextColumn::make('uraian')->limit(30),
                Tables\Columns\TextColumn::make('jumlah')->money('IDR')->weight('bold'),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'draft' => 'gray', 'menunggu_verifikasi' => 'warning',
                        'terverifikasi' => 'success', 'ditolak' => 'danger', default => 'gray',
                    }),
            ])
            ->paginated(false);
    }
}
