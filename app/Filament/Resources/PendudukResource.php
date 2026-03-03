<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendudukResource\Pages;
use App\Filament\Resources\PendudukResource\RelationManagers;
use App\Models\Penduduk;
use App\Imports\PendudukImport;
use App\Exports\PendudukExport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;

class PendudukResource extends Resource
{
    protected static ?string $model = Penduduk::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Data Penduduk';
    protected static ?string $navigationGroup = 'Kependudukan';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Penduduk';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Data Penduduk')->tabs([
                Forms\Components\Tabs\Tab::make('Identitas')->schema([
                    Forms\Components\TextInput::make('nik')->required()->unique(ignoreRecord: true)->maxLength(16)->label('NIK'),
                    Forms\Components\TextInput::make('nama')->required()->maxLength(255),
                    Forms\Components\TextInput::make('tempat_lahir')->required(),
                    Forms\Components\DatePicker::make('tanggal_lahir')->required(),
                    Forms\Components\Select::make('jenis_kelamin')
                        ->options(['L' => 'Laki-laki', 'P' => 'Perempuan'])->required(),
                    Forms\Components\Select::make('agama')
                        ->options([
                            'islam' => 'Islam', 'kristen' => 'Kristen', 'katolik' => 'Katolik',
                            'hindu' => 'Hindu', 'buddha' => 'Buddha', 'konghucu' => 'Konghucu',
                        ])->required(),
                    Forms\Components\Select::make('status_perkawinan')
                        ->options([
                            'belum_kawin' => 'Belum Kawin', 'kawin' => 'Kawin',
                            'cerai_hidup' => 'Cerai Hidup', 'cerai_mati' => 'Cerai Mati',
                        ])->required(),
                    Forms\Components\Select::make('kewarganegaraan')
                        ->options(['WNI' => 'WNI', 'WNA' => 'WNA'])->default('WNI'),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Keluarga')->schema([
                    Forms\Components\Select::make('keluarga_id')
                        ->relationship('keluarga', 'no_kk')
                        ->searchable()->preload()->label('No. KK'),
                    Forms\Components\TextInput::make('no_kk')->maxLength(16),
                    Forms\Components\Select::make('status_hubungan_keluarga')
                        ->options([
                            'kepala_keluarga' => 'Kepala Keluarga', 'suami' => 'Suami',
                            'istri' => 'Istri', 'anak' => 'Anak', 'menantu' => 'Menantu',
                            'cucu' => 'Cucu', 'orang_tua' => 'Orang Tua', 'mertua' => 'Mertua',
                            'famili_lain' => 'Famili Lain', 'pembantu' => 'Pembantu', 'lainnya' => 'Lainnya',
                        ]),
                    Forms\Components\TextInput::make('ayah_nama')->label('Nama Ayah'),
                    Forms\Components\TextInput::make('ayah_nik')->label('NIK Ayah')->maxLength(16),
                    Forms\Components\TextInput::make('ibu_nama')->label('Nama Ibu'),
                    Forms\Components\TextInput::make('ibu_nik')->label('NIK Ibu')->maxLength(16),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Pendidikan & Pekerjaan')->schema([
                    Forms\Components\Select::make('pendidikan_dalam_kk')
                        ->options([
                            'tidak_belum_sekolah' => 'Tidak/Belum Sekolah', 'belum_tamat_sd' => 'Belum Tamat SD',
                            'tamat_sd' => 'Tamat SD/Sederajat', 'sltp' => 'SLTP/Sederajat',
                            'slta' => 'SLTA/Sederajat', 'd1_d2' => 'Diploma I/II',
                            'd3' => 'Akademi/Diploma III', 's1' => 'Diploma IV/Strata I',
                            's2' => 'Strata II', 's3' => 'Strata III',
                        ]),
                    Forms\Components\TextInput::make('pekerjaan'),
                    Forms\Components\TextInput::make('pekerjaan_detail')->label('Detail Pekerjaan'),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Alamat & Wilayah')->schema([
                    Forms\Components\Select::make('wilayah_rt_id')
                        ->relationship('wilayahRt', 'nama')
                        ->searchable()->preload()->label('RT'),
                    Forms\Components\Textarea::make('alamat_lengkap')->rows(2),
                ])->columns(1),

                Forms\Components\Tabs\Tab::make('Dokumen')->schema([
                    Forms\Components\TextInput::make('no_akta_lahir'),
                    Forms\Components\TextInput::make('no_akta_perkawinan'),
                    Forms\Components\TextInput::make('no_bpjs_kesehatan')->label('No. BPJS Kesehatan'),
                    Forms\Components\TextInput::make('no_bpjs_ketenagakerjaan')->label('No. BPJS Ketenagakerjaan'),
                    Forms\Components\FileUpload::make('foto')->image()->directory('penduduk'),
                ])->columns(2),

                Forms\Components\Tabs\Tab::make('Status')->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'aktif' => 'Aktif', 'mati' => 'Meninggal', 'pindah' => 'Pindah',
                            'hilang' => 'Hilang', 'sementara' => 'Sementara',
                        ])->default('aktif'),
                    Forms\Components\Toggle::make('penerima_bantuan')->label('Penerima Bantuan Sosial'),
                    Forms\Components\TextInput::make('golongan_darah')->maxLength(5),
                ])->columns(2),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nik')->label('NIK')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('nama')->searchable()->weight('bold')->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')->badge()
                    ->color(fn (string $state) => $state === 'L' ? 'info' : 'danger')
                    ->formatStateUsing(fn (string $state) => $state === 'L' ? 'Laki-laki' : 'Perempuan'),
                Tables\Columns\TextColumn::make('tempat_lahir')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('tanggal_lahir')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('agama')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('pekerjaan')->toggleable(),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'aktif' => 'success', 'mati' => 'danger',
                        'pindah' => 'warning', default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('no_kk')->label('No. KK')->toggleable()->copyable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_kelamin')
                    ->options(['L' => 'Laki-laki', 'P' => 'Perempuan']),
                Tables\Filters\SelectFilter::make('agama')
                    ->options([
                        'islam' => 'Islam', 'kristen' => 'Kristen', 'katolik' => 'Katolik',
                        'hindu' => 'Hindu', 'buddha' => 'Buddha', 'konghucu' => 'Konghucu',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'aktif' => 'Aktif', 'mati' => 'Meninggal', 'pindah' => 'Pindah',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('import')
                    ->label('📥 Import Excel')
                    ->color('success')
                    ->form([
                        Forms\Components\FileUpload::make('file')
                            ->label('File Excel (.xlsx)')
                            ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'])
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $import = new PendudukImport;
                        Excel::import($import, storage_path('app/public/' . $data['file']));
                        $failures = $import->failures();
                        if ($failures->count() > 0) {
                            Notification::make()->warning()
                                ->title('Import selesai dengan ' . $failures->count() . ' error')
                                ->body('Beberapa baris tidak valid (NIK duplikat atau format salah).')
                                ->send();
                        } else {
                            Notification::make()->success()
                                ->title('Import berhasil!')
                                ->body('Data penduduk dari Excel telah diimport.')
                                ->send();
                        }
                    }),
                Tables\Actions\Action::make('export')
                    ->label('📤 Export Excel')
                    ->color('info')
                    ->action(fn () => Excel::download(new PendudukExport, 'penduduk_desa_lesane_' . date('Y-m-d') . '.xlsx')),
            ])
            ->defaultSort('nama');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DokumenRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenduduks::route('/'),
            'create' => Pages\CreatePenduduk::route('/create'),
            'edit' => Pages\EditPenduduk::route('/{record}/edit'),
        ];
    }
}
