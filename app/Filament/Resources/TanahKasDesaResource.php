<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TanahKasDesaResource\Pages;
use App\Filament\Resources\TanahKasDesaResource\RelationManagers;
use App\Models\TanahKasDesa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TanahKasDesaResource extends Resource
{
    protected static ?string $model = TanahKasDesa::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'Aset & Inventaris';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Tanah Kas Desa';
    protected static ?string $pluralModelLabel = 'Tanah Kas Desa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Tanah')
                    ->schema([
                        Forms\Components\TextInput::make('nama_bidang')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('nomor_persil')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('kelas_tanah')
                            ->maxLength(255)
                            ->placeholder('Contoh: S1, S2, S3'),
                        Forms\Components\TextInput::make('luas')
                            ->numeric()
                            ->suffix('m²')
                            ->required(),
                    ])->columns(3),
                
                Forms\Components\Section::make('Lokasi')
                    ->schema([
                        Forms\Components\Textarea::make('lokasi')
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('latitude')
                            ->numeric()
                            ->placeholder('-3.xxxxxx'),
                        Forms\Components\TextInput::make('longitude')
                            ->numeric()
                            ->placeholder('128.xxxxxx'),
                        Forms\Components\Select::make('penggunaan_tanah')
                            ->options([
                                'sawah' => 'Sawah',
                                'kebun' => 'Kebun',
                                'bangunan' => 'Bangunan',
                                'lapangan' => 'Lapangan',
                                'hutan' => 'Hutan',
                                'lainnya' => 'Lainnya',
                            ])
                            ->native(false),
                    ])->columns(3),
                
                Forms\Components\Section::make('Status & Sertifikat')
                    ->schema([
                        Forms\Components\Select::make('status_tanah')
                            ->options([
                                'milik_desa' => 'Milik Desa',
                                'sewa' => 'Sewa',
                                'pinjam_pakai' => 'Pinjam Pakai',
                                'sengketa' => 'Sengketa',
                            ])
                            ->default('milik_desa')
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('nomor_sertifikat')
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('tanggal_sertifikat')
                            ->native(false),
                        Forms\Components\TextInput::make('nilai_tanah')
                            ->numeric()
                            ->prefix('Rp'),
                    ])->columns(4),
                
                Forms\Components\Section::make('Foto & Keterangan')
                    ->schema([
                        Forms\Components\FileUpload::make('foto')
                            ->image()
                            ->directory('tanah-kas-desa')
                            ->maxSize(2048),
                        Forms\Components\Textarea::make('keterangan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_bidang')
                    ->searchable()
                    ->limit(40)
                    ->wrap(),
                Tables\Columns\TextColumn::make('nomor_persil')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('luas')
                    ->numeric(decimalPlaces: 0)
                    ->suffix(' m²')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_tanah')
                    ->badge()
                    ->colors([
                        'success' => 'milik_desa',
                        'warning' => 'sewa',
                        'info' => 'pinjam_pakai',
                        'danger' => 'sengketa',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'milik_desa' => 'Milik Desa',
                        'sewa' => 'Sewa',
                        'pinjam_pakai' => 'Pinjam Pakai',
                        'sengketa' => 'Sengketa',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('penggunaan_tanah')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('nilai_tanah')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('nomor_sertifikat')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_tanah')
                    ->options([
                        'milik_desa' => 'Milik Desa',
                        'sewa' => 'Sewa',
                        'pinjam_pakai' => 'Pinjam Pakai',
                        'sengketa' => 'Sengketa',
                    ]),
                Tables\Filters\SelectFilter::make('penggunaan_tanah')
                    ->options([
                        'sawah' => 'Sawah',
                        'kebun' => 'Kebun',
                        'bangunan' => 'Bangunan',
                        'lapangan' => 'Lapangan',
                        'hutan' => 'Hutan',
                        'lainnya' => 'Lainnya',
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
            ->defaultSort('nama_bidang');
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
            'index' => Pages\ListTanahKasDesas::route('/'),
            'create' => Pages\CreateTanahKasDesa::route('/create'),
            'edit' => Pages\EditTanahKasDesa::route('/{record}/edit'),
        ];
    }
}
