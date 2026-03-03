<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebSliderResource\Pages;
use App\Filament\Resources\WebSliderResource\RelationManagers;
use App\Models\WebSlider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WebSliderResource extends Resource
{
    protected static ?string $model = WebSlider::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    
    protected static ?string $navigationLabel = 'Slider Hero';
    
    protected static ?string $navigationGroup = 'Web Publik';
    
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Konten Slider')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->maxLength(255)
                            ->placeholder('Judul slider (opsional)'),
                        
                        Forms\Components\Textarea::make('subjudul')
                            ->rows(2)
                            ->placeholder('Subjudul atau deskripsi singkat'),
                        
                        Forms\Components\FileUpload::make('foto_path')
                            ->label('Foto Banner')
                            ->image()
                            ->required()
                            ->directory('slider')
                            ->maxSize(5120)
                            ->imageEditor()
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\Section::make('Call to Action')
                    ->schema([
                        Forms\Components\TextInput::make('label_tombol')
                            ->label('Label Tombol')
                            ->maxLength(255)
                            ->placeholder('Contoh: Selengkapnya, Lihat Detail'),
                        
                        Forms\Components\TextInput::make('url_aksi')
                            ->label('URL Tujuan')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://...'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\Toggle::make('aktif')
                            ->label('Aktif')
                            ->default(true),
                        
                        Forms\Components\TextInput::make('urutan')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->helperText('Semakin kecil angka, semakin awal ditampilkan'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto_path')
                    ->label('Banner')
                    ->height(60),
                
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->limit(40),
                
                Tables\Columns\TextColumn::make('label_tombol')
                    ->label('Tombol')
                    ->badge()
                    ->color('primary'),
                
                Tables\Columns\IconColumn::make('aktif')
                    ->label('Status')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('urutan')
                    ->label('Urutan')
                    ->numeric()
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWebSliders::route('/'),
            'create' => Pages\CreateWebSlider::route('/create'),
            'edit' => Pages\EditWebSlider::route('/{record}/edit'),
        ];
    }
}
