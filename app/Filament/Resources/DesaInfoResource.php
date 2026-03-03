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
    
    protected static ?string $navigationLabel = 'Informasi Desa';
    
    protected static ?string $modelLabel = 'Informasi Desa';
    
    protected static ?string $pluralModelLabel = 'Informasi Desa';
    
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
                                'profil' => 'Profil Desa',
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
                            ->afterStateUpdated(fn ($state, callable $set) => $set('data', null))
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('aktif')
                            ->label('Status Aktif')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Data Konten')
                    ->schema(fn ($get) => self::getDataSchemaForKey($get('key')))
                    ->visible(fn ($get) => $get('key') !== null),
            ]);
    }
    
    protected static function getDataSchemaForKey(?string $key): array
    {
        return match($key) {
            'profil' => [
                Forms\Components\TextInput::make('data.nama')
                    ->label('Nama Desa')
                    ->required(),
                Forms\Components\TextInput::make('data.kecamatan')
                    ->label('Kecamatan')
                    ->required(),
                Forms\Components\TextInput::make('data.kabupaten')
                    ->label('Kabupaten')
                    ->required(),
                Forms\Components\TextInput::make('data.provinsi')
                    ->label('Provinsi')
                    ->required(),
                Forms\Components\TextInput::make('data.kode_pos')
                    ->label('Kode Pos')
                    ->required(),
                Forms\Components\TextInput::make('data.luas_wilayah')
                    ->label('Luas Wilayah (km²)')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('data.ketinggian')
                    ->label('Ketinggian (mdpl)')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('data.jumlah_penduduk')
                    ->label('Jumlah Penduduk')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('data.jumlah_kk')
                    ->label('Jumlah KK')
                    ->numeric()
                    ->required(),
                Forms\Components\Textarea::make('data.sambutan')
                    ->label('Sambutan Kepala Desa')
                    ->rows(5)
                    ->required()
                    ->columnSpanFull(),
            ],
            'kontak' => [
                Forms\Components\Textarea::make('data.alamat')
                    ->label('Alamat Lengkap')
                    ->rows(2)
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('data.telepon')
                    ->label('Telepon')
                    ->tel()
                    ->required(),
                Forms\Components\TextInput::make('data.email')
                    ->label('Email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('data.website')
                    ->label('Website')
                    ->url()
                    ->required(),
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
                            ->prefix('@'),
                        Forms\Components\TextInput::make('data.media_sosial.instagram')
                            ->label('Instagram')
                            ->prefix('@'),
                        Forms\Components\TextInput::make('data.media_sosial.youtube')
                            ->label('YouTube'),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ],
            'visi_misi' => [
                Forms\Components\Textarea::make('data.visi')
                    ->label('Visi')
                    ->rows(3)
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('data.misi')
                    ->label('Misi')
                    ->simple(
                        Forms\Components\Textarea::make('item')
                            ->label('Poin Misi')
                            ->rows(2)
                            ->required()
                    )
                    ->required()
                    ->columnSpanFull(),
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
                        'profil' => 'Profil Desa',
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
