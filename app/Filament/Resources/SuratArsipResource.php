<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratArsipResource\Pages;
use App\Models\SuratArsip;
use App\Models\SuratJenis;
use App\Models\Penduduk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Notifications\Notification;
use App\Services\SuratGeneratorService;

class SuratArsipResource extends Resource
{
    protected static ?string $model = SuratArsip::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Arsip Surat Keluar';
    protected static ?string $navigationGroup = 'Persuratan';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Surat Keluar';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Surat')->schema([
                Forms\Components\Select::make('surat_jenis_id')
                    ->relationship('suratJenis', 'nama')
                    ->searchable()->preload()->required()
                    ->label('Jenis Surat')
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state) {
                            $jenis = SuratJenis::find($state);
                            if ($jenis) {
                                $set('nomor_surat', $jenis->generateNomorSurat());
                            }
                        }
                    }),
                Forms\Components\TextInput::make('nomor_surat')->required()->unique(ignoreRecord: true),
                Forms\Components\DatePicker::make('tanggal_surat')->required()->default(now()),
            ])->columns(2),

            Forms\Components\Section::make('Data Pemohon')->schema([
                Forms\Components\Select::make('penduduk_id')
                    ->label('Pilih Penduduk')
                    ->options(Penduduk::query()->pluck('nama', 'id'))
                    ->searchable()->preload()
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state) {
                            $p = Penduduk::find($state);
                            if ($p) {
                                $set('nik_pemohon', $p->nik);
                                $set('nama_pemohon', $p->nama);
                            }
                        }
                    }),
                Forms\Components\TextInput::make('nik_pemohon')->maxLength(16)->label('NIK'),
                Forms\Components\TextInput::make('nama_pemohon')->required(),
                Forms\Components\Textarea::make('keperluan')->rows(2),
            ])->columns(2),

            Forms\Components\Section::make('TTD & Verifikasi')->schema([
                Forms\Components\Select::make('ttd_id')
                    ->relationship('ttd', 'nama')
                    ->searchable()->preload()
                    ->label('Penandatangan'),
                Forms\Components\TextInput::make('qr_code')
                    ->label('Kode QR Verifikasi')
                    ->disabled()
                    ->helperText('Kode QR otomatis saat surat disimpan'),
            ])->columns(2)->collapsed(),

            Forms\Components\Hidden::make('dibuat_oleh')->default(fn () => Auth::id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_surat')->searchable()->weight('bold')->copyable(),
                Tables\Columns\TextColumn::make('suratJenis.singkatan')->badge()->color('info')->label('Jenis'),
                Tables\Columns\TextColumn::make('nama_pemohon')->searchable(),
                Tables\Columns\TextColumn::make('nik_pemohon')->searchable()->label('NIK'),
                Tables\Columns\TextColumn::make('tanggal_surat')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('qr_code')->badge()->color('success')->label('QR'),
                Tables\Columns\IconColumn::make('file_pdf_path')
                    ->boolean()
                    ->trueIcon('heroicon-o-document-check')
                    ->falseIcon('heroicon-o-x-mark')
                    ->getStateUsing(fn ($record) => !empty($record->file_pdf_path))
                    ->label('PDF'),
            ])
            ->actions([
                Tables\Actions\Action::make('generate_pdf')
                    ->label('📄 PDF')
                    ->color('success')
                    ->icon('heroicon-o-document-arrow-down')
                    ->requiresConfirmation()
                    ->modalHeading('Generate PDF Surat')
                    ->modalDescription('Apakah Anda yakin ingin generate PDF untuk surat ini?')
                    ->modalSubmitActionLabel('Ya, Generate')
                    ->action(function (SuratArsip $record) {
                        try {
                            $service = new SuratGeneratorService();
                            $pdfPath = $service->generateSurat($record);
                            
                            $record->update(['file_pdf_path' => $pdfPath]);
                            
                            Notification::make()
                                ->success()
                                ->title('PDF berhasil digenerate!')
                                ->body('File: ' . basename($pdfPath))
                                ->duration(5000)
                                ->send();
                                
                        } catch (\Exception $e) {
                            Notification::make()
                                ->danger()
                                ->title('Gagal generate PDF')
                                ->body($e->getMessage())
                                ->duration(10000)
                                ->send();
                        }
                    })
                    ->visible(fn (SuratArsip $record) => empty($record->file_pdf_path)),
                Tables\Actions\Action::make('download_pdf')
                    ->label('⬇️ Download')
                    ->color('info')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn (SuratArsip $record) => !empty($record->file_pdf_path))
                    ->action(function (SuratArsip $record) {
                        $filePath = storage_path('app/public/' . $record->file_pdf_path);
                        if (file_exists($filePath)) {
                            return response()->download($filePath);
                        } else {
                            Notification::make()
                                ->danger()
                                ->title('File tidak ditemukan')
                                ->body('File PDF tidak ditemukan. Silakan generate ulang.')
                                ->send();
                        }
                    }),
                Tables\Actions\Action::make('regenerate_pdf')
                    ->label('🔄 Regenerate')
                    ->color('warning')
                    ->icon('heroicon-o-arrow-path')
                    ->requiresConfirmation()
                    ->modalHeading('Regenerate PDF')
                    ->modalDescription('PDF yang lama akan ditimpa. Lanjutkan?')
                    ->visible(fn (SuratArsip $record) => !empty($record->file_pdf_path))
                    ->action(function (SuratArsip $record) {
                        try {
                            // Hapus file lama
                            if ($record->file_pdf_path) {
                                \Storage::disk('public')->delete($record->file_pdf_path);
                            }
                            
                            $service = new SuratGeneratorService();
                            $pdfPath = $service->generateSurat($record);
                            
                            $record->update(['file_pdf_path' => $pdfPath]);
                            
                            Notification::make()
                                ->success()
                                ->title('PDF berhasil di-regenerate!')
                                ->send();
                                
                        } catch (\Exception $e) {
                            Notification::make()
                                ->danger()
                                ->title('Gagal regenerate PDF')
                                ->body($e->getMessage())
                                ->send();
                        }
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('surat_jenis_id')
                    ->relationship('suratJenis', 'nama')->label('Jenis Surat'),
            ])
            ->defaultSort('tanggal_surat', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuratArsips::route('/'),
            'create' => Pages\CreateSuratArsip::route('/create'),
            'edit' => Pages\EditSuratArsip::route('/{record}/edit'),
        ];
    }
}
