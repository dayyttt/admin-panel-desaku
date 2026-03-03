<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LapakResource\Pages;
use App\Models\Lapak;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LapakResource extends Resource
{
    protected static ?string $model = Lapak::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    
    protected static ?string $navigationLabel = 'Lapak UMKM';
    
    protected static ?string $navigationGroup = 'Web Publik';
    
    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(): bool
    {
        // Kepala Desa tidak perlu akses menu web publik
        return auth()->user()->tipe !== 'kepala_desa';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Usaha')
                    ->schema([
                        Forms\Components\TextInput::make('nama_usaha')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                        
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        
                        Forms\Components\Select::make('kategori')
                            ->required()
                            ->options([
                                'kuliner' => 'Kuliner',
                                'kerajinan' => 'Kerajinan',
                                'pertanian' => 'Pertanian',
                                'perikanan' => 'Perikanan',
                                'jasa' => 'Jasa',
                                'fashion' => 'Fashion',
                                'lainnya' => 'Lainnya',
                            ]),
                        
                        Forms\Components\Textarea::make('deskripsi')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])->columns(2),
                
                Forms\Components\Section::make('Data Pemilik')
                    ->schema([
                        Forms\Components\Select::make('penduduk_id')
                            ->label('Penduduk (Opsional)')
                            ->relationship('penduduk', 'nama')
                            ->searchable()
                            ->preload(),
                        
                        Forms\Components\TextInput::make('nama_pemilik')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('nik_pemilik')
                            ->label('NIK Pemilik')
                            ->maxLength(16)
                            ->numeric(),
                        
                        Forms\Components\Textarea::make('alamat')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(2),
                
                Forms\Components\Section::make('Kontak')
                    ->schema([
                        Forms\Components\TextInput::make('telepon')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('whatsapp')
                            ->tel()
                            ->maxLength(255)
                            ->prefix('+62'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('foto_usaha')
                            ->label('Foto Utama')
                            ->image()
                            ->directory('lapak/utama')
                            ->maxSize(3072),
                        
                        Forms\Components\FileUpload::make('foto_lainnya')
                            ->label('Foto Lainnya')
                            ->image()
                            ->multiple()
                            ->directory('lapak/galeri')
                            ->maxSize(3072)
                            ->maxFiles(5),
                    ])->columns(2),
                
                Forms\Components\Section::make('Lokasi (Opsional)')
                    ->schema([
                        Forms\Components\TextInput::make('latitude')
                            ->numeric()
                            ->step(0.0000001)
                            ->placeholder('-3.xxxxx'),
                        
                        Forms\Components\TextInput::make('longitude')
                            ->numeric()
                            ->step(0.0000001)
                            ->placeholder('128.xxxxx'),
                    ])->columns(2)
                    ->collapsed(),
                
                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\Toggle::make('publish')
                            ->label('Publikasikan')
                            ->default(false),
                        
                        Forms\Components\Toggle::make('aktif')
                            ->label('Aktif')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto_usaha')
                    ->label('Foto')
                    ->circular(),
                
                Tables\Columns\TextColumn::make('nama_usaha')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                
                Tables\Columns\BadgeColumn::make('kategori')
                    ->colors([
                        'success' => 'kuliner',
                        'warning' => 'kerajinan',
                        'primary' => 'pertanian',
                        'info' => 'perikanan',
                        'danger' => 'jasa',
                    ]),
                
                Tables\Columns\TextColumn::make('nama_pemilik')
                    ->label('Pemilik')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('telepon')
                    ->label('Kontak')
                    ->icon('heroicon-o-phone')
                    ->toggleable(),
                
                Tables\Columns\IconColumn::make('publish')
                    ->label('Publish')
                    ->boolean(),
                
                Tables\Columns\IconColumn::make('aktif')
                    ->label('Aktif')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'kuliner' => 'Kuliner',
                        'kerajinan' => 'Kerajinan',
                        'pertanian' => 'Pertanian',
                        'perikanan' => 'Perikanan',
                        'jasa' => 'Jasa',
                        'fashion' => 'Fashion',
                        'lainnya' => 'Lainnya',
                    ]),
                
                Tables\Filters\TernaryFilter::make('publish')
                    ->label('Status Publikasi')
                    ->placeholder('Semua')
                    ->trueLabel('Dipublikasikan')
                    ->falseLabel('Draft'),
                
                Tables\Filters\TernaryFilter::make('aktif')
                    ->label('Status Aktif')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif'),
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
            'index' => Pages\ListLapaks::route('/'),
            'create' => Pages\CreateLapak::route('/create'),
            'edit' => Pages\EditLapak::route('/{record}/edit'),
        ];
    }
}
