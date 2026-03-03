<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebArtikelResource\Pages;
use App\Filament\Resources\WebArtikelResource\RelationManagers;
use App\Models\WebArtikel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WebArtikelResource extends Resource
{
    protected static ?string $model = WebArtikel::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    
    protected static ?string $navigationLabel = 'Artikel & Berita';
    
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
                Forms\Components\Section::make('Informasi Artikel')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
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
                                'berita' => 'Berita',
                                'pengumuman' => 'Pengumuman',
                                'artikel' => 'Artikel',
                                'agenda' => 'Agenda',
                            ])
                            ->default('berita'),
                        
                        Forms\Components\Textarea::make('ringkasan')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ])->columns(2),
                
                Forms\Components\Section::make('Konten')
                    ->schema([
                        Forms\Components\RichEditor::make('konten')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'heading',
                                'bulletList',
                                'orderedList',
                                'blockquote',
                                'codeBlock',
                            ]),
                    ]),
                
                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                            ->image()
                            ->directory('artikel/thumbnails')
                            ->maxSize(2048),
                        
                        Forms\Components\FileUpload::make('gambar_galeri')
                            ->image()
                            ->multiple()
                            ->directory('artikel/galeri')
                            ->maxSize(2048)
                            ->maxFiles(5),
                    ])->columns(2),
                
                Forms\Components\Section::make('Publikasi')
                    ->schema([
                        Forms\Components\Toggle::make('publish')
                            ->label('Publikasikan')
                            ->default(false),
                        
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->default(now()),
                        
                        Forms\Components\TextInput::make('view_count')
                            ->label('Jumlah Dilihat')
                            ->numeric()
                            ->default(0)
                            ->disabled(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Gambar')
                    ->circular(),
                
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                
                Tables\Columns\BadgeColumn::make('kategori')
                    ->colors([
                        'primary' => 'berita',
                        'warning' => 'pengumuman',
                        'success' => 'artikel',
                        'info' => 'agenda',
                    ]),
                
                Tables\Columns\IconColumn::make('publish')
                    ->label('Publish')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tgl Publikasi')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('view_count')
                    ->label('Views')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('success'),
                
                Tables\Columns\TextColumn::make('penulis.name')
                    ->label('Penulis')
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'berita' => 'Berita',
                        'pengumuman' => 'Pengumuman',
                        'artikel' => 'Artikel',
                        'agenda' => 'Agenda',
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
            'index' => Pages\ListWebArtikels::route('/'),
            'create' => Pages\CreateWebArtikel::route('/create'),
            'edit' => Pages\EditWebArtikel::route('/{record}/edit'),
        ];
    }
}
