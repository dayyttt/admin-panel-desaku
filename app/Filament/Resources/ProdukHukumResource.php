<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukHukumResource\Pages;
use App\Filament\Resources\ProdukHukumResource\RelationManagers;
use App\Models\ProdukHukum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProdukHukumResource extends Resource
{
    protected static ?string $model = ProdukHukum::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Sekretariat';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Produk Hukum';
    protected static ?string $pluralModelLabel = 'Produk Hukum';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Produk Hukum')
                    ->schema([
                        Forms\Components\Select::make('jenis')
                            ->options([
                                'perdes' => 'Peraturan Desa',
                                'perkades' => 'Peraturan Kepala Desa',
                                'sk' => 'Surat Keputusan',
                                'keputusan_bpd' => 'Keputusan BPD',
                                'lainnya' => 'Lainnya',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('nomor')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: 01/PERDES/2026'),
                        Forms\Components\TextInput::make('tahun')
                            ->required()
                            ->numeric()
                            ->default(date('Y'))
                            ->minValue(2000)
                            ->maxValue(2100),
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Judul produk hukum'),
                        Forms\Components\Textarea::make('tentang')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Tentang apa produk hukum ini'),
                    ])->columns(3),
                
                Forms\Components\Section::make('Tanggal & Status')
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal_ditetapkan')
                            ->native(false),
                        Forms\Components\DatePicker::make('tanggal_berlaku')
                            ->native(false),
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'aktif' => 'Aktif',
                                'dicabut' => 'Dicabut',
                            ])
                            ->default('aktif')
                            ->required()
                            ->native(false),
                        Forms\Components\Toggle::make('tampil_publik')
                            ->label('Tampilkan di Website')
                            ->default(true)
                            ->required(),
                    ])->columns(4),
                
                Forms\Components\Section::make('File & Keterangan')
                    ->schema([
                        Forms\Components\FileUpload::make('file_path')
                            ->label('File PDF')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('produk-hukum')
                            ->maxSize(10240),
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
                Tables\Columns\TextColumn::make('jenis')
                    ->badge()
                    ->colors([
                        'primary' => 'perdes',
                        'success' => 'perkades',
                        'warning' => 'sk',
                        'info' => 'keputusan_bpd',
                        'gray' => 'lainnya',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'perdes' => 'Perdes',
                        'perkades' => 'Perkades',
                        'sk' => 'SK',
                        'keputusan_bpd' => 'Keputusan BPD',
                        default => 'Lainnya',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\TextColumn::make('tanggal_ditetapkan')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'aktif',
                        'danger' => 'dicabut',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\IconColumn::make('tampil_publik')
                    ->label('Publik')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis')
                    ->options([
                        'perdes' => 'Peraturan Desa',
                        'perkades' => 'Peraturan Kepala Desa',
                        'sk' => 'Surat Keputusan',
                        'keputusan_bpd' => 'Keputusan BPD',
                        'lainnya' => 'Lainnya',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'aktif' => 'Aktif',
                        'dicabut' => 'Dicabut',
                    ]),
                Tables\Filters\SelectFilter::make('tahun')
                    ->options(fn () => collect(range(date('Y'), 2020))->mapWithKeys(fn ($y) => [$y => $y])),
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
            ->defaultSort('tanggal_ditetapkan', 'desc');
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
            'index' => Pages\ListProdukHukums::route('/'),
            'create' => Pages\CreateProdukHukum::route('/create'),
            'edit' => Pages\EditProdukHukum::route('/{record}/edit'),
        ];
    }
}
