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
                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                        if ($state) {
                            $jenis = SuratJenis::find($state);
                            if ($jenis) {
                                $set('nomor_surat', $jenis->generateNomorSurat());
                            }
                        }
                        // Reset data_surat when jenis changes
                        $set('data_surat', null);
                    }),
                Forms\Components\TextInput::make('nomor_surat')->required()->unique(ignoreRecord: true),
                Forms\Components\DatePicker::make('tanggal_surat')->required()->default(now()),
            ])->columns(2),

            Forms\Components\Section::make('Data Pemohon')->schema([
                Forms\Components\Select::make('penduduk_id')
                    ->label('Pilih Penduduk (Opsional)')
                    ->options(Penduduk::query()->pluck('nama', 'id'))
                    ->searchable()->preload()
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                        if ($state) {
                            $p = Penduduk::find($state);
                            if ($p) {
                                $set('nik_pemohon', $p->nik);
                                $set('nama_pemohon', $p->nama);
                                
                                // Auto-fill data_surat dari penduduk
                                $dataSurat = $get('data_surat') ?? [];
                                $dataSurat['nik'] = $p->nik;
                                $dataSurat['nama_pemohon'] = $p->nama;
                                $dataSurat['tempat_lahir'] = $p->tempat_lahir;
                                $dataSurat['tanggal_lahir'] = $p->tanggal_lahir;
                                $dataSurat['jenis_kelamin'] = $p->jenis_kelamin;
                                $dataSurat['agama'] = $p->agama;
                                $dataSurat['pekerjaan'] = $p->pekerjaan;
                                $dataSurat['alamat'] = $p->alamat;
                                $dataSurat['rt'] = $p->rt;
                                $dataSurat['rw'] = $p->rw;
                                $dataSurat['dusun'] = $p->dusun;
                                $set('data_surat', $dataSurat);
                            }
                        }
                    })
                    ->helperText('Pilih dari database penduduk untuk auto-fill data'),
                Forms\Components\TextInput::make('nik_pemohon')->maxLength(16)->label('NIK')->required(),
                Forms\Components\TextInput::make('nama_pemohon')->required()->label('Nama Lengkap'),
                Forms\Components\Textarea::make('keperluan')->rows(2)->label('Keperluan Surat'),
            ])->columns(2),

            // FORM DINAMIS - Generate berdasarkan variabel jenis surat
            Forms\Components\Section::make('Data Detail Surat')
                ->schema(function (Forms\Get $get): array {
                    $suratJenisId = $get('surat_jenis_id');
                    
                    if (!$suratJenisId) {
                        return [
                            Forms\Components\Placeholder::make('info')
                                ->content('Pilih jenis surat terlebih dahulu untuk menampilkan form detail.')
                                ->columnSpanFull(),
                        ];
                    }
                    
                    $jenis = SuratJenis::find($suratJenisId);
                    
                    if (!$jenis || !$jenis->variabel) {
                        return [
                            Forms\Components\Placeholder::make('info')
                                ->content('Jenis surat ini tidak memiliki variabel tambahan.')
                                ->columnSpanFull(),
                        ];
                    }
                    
                    $fields = [];
                    
                    foreach ($jenis->variabel as $key => $label) {
                        // Skip field yang sudah ada di section Data Pemohon
                        if (in_array($key, ['nik', 'nama_pemohon', 'keperluan'])) {
                            continue;
                        }
                        
                        // Generate field berdasarkan nama variabel
                        $field = self::generateFieldFromVariable($key, $label);
                        
                        if ($field) {
                            $fields[] = $field;
                        }
                    }
                    
                    if (empty($fields)) {
                        return [
                            Forms\Components\Placeholder::make('info')
                                ->content('Semua data sudah terisi di section Data Pemohon.')
                                ->columnSpanFull(),
                        ];
                    }
                    
                    return $fields;
                })
                ->columns(2)
                ->collapsible()
                ->collapsed(false),

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
            Forms\Components\Hidden::make('data_surat'),
        ]);
    }
    
    /**
     * Generate form field berdasarkan nama variabel
     */
    private static function generateFieldFromVariable(string $key, string $label)
    {
        // Field tanggal
        if (str_contains($key, 'tanggal') || str_contains($key, '_lahir') && str_contains($key, 'tanggal')) {
            return Forms\Components\DatePicker::make("data_surat.{$key}")
                ->label($label)
                ->displayFormat('d/m/Y');
        }
        
        // Field jenis kelamin
        if (str_contains($key, 'jenis_kelamin')) {
            return Forms\Components\Select::make("data_surat.{$key}")
                ->label($label)
                ->options([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ]);
        }
        
        // Field agama
        if (str_contains($key, 'agama')) {
            return Forms\Components\Select::make("data_surat.{$key}")
                ->label($label)
                ->options([
                    'Islam' => 'Islam',
                    'Kristen' => 'Kristen',
                    'Katolik' => 'Katolik',
                    'Hindu' => 'Hindu',
                    'Buddha' => 'Buddha',
                    'Konghucu' => 'Konghucu',
                ]);
        }
        
        // Field status pernikahan
        if (str_contains($key, 'status') && (str_contains($label, 'nikah') || str_contains($label, 'kawin'))) {
            return Forms\Components\Select::make("data_surat.{$key}")
                ->label($label)
                ->options([
                    'Belum Kawin' => 'Belum Kawin',
                    'Kawin' => 'Kawin',
                    'Cerai Hidup' => 'Cerai Hidup',
                    'Cerai Mati' => 'Cerai Mati',
                ]);
        }
        
        // Field textarea untuk field panjang
        if (str_contains($key, 'alamat') || str_contains($key, 'keterangan') || 
            str_contains($key, 'alasan') || str_contains($key, 'kronologi') ||
            str_contains($key, 'deskripsi') || str_contains($key, 'isi_')) {
            return Forms\Components\Textarea::make("data_surat.{$key}")
                ->label($label)
                ->rows(3);
        }
        
        // Field number untuk angka
        if (str_contains($key, 'jumlah') || str_contains($key, 'luas') || 
            str_contains($key, 'penghasilan') || str_contains($key, 'harga') ||
            str_contains($key, 'umur') || str_contains($key, 'tahun')) {
            return Forms\Components\TextInput::make("data_surat.{$key}")
                ->label($label)
                ->numeric();
        }
        
        // Default: TextInput
        return Forms\Components\TextInput::make("data_surat.{$key}")
            ->label($label);
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('surat_jenis_id')
                    ->relationship('suratJenis', 'nama')->label('Jenis Surat'),
            ])
            ->emptyStateHeading('Belum ada surat')
            ->emptyStateDescription('Klik tombol "Buat Surat Baru" untuk membuat surat pertama.')
            ->emptyStateIcon('heroicon-o-document-text')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Buat Surat Baru')
                    ->icon('heroicon-o-plus-circle'),
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
