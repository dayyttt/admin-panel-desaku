<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebTeksBerjalanResource\Pages;
use App\Models\WebTeksBerjalan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WebTeksBerjalanResource extends Resource
{
    protected static ?string $model = WebTeksBerjalan::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    
    protected static ?string $navigationLabel = 'Teks Berjalan';
    
    protected static ?string $navigationGroup = 'Web Publik';
    
    protected static ?int $navigationSort = 7;

    public static function shouldRegisterNavigation(): bool
    {
        // Kepala Desa tidak perlu akses menu web publik
        return auth()->user()->tipe !== 'kepala_desa';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Konten Teks')
                    ->schema([
                        Forms\Components\Textarea::make('teks')
                            ->required()
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull()
                            ->helperText('Teks yang akan ditampilkan sebagai running text di website'),
                    ]),
                
                Forms\Components\Section::make('Tampilan')
                    ->schema([
                        Forms\Components\ColorPicker::make('warna_teks')
                            ->label('Warna Teks')
                            ->default('#ffffff'),
                        
                        Forms\Components\ColorPicker::make('warna_bg')
                            ->label('Warna Background')
                            ->default('#c0392b'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Jadwal Tayang')
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal_mulai')
                            ->label('Tanggal Mulai')
                            ->helperText('Kosongkan jika ingin langsung tayang'),
                        
                        Forms\Components\DatePicker::make('tanggal_selesai')
                            ->label('Tanggal Selesai')
                            ->helperText('Kosongkan jika tidak ada batas waktu'),
                    ])->columns(2)
                    ->collapsed(),
                
                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\Toggle::make('aktif')
                            ->label('Aktif')
                            ->default(true),
                        
                        Forms\Components\TextInput::make('urutan')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->helperText('Jika ada beberapa teks aktif, urutan menentukan prioritas'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('teks')
                    ->searchable()
                    ->limit(60)
                    ->weight('bold'),
                
                Tables\Columns\ColorColumn::make('warna_bg')
                    ->label('Warna'),
                
                Tables\Columns\TextColumn::make('tanggal_mulai')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('Sekarang'),
                
                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->label('Selesai')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('Tidak terbatas'),
                
                Tables\Columns\IconColumn::make('aktif')
                    ->label('Status')
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
                Tables\Filters\TernaryFilter::make('aktif')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif'),
                
                Tables\Filters\Filter::make('sedang_tayang')
                    ->label('Sedang Tayang')
                    ->query(fn ($query) => $query->aktif()),
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
            'index' => Pages\ListWebTeksBerjalans::route('/'),
            'create' => Pages\CreateWebTeksBerjalan::route('/create'),
            'edit' => Pages\EditWebTeksBerjalan::route('/{record}/edit'),
        ];
    }
}
