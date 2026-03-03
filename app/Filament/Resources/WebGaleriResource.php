<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebGaleriResource\Pages;
use App\Filament\Resources\WebGaleriResource\RelationManagers;
use App\Models\WebGaleri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WebGaleriResource extends Resource
{
    protected static ?string $model = WebGaleri::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    
    protected static ?string $navigationLabel = 'Galeri';
    
    protected static ?string $navigationGroup = 'Web Publik';
    
    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        // Kepala Desa tidak perlu akses menu web publik
        return auth()->user()->tipe !== 'kepala_desa';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Galeri')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Select::make('tipe')
                            ->required()
                            ->options([
                                'foto' => 'Foto',
                                'video' => 'Video',
                            ])
                            ->default('foto')
                            ->live(),
                        
                        Forms\Components\Textarea::make('deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
                
                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('file_path')
                            ->label('File Foto')
                            ->image()
                            ->directory('galeri/foto')
                            ->maxSize(5120)
                            ->visible(fn ($get) => $get('tipe') === 'foto'),
                        
                        Forms\Components\TextInput::make('url_video')
                            ->label('URL Video (YouTube/Vimeo)')
                            ->url()
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->visible(fn ($get) => $get('tipe') === 'video'),
                        
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Thumbnail')
                            ->image()
                            ->directory('galeri/thumbnails')
                            ->maxSize(2048)
                            ->helperText('Opsional - untuk video akan auto-generate dari YouTube'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Detail Kegiatan')
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal_kegiatan')
                            ->label('Tanggal Kegiatan'),
                        
                        Forms\Components\TextInput::make('lokasi_kegiatan')
                            ->label('Lokasi Kegiatan')
                            ->maxLength(255),
                    ])->columns(2),
                
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
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Preview')
                    ->getStateUsing(fn ($record) => $record->thumbnail ?: $record->file_path)
                    ->defaultImageUrl(fn ($record) => $record->tipe === 'video' ? 'https://via.placeholder.com/200x150/D32F2F/ffffff?text=Video' : 'https://via.placeholder.com/200x150/1B5E20/ffffff?text=Foto')
                    ->height(60),
                
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->limit(40),
                
                Tables\Columns\BadgeColumn::make('tipe')
                    ->label('Tipe')
                    ->colors([
                        'success' => 'foto',
                        'danger' => 'video',
                    ]),
                
                Tables\Columns\TextColumn::make('tanggal_kegiatan')
                    ->label('Tgl Kegiatan')
                    ->date('d M Y')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('lokasi_kegiatan')
                    ->label('Lokasi')
                    ->limit(30)
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
                Tables\Filters\SelectFilter::make('tipe')
                    ->options([
                        'foto' => 'Foto',
                        'video' => 'Video',
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
            ->defaultSort('tanggal_kegiatan', 'desc')
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
            'index' => Pages\ListWebGaleris::route('/'),
            'create' => Pages\CreateWebGaleri::route('/create'),
            'edit' => Pages\EditWebGaleri::route('/{record}/edit'),
        ];
    }
}
