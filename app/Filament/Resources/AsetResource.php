<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsetResource\Pages;
use App\Filament\Resources\AsetResource\RelationManagers;
use App\Models\Aset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AsetResource extends Resource
{
    protected static ?string $model = Aset::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Aset & Inventaris';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Aset Desa';
    protected static ?string $pluralModelLabel = 'Aset Desa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Aset')
                    ->schema([
                        Forms\Components\Select::make('kategori_id')
                            ->relationship('kategori', 'nama')
                            ->required()
                            ->native(false)
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nama')->required(),
                                Forms\Components\TextInput::make('kode')->required(),
                            ]),
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('kode_inventaris')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Kode unik aset'),
                        Forms\Components\TextInput::make('tahun_perolehan')
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(date('Y')),
                        Forms\Components\Select::make('cara_perolehan')
                            ->options([
                                'beli' => 'Pembelian',
                                'hibah' => 'Hibah',
                                'dana_desa' => 'Dana Desa',
                                'swadaya' => 'Swadaya Masyarakat',
                                'lainnya' => 'Lainnya',
                            ])
                            ->native(false),
                    ])->columns(3),
                
                Forms\Components\Section::make('Nilai & Kondisi')
                    ->schema([
                        Forms\Components\TextInput::make('nilai_perolehan')
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('0'),
                        Forms\Components\Select::make('kondisi')
                            ->options([
                                'baik' => 'Baik',
                                'rusak_ringan' => 'Rusak Ringan',
                                'rusak_berat' => 'Rusak Berat',
                                'hilang' => 'Hilang',
                            ])
                            ->default('baik')
                            ->required()
                            ->native(false),
                        Forms\Components\Toggle::make('aktif')
                            ->label('Status Aktif')
                            ->default(true)
                            ->required(),
                    ])->columns(3),
                
                Forms\Components\Section::make('Lokasi & Ukuran')
                    ->schema([
                        Forms\Components\Textarea::make('lokasi')
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('luas')
                            ->numeric()
                            ->suffix('m²')
                            ->placeholder('Untuk tanah/bangunan'),
                        Forms\Components\TextInput::make('volume')
                            ->numeric(),
                        Forms\Components\TextInput::make('satuan')
                            ->maxLength(255)
                            ->placeholder('unit, buah, dll'),
                    ])->columns(3),
                
                Forms\Components\Section::make('Foto & Keterangan')
                    ->schema([
                        Forms\Components\FileUpload::make('foto')
                            ->image()
                            ->directory('aset')
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
                Tables\Columns\TextColumn::make('kategori.nama')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->limit(40)
                    ->wrap(),
                Tables\Columns\TextColumn::make('kode_inventaris')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('tahun_perolehan')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('nilai_perolehan')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('kondisi')
                    ->badge()
                    ->colors([
                        'success' => 'baik',
                        'warning' => 'rusak_ringan',
                        'danger' => 'rusak_berat',
                        'gray' => 'hilang',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'baik' => 'Baik',
                        'rusak_ringan' => 'Rusak Ringan',
                        'rusak_berat' => 'Rusak Berat',
                        'hilang' => 'Hilang',
                        default => $state,
                    }),
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori_id')
                    ->relationship('kategori', 'nama')
                    ->label('Kategori'),
                Tables\Filters\SelectFilter::make('kondisi')
                    ->options([
                        'baik' => 'Baik',
                        'rusak_ringan' => 'Rusak Ringan',
                        'rusak_berat' => 'Rusak Berat',
                        'hilang' => 'Hilang',
                    ]),
                Tables\Filters\TernaryFilter::make('aktif')
                    ->label('Status Aktif'),
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
            'index' => Pages\ListAsets::route('/'),
            'create' => Pages\CreateAset::route('/create'),
            'edit' => Pages\EditAset::route('/{record}/edit'),
        ];
    }
}
