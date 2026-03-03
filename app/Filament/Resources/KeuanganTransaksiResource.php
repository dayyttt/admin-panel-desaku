<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KeuanganTransaksiResource\Pages;
use App\Models\KeuanganTransaksi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class KeuanganTransaksiResource extends Resource
{
    protected static ?string $model = KeuanganTransaksi::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static ?string $navigationLabel = 'Transaksi';
    protected static ?string $navigationGroup = 'Keuangan';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Transaksi')->schema([
                Forms\Components\Select::make('apbdes_id')
                    ->relationship('apbdes', 'tahun')
                    ->required()->label('Tahun APBDes')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "APBDes {$record->tahun}"),
                Forms\Components\Select::make('bidang_id')
                    ->relationship('bidang', 'nama')
                    ->searchable()->preload()->label('Kegiatan APBDes'),
                Forms\Components\TextInput::make('no_bukti')->placeholder('BKU-001/2026'),
                Forms\Components\DatePicker::make('tanggal')->required()->default(now()),
                Forms\Components\Select::make('jenis')
                    ->options(['penerimaan' => '💰 Penerimaan', 'pengeluaran' => '💸 Pengeluaran'])
                    ->required(),
                Forms\Components\TextInput::make('uraian')->required(),
                Forms\Components\TextInput::make('jumlah')->numeric()->prefix('Rp')->required(),
                Forms\Components\TextInput::make('sumber_dana')
                    ->placeholder('Dana Desa / ADD / PAD / Lainnya'),
                Forms\Components\TextInput::make('penerima_pembayar')->label('Penerima / Pembayar'),
                Forms\Components\TextInput::make('rekening_tujuan'),
                Forms\Components\FileUpload::make('bukti_path')
                    ->label('Bukti Transaksi')
                    ->directory('bukti-transaksi')
                    ->image(),
                Forms\Components\Textarea::make('catatan')->rows(2),
            ])->columns(2),

            Forms\Components\Section::make('Status Verifikasi')->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => '📝 Draft',
                        'menunggu_verifikasi' => '⏳ Menunggu Verifikasi',
                        'terverifikasi' => '✅ Terverifikasi',
                        'ditolak' => '❌ Ditolak',
                    ])->default('draft'),
                Forms\Components\Textarea::make('alasan_tolak')->rows(2)
                    ->visible(fn (Forms\Get $get) => $get('status') === 'ditolak'),
            ])->columns(2)->collapsed(),

            Forms\Components\Hidden::make('diinput_oleh')->default(fn () => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('no_bukti')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('jenis')->badge()
                    ->color(fn (string $state) => $state === 'penerimaan' ? 'success' : 'danger')
                    ->formatStateUsing(fn (string $state) => $state === 'penerimaan' ? '💰 Masuk' : '💸 Keluar'),
                Tables\Columns\TextColumn::make('uraian')->searchable()->limit(40),
                Tables\Columns\TextColumn::make('jumlah')->money('IDR')->weight('bold'),
                Tables\Columns\TextColumn::make('sumber_dana')->badge()->color('info'),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'draft' => 'gray', 'menunggu_verifikasi' => 'warning',
                        'terverifikasi' => 'success', 'ditolak' => 'danger',
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('verifikasi')
                    ->label('✅ Verifikasi')
                    ->color('success')
                    ->visible(fn (KeuanganTransaksi $r) => in_array($r->status, ['draft', 'menunggu_verifikasi']))
                    ->action(function (KeuanganTransaksi $record) {
                        $record->update([
                            'status' => 'terverifikasi',
                            'diverifikasi_oleh' => Auth::id(),
                            'diverifikasi_at' => now(),
                        ]);
                        Notification::make()->success()->title('Transaksi terverifikasi!')->send();
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis')
                    ->options(['penerimaan' => 'Penerimaan', 'pengeluaran' => 'Pengeluaran']),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft', 'menunggu_verifikasi' => 'Menunggu',
                        'terverifikasi' => 'Terverifikasi', 'ditolak' => 'Ditolak',
                    ]),
            ])
            ->defaultSort('tanggal', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKeuanganTransaksis::route('/'),
            'create' => Pages\CreateKeuanganTransaksi::route('/create'),
            'edit' => Pages\EditKeuanganTransaksi::route('/{record}/edit'),
        ];
    }
}
