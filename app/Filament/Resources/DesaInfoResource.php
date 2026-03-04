<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DesaInfoResource\Pages;
use App\Filament\Resources\DesaInfoResource\RelationManagers;
use App\Models\DesaInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DesaInfoResource extends Resource
{
    protected static ?string $model = DesaInfo::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    
    protected static ?string $navigationLabel = 'Konten Profil Desa';
    
    protected static ?string $modelLabel = 'Konten Profil Desa';
    
    protected static ?string $pluralModelLabel = 'Konten Profil Desa';
    
    protected static ?string $navigationGroup = 'Web Publik';
    
    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        // Kepala Desa tidak perlu akses menu web publik
        return auth()->user()->tipe !== 'kepala_desa';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Utama')
                    ->schema([
                        Forms\Components\Select::make('key')
                            ->label('Jenis Informasi')
                            ->required()
                            ->options([
                                'sejarah' => 'Sejarah',
                                'visi_misi' => 'Visi & Misi',
                                'geografi' => 'Geografi',
                                'demografi' => 'Demografi',
                                'fasilitas' => 'Fasilitas Umum',
                                'pemerintahan' => 'Pemerintahan',
                                'kontak' => 'Kontak',
                                'layanan' => 'Layanan Publik',
                            ])
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Initialize data dengan object kosong untuk menghindari null error
                                $set('data', []);
                            })
                            ->disabled(fn ($record) => $record !== null) // Disable saat edit
                            ->dehydrated() // Tetap kirim value meski disabled
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'Jenis informasi ini sudah ada. Silakan gunakan tombol "Ubah" untuk mengedit data yang sudah ada.',
                            ])
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('aktif')
                            ->label('Status Aktif')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Data Konten')
                    ->schema(fn ($get, $record) => self::getDataSchemaForKey($get('key') ?? $record?->key))
                    ->visible(fn ($get, $record) => ($get('key') ?? $record?->key) !== null),
            ]);
    }
    
    protected static function getDataSchemaForKey(?string $key): array
    {
        return match($key) {
            'kontak' => [
                Forms\Components\Textarea::make('data.alamat')
                    ->label('Alamat Lengkap')
                    ->rows(2)
                    ->columnSpanFull()
                    ->placeholder('Contoh: Jalan Raya Trans Seram KM 12, Desa Lesane...'),
                Forms\Components\TextInput::make('data.telepon')
                    ->label('Telepon')
                    ->tel()
                    ->placeholder('Contoh: 0914-21234'),
                Forms\Components\TextInput::make('data.email')
                    ->label('Email')
                    ->email()
                    ->placeholder('Contoh: desalesane@malukutengahkab.go.id'),
                Forms\Components\TextInput::make('data.website')
                    ->label('Website')
                    ->url()
                    ->placeholder('Contoh: https://lesane.malukutengahkab.go.id'),
                Forms\Components\Fieldset::make('Jam Operasional')
                    ->schema([
                        Forms\Components\TextInput::make('data.jam_operasional.hari_kerja')
                            ->label('Hari Kerja')
                            ->default('Senin - Jumat'),
                        Forms\Components\TextInput::make('data.jam_operasional.jam')
                            ->label('Jam Kerja')
                            ->default('08:00 - 16:00 WIT'),
                        Forms\Components\TextInput::make('data.jam_operasional.sabtu')
                            ->label('Sabtu')
                            ->default('08:00 - 12:00 WIT (Terbatas)'),
                        Forms\Components\TextInput::make('data.jam_operasional.minggu')
                            ->label('Minggu')
                            ->default('Tutup'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Forms\Components\Fieldset::make('Media Sosial')
                    ->schema([
                        Forms\Components\TextInput::make('data.media_sosial.facebook')
                            ->label('Facebook')
                            ->prefix('@')
                            ->placeholder('desalesane'),
                        Forms\Components\TextInput::make('data.media_sosial.instagram')
                            ->label('Instagram')
                            ->prefix('@')
                            ->placeholder('desalesane.official'),
                        Forms\Components\TextInput::make('data.media_sosial.youtube')
                            ->label('YouTube')
                            ->placeholder('https://youtube.com/@desalesane'),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ],
            'visi_misi' => [
                Forms\Components\RichEditor::make('data.visi')
                    ->label('Visi')
                    ->required()
                    ->helperText('Tuliskan visi desa dengan jelas')
                    ->placeholder('Contoh: Terwujudnya Desa Lesane yang Maju, Mandiri, dan Sejahtera')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                    ])
                    ->disableToolbarButtons([
                        'strike',
                        'link',
                        'bulletList',
                        'orderedList',
                    ]),
                Forms\Components\Repeater::make('data.misi')
                    ->label('Misi')
                    ->schema([
                        Forms\Components\Textarea::make('item')
                            ->label(false)
                            ->rows(3)
                            ->required()
                            ->placeholder('Contoh: Meningkatkan kualitas pendidikan masyarakat desa'),
                    ])
                    ->columnSpanFull()
                    ->defaultItems(1)
                    ->minItems(1)
                    ->addActionLabel('Tambah Poin Misi')
                    ->reorderable()
                    ->cloneable(),
            ],
            'sejarah' => [
                Forms\Components\RichEditor::make('data.konten')
                    ->label('Konten Sejarah')
                    ->required()
                    ->helperText('Ceritakan sejarah desa dengan lengkap. Anda bisa format teks dengan bold, italic, list, dll.')
                    ->placeholder('Contoh: Desa Lesane didirikan pada tahun 1950 oleh para pendatang dari...')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'bulletList',
                        'orderedList',
                        'h2',
                        'h3',
                        'blockquote',
                        'undo',
                        'redo',
                    ])
                    ->disableToolbarButtons([
                        'strike',
                        'link',
                    ]),
                Forms\Components\Repeater::make('data.timeline')
                    ->label('Timeline Sejarah (Opsional)')
                    ->schema([
                        Forms\Components\TextInput::make('tahun')
                            ->label('Tahun')
                            ->required()
                            ->numeric()
                            ->maxLength(4)
                            ->placeholder('Contoh: 1950'),
                        Forms\Components\Textarea::make('peristiwa')
                            ->label('Peristiwa')
                            ->rows(2)
                            ->required()
                            ->placeholder('Contoh: Desa Lesane resmi berdiri'),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->defaultItems(0)
                    ->collapsible(),
            ],
            'geografi' => [
                Forms\Components\Section::make('Koordinat Lokasi')
                    ->schema([
                        Forms\Components\TextInput::make('data.koordinat.lintang')
                            ->label('Lintang')
                            ->placeholder('Contoh: -3.2345')
                            ->helperText('Koordinat lintang dalam format desimal'),
                        Forms\Components\TextInput::make('data.koordinat.bujur')
                            ->label('Bujur')
                            ->placeholder('Contoh: 128.1234')
                            ->helperText('Koordinat bujur dalam format desimal'),
                    ])
                    ->columns(2)
                    ->collapsible(),
                Forms\Components\Section::make('Kondisi Geografis')
                    ->schema([
                        Forms\Components\TextInput::make('data.topografi')
                            ->label('Topografi')
                            ->placeholder('Contoh: Dataran rendah, perbukitan'),
                        Forms\Components\TextInput::make('data.iklim')
                            ->label('Iklim')
                            ->placeholder('Contoh: Tropis'),
                        Forms\Components\TextInput::make('data.jarak_ke_kota_kabupaten')
                            ->label('Jarak ke Kota Kabupaten')
                            ->placeholder('Contoh: 15 km'),
                    ])
                    ->columns(3)
                    ->collapsible(),
                Forms\Components\Section::make('Batas Wilayah')
                    ->schema([
                        Forms\Components\TextInput::make('data.batas_wilayah.utara')
                            ->label('Sebelah Utara')
                            ->placeholder('Contoh: Desa Seram'),
                        Forms\Components\TextInput::make('data.batas_wilayah.selatan')
                            ->label('Sebelah Selatan')
                            ->placeholder('Contoh: Laut Banda'),
                        Forms\Components\TextInput::make('data.batas_wilayah.timur')
                            ->label('Sebelah Timur')
                            ->placeholder('Contoh: Desa Masohi'),
                        Forms\Components\TextInput::make('data.batas_wilayah.barat')
                            ->label('Sebelah Barat')
                            ->placeholder('Contoh: Desa Amahai'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ],
            'demografi' => [
                Forms\Components\Section::make('Data Kependudukan')
                    ->description('Isi data kependudukan desa berdasarkan data terkini')
                    ->schema([
                        Forms\Components\TextInput::make('data.jumlah_penduduk')
                            ->label('Total Penduduk')
                            ->numeric()
                            ->required()
                            ->placeholder('Contoh: 1500')
                            ->helperText('Total seluruh penduduk desa'),
                        Forms\Components\TextInput::make('data.laki_laki')
                            ->label('Laki-laki')
                            ->numeric()
                            ->required()
                            ->placeholder('Contoh: 750')
                            ->helperText('Jumlah penduduk laki-laki'),
                        Forms\Components\TextInput::make('data.perempuan')
                            ->label('Perempuan')
                            ->numeric()
                            ->required()
                            ->placeholder('Contoh: 750')
                            ->helperText('Jumlah penduduk perempuan'),
                        Forms\Components\TextInput::make('data.jumlah_kk')
                            ->label('Jumlah KK')
                            ->numeric()
                            ->required()
                            ->placeholder('Contoh: 350')
                            ->helperText('Jumlah Kepala Keluarga'),
                    ])
                    ->columns(2),
            ],
            'fasilitas' => [
                Forms\Components\Repeater::make('data.pendidikan')
                    ->label('Fasilitas Pendidikan')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Fasilitas')
                            ->required()
                            ->placeholder('Contoh: SD Negeri'),
                        Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric()
                            ->required()
                            ->default(1),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->defaultItems(0),
                Forms\Components\Repeater::make('data.kesehatan')
                    ->label('Fasilitas Kesehatan')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Fasilitas')
                            ->required()
                            ->placeholder('Contoh: Puskesmas'),
                        Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric()
                            ->required()
                            ->default(1),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->defaultItems(0),
                Forms\Components\Repeater::make('data.ibadah')
                    ->label('Fasilitas Ibadah')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Fasilitas')
                            ->required()
                            ->placeholder('Contoh: Masjid'),
                        Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric()
                            ->required()
                            ->default(1),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->defaultItems(0),
                Forms\Components\Repeater::make('data.ekonomi')
                    ->label('Fasilitas Ekonomi')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Fasilitas')
                            ->required()
                            ->placeholder('Contoh: Pasar Desa'),
                        Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric()
                            ->required()
                            ->default(1),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->defaultItems(0),
            ],
            'pemerintahan' => [
                Forms\Components\Section::make('Struktur Pemerintahan Desa')
                    ->description('Isi data struktur organisasi pemerintahan desa')
                    ->schema([
                        Forms\Components\Repeater::make('data.struktur')
                            ->label('Perangkat Desa')
                            ->schema([
                                Forms\Components\TextInput::make('jabatan')
                                    ->label('Jabatan')
                                    ->required()
                                    ->placeholder('Contoh: Kepala Desa'),
                                Forms\Components\TextInput::make('nama')
                                    ->label('Nama')
                                    ->required()
                                    ->placeholder('Contoh: Budi Santoso'),
                                Forms\Components\TextInput::make('nip')
                                    ->label('NIP (Opsional)')
                                    ->placeholder('Contoh: 198501012010011001'),
                                Forms\Components\Textarea::make('tugas')
                                    ->label('Tugas & Tanggung Jawab (Opsional)')
                                    ->rows(2)
                                    ->placeholder('Contoh: Memimpin penyelenggaraan pemerintahan desa'),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->minItems(1)
                            ->reorderable()
                            ->collapsible()
                            ->addActionLabel('Tambah Perangkat Desa'),
                    ]),
            ],
            'layanan' => [
                Forms\Components\Section::make('Layanan Publik Desa')
                    ->description('Daftar layanan yang tersedia untuk masyarakat')
                    ->schema([
                        Forms\Components\Repeater::make('data.layanan')
                            ->label('Daftar Layanan')
                            ->schema([
                                Forms\Components\TextInput::make('nama')
                                    ->label('Nama Layanan')
                                    ->required()
                                    ->placeholder('Contoh: Pembuatan KTP'),
                                Forms\Components\Textarea::make('deskripsi')
                                    ->label('Deskripsi')
                                    ->required()
                                    ->rows(2)
                                    ->placeholder('Contoh: Layanan pembuatan KTP baru atau perpanjangan'),
                                Forms\Components\Textarea::make('persyaratan')
                                    ->label('Persyaratan')
                                    ->rows(2)
                                    ->placeholder('Contoh: KK asli, Akta kelahiran, Pas foto 4x6'),
                                Forms\Components\TextInput::make('waktu_proses')
                                    ->label('Waktu Proses')
                                    ->placeholder('Contoh: 3 hari kerja'),
                                Forms\Components\TextInput::make('biaya')
                                    ->label('Biaya')
                                    ->placeholder('Contoh: Gratis'),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->minItems(1)
                            ->collapsible()
                            ->addActionLabel('Tambah Layanan'),
                    ]),
            ],
            default => [
                Forms\Components\Textarea::make('data')
                    ->label('Data (JSON)')
                    ->rows(15)
                    ->required()
                    ->helperText('Masukkan data dalam format JSON yang valid')
                    ->columnSpanFull(),
            ],
        };
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Jenis Informasi')
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'sejarah' => 'Sejarah',
                        'visi_misi' => 'Visi & Misi',
                        'geografi' => 'Geografi',
                        'demografi' => 'Demografi',
                        'fasilitas' => 'Fasilitas Umum',
                        'pemerintahan' => 'Pemerintahan',
                        'kontak' => 'Kontak',
                        'layanan' => 'Layanan Publik',
                        default => $state,
                    })
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('aktif')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('aktif')
                    ->label('Status Aktif')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('key', 'asc');
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
            'index' => Pages\ListDesaInfos::route('/'),
            'create' => Pages\CreateDesaInfo::route('/create'),
            'edit' => Pages\EditDesaInfo::route('/{record}/edit'),
        ];
    }
}
