<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InformasiPublikResource\Pages;
use App\Filament\Resources\InformasiPublikResource\RelationManagers;
use App\Models\InformasiPublik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InformasiPublikResource extends Resource
{
    protected static ?string $model = InformasiPublik::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationGroup = 'Sekretariat';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Informasi Publik';
    protected static ?string $pluralModelLabel = 'Informasi Publik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dokumen')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('kategori')
                            ->options([
                                'lppd' => 'LPPD (Laporan Penyelenggaraan Pemerintahan Desa)',
                                'apbdes' => 'APBDes',
                                'rpjmdes' => 'RPJMDes',
                                'rkpdes' => 'RKPDes',
                                'perdes' => 'Peraturan Desa',
                                'lainnya' => 'Lainnya',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('tahun')
                            ->numeric()
                            ->minValue(2000)
                            ->maxValue(2100),
                        Forms\Components\Textarea::make('deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
                
                Forms\Components\Section::make('File & URL')
                    ->schema([
                        Forms\Components\FileUpload::make('file_path')
                            ->label('File PDF')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('informasi-publik')
                            ->maxSize(20480),
                        Forms\Components\TextInput::make('url_eksternal')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://...'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\Toggle::make('aktif')
                            ->label('Tampilkan di Website')
                            ->default(true)
                            ->required(),
                        Forms\Components\TextInput::make('urutan')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Urutan tampil (semakin kecil semakin atas)'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->colors([
                        'primary' => 'lppd',
                        'success' => 'apbdes',
                        'warning' => 'rpjmdes',
                        'info' => 'rkpdes',
                        'gray' => 'lainnya',
                    ])
                    ->formatStateUsing(fn (string $state): string => strtoupper($state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\TextColumn::make('tahun')
                    ->sortable(),
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('urutan')
                    ->numeric()
                    ->sortable(),
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
                        'lppd' => 'LPPD',
                        'apbdes' => 'APBDes',
                        'rpjmdes' => 'RPJMDes',
                        'rkpdes' => 'RKPDes',
                        'perdes' => 'Peraturan Desa',
                        'lainnya' => 'Lainnya',
                    ]),
                Tables\Filters\SelectFilter::make('tahun')
                    ->options(fn () => collect(range(date('Y'), 2020))->mapWithKeys(fn ($y) => [$y => $y])),
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
            ->defaultSort('urutan');
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
            'index' => Pages\ListInformasiPubliks::route('/'),
            'create' => Pages\CreateInformasiPublik::route('/create'),
            'edit' => Pages\EditInformasiPublik::route('/{record}/edit'),
        ];
    }
}
