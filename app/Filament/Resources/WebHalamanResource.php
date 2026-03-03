<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebHalamanResource\Pages;
use App\Models\WebHalaman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WebHalamanResource extends Resource
{
    protected static ?string $model = WebHalaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'Halaman Statis';
    
    protected static ?string $navigationGroup = 'Web Publik';
    
    protected static ?int $navigationSort = 6;

    public static function shouldRegisterNavigation(): bool
    {
        // Kepala Desa tidak perlu akses menu web publik
        return auth()->user()->tipe !== 'kepala_desa';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Halaman')
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
                        
                        Forms\Components\TextInput::make('ikon')
                            ->label('Ikon (Heroicon)')
                            ->maxLength(255)
                            ->placeholder('heroicon-o-home')
                            ->helperText('Contoh: heroicon-o-home, heroicon-o-information-circle'),
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
                
                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\Toggle::make('publish')
                            ->label('Publikasikan')
                            ->default(true),
                        
                        Forms\Components\Toggle::make('tampil_menu')
                            ->label('Tampilkan di Menu')
                            ->default(false)
                            ->helperText('Jika aktif, halaman akan muncul di menu navigasi'),
                        
                        Forms\Components\TextInput::make('urutan')
                            ->label('Urutan di Menu')
                            ->numeric()
                            ->default(0)
                            ->helperText('Urutan tampil di menu (semakin kecil semakin awal)'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->copyable()
                    ->color('gray'),
                
                Tables\Columns\TextColumn::make('ikon')
                    ->label('Ikon')
                    ->badge()
                    ->color('primary')
                    ->toggleable(),
                
                Tables\Columns\IconColumn::make('publish')
                    ->label('Publish')
                    ->boolean(),
                
                Tables\Columns\IconColumn::make('tampil_menu')
                    ->label('Di Menu')
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
                Tables\Filters\TernaryFilter::make('publish')
                    ->label('Status Publikasi')
                    ->placeholder('Semua')
                    ->trueLabel('Dipublikasikan')
                    ->falseLabel('Draft'),
                
                Tables\Filters\TernaryFilter::make('tampil_menu')
                    ->label('Tampil di Menu')
                    ->placeholder('Semua')
                    ->trueLabel('Ya')
                    ->falseLabel('Tidak'),
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
            'index' => Pages\ListWebHalamen::route('/'),
            'create' => Pages\CreateWebHalaman::route('/create'),
            'edit' => Pages\EditWebHalaman::route('/{record}/edit'),
        ];
    }
}
