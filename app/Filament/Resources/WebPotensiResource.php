<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebPotensiResource\Pages;
use App\Models\WebPotensi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WebPotensiResource extends Resource
{
    protected static ?string $model = WebPotensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    
    protected static ?string $navigationLabel = 'Potensi Desa';
    
    protected static ?string $navigationGroup = 'Web Publik';
    
    protected static ?int $navigationSort = 5;

    public static function shouldRegisterNavigation(): bool
    {
        // Kepala Desa tidak perlu akses menu web publik
        return auth()->user()->tipe !== 'kepala_desa';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Potensi')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        
                        Forms\Components\Select::make('kategori')
                            ->required()
                            ->options([
                                'wisata' => 'Wisata',
                                'pertanian' => 'Pertanian',
                                'perikanan' => 'Perikanan',
                                'umkm' => 'UMKM',
                                'budaya' => 'Budaya',
                                'kerajinan' => 'Kerajinan',
                                'kuliner' => 'Kuliner',
                                'lainnya' => 'Lainnya',
                            ]),
                        
                        Forms\Components\RichEditor::make('deskripsi')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                            ]),
                    ])->columns(2),
                
                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('foto')
                            ->label('Foto Potensi')
                            ->image()
                            ->multiple()
                            ->directory('potensi')
                            ->maxSize(3072)
                            ->maxFiles(5)
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\Section::make('Kontak & Lokasi')
                    ->schema([
                        Forms\Components\TextInput::make('kontak')
                            ->label('Kontak (Telepon/WA)')
                            ->tel()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('latitude')
                            ->numeric()
                            ->step(0.0000001)
                            ->placeholder('-3.xxxxx'),
                        
                        Forms\Components\TextInput::make('longitude')
                            ->numeric()
                            ->step(0.0000001)
                            ->placeholder('128.xxxxx'),
                    ])->columns(3),
                
                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\Toggle::make('publish')
                            ->label('Publikasikan')
                            ->default(true),
                        
                        Forms\Components\TextInput::make('urutan')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular()
                    ->stacked()
                    ->limit(3),
                
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->weight('bold'),
                
                Tables\Columns\BadgeColumn::make('kategori')
                    ->colors([
                        'success' => 'wisata',
                        'warning' => 'pertanian',
                        'info' => 'perikanan',
                        'primary' => 'umkm',
                        'danger' => 'budaya',
                    ]),
                
                Tables\Columns\TextColumn::make('kontak')
                    ->label('Kontak')
                    ->icon('heroicon-o-phone')
                    ->toggleable(),
                
                Tables\Columns\IconColumn::make('publish')
                    ->label('Publish')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('urutan')
                    ->label('Urutan')
                    ->sortable()
                    ->badge(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'wisata' => 'Wisata',
                        'pertanian' => 'Pertanian',
                        'perikanan' => 'Perikanan',
                        'umkm' => 'UMKM',
                        'budaya' => 'Budaya',
                        'kerajinan' => 'Kerajinan',
                        'kuliner' => 'Kuliner',
                        'lainnya' => 'Lainnya',
                    ]),
                
                Tables\Filters\TernaryFilter::make('publish')
                    ->label('Status Publikasi')
                    ->placeholder('Semua')
                    ->trueLabel('Dipublikasikan')
                    ->falseLabel('Draft'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('urutan', 'asc')
            ->reorderable('urutan');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWebPotensis::route('/'),
            'create' => Pages\CreateWebPotensi::route('/create'),
            'edit' => Pages\EditWebPotensi::route('/{record}/edit'),
        ];
    }
}
