<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArsipDesaResource\Pages;
use App\Filament\Resources\ArsipDesaResource\RelationManagers;
use App\Models\ArsipDesa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArsipDesaResource extends Resource
{
    protected static ?string $model = ArsipDesa::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Sekretariat';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Arsip Desa';
    protected static ?string $pluralModelLabel = 'Arsip Desa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Arsip')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('kode_arsip')
                            ->maxLength(255)
                            ->placeholder('Kode klasifikasi arsip'),
                        Forms\Components\Select::make('kategori')
                            ->options([
                                'surat_masuk' => 'Surat Masuk',
                                'surat_keluar' => 'Surat Keluar',
                                'sk' => 'Surat Keputusan',
                                'perdes' => 'Peraturan Desa',
                                'laporan' => 'Laporan',
                                'lainnya' => 'Lainnya',
                            ])
                            ->native(false),
                        Forms\Components\TextInput::make('tahun')
                            ->numeric()
                            ->default(date('Y'))
                            ->minValue(1900)
                            ->maxValue(2100),
                        Forms\Components\Textarea::make('deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(3),
                
                Forms\Components\Section::make('File & Lokasi Fisik')
                    ->schema([
                        Forms\Components\FileUpload::make('file_path')
                            ->label('File Digital')
                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                            ->directory('arsip-desa')
                            ->maxSize(10240)
                            ->required(),
                        Forms\Components\TextInput::make('lokasi_fisik')
                            ->maxLength(255)
                            ->placeholder('Contoh: Rak A, Lemari 2'),
                        Forms\Components\TextInput::make('jumlah_halaman')
                            ->numeric()
                            ->minValue(1),
                        Forms\Components\Select::make('kondisi')
                            ->options([
                                'baik' => 'Baik',
                                'rusak_ringan' => 'Rusak Ringan',
                                'rusak_berat' => 'Rusak Berat',
                            ])
                            ->default('baik')
                            ->required()
                            ->native(false),
                    ])->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_arsip')
                    ->badge()
                    ->color('gray')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->colors([
                        'primary' => 'surat_masuk',
                        'success' => 'surat_keluar',
                        'warning' => 'sk',
                        'info' => 'perdes',
                        'gray' => 'lainnya',
                    ])
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('lokasi_fisik')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('kondisi')
                    ->badge()
                    ->colors([
                        'success' => 'baik',
                        'warning' => 'rusak_ringan',
                        'danger' => 'rusak_berat',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'baik' => 'Baik',
                        'rusak_ringan' => 'Rusak Ringan',
                        'rusak_berat' => 'Rusak Berat',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('uploader.name')
                    ->label('Diupload Oleh')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'surat_masuk' => 'Surat Masuk',
                        'surat_keluar' => 'Surat Keluar',
                        'sk' => 'Surat Keputusan',
                        'perdes' => 'Peraturan Desa',
                        'laporan' => 'Laporan',
                        'lainnya' => 'Lainnya',
                    ]),
                Tables\Filters\SelectFilter::make('tahun')
                    ->options(fn () => collect(range(date('Y'), 2000))->mapWithKeys(fn ($y) => [$y => $y])),
                Tables\Filters\SelectFilter::make('kondisi')
                    ->options([
                        'baik' => 'Baik',
                        'rusak_ringan' => 'Rusak Ringan',
                        'rusak_berat' => 'Rusak Berat',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListArsipDesas::route('/'),
            'create' => Pages\CreateArsipDesa::route('/create'),
            'edit' => Pages\EditArsipDesa::route('/{record}/edit'),
        ];
    }
}
