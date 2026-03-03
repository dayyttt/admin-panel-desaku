<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WebKontakResource\Pages;
use App\Filament\Resources\WebKontakResource\RelationManagers;
use App\Models\WebKontak;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WebKontakResource extends Resource
{
    protected static ?string $model = WebKontak::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    
    protected static ?string $navigationLabel = 'Pesan Masuk';
    
    protected static ?string $modelLabel = 'Pesan Masuk';
    
    protected static ?string $pluralModelLabel = 'Pesan Masuk';
    
    protected static ?string $navigationGroup = 'Web Publik';
    
    protected static ?int $navigationSort = 8;
    
    protected static ?string $navigationBadgeTooltip = 'Pesan baru dari website';

    public static function shouldRegisterNavigation(): bool
    {
        // Kepala Desa tidak perlu akses menu web publik
        return auth()->user()->tipe !== 'kepala_desa';
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'baru')->count() ?: null;
    }
    
    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::where('status', 'baru')->count() > 0 ? 'warning' : null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pengirim')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->disabled(),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->disabled(),
                        Forms\Components\TextInput::make('subjek')
                            ->label('Subjek')
                            ->required()
                            ->maxLength(255)
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('pesan')
                            ->label('Pesan')
                            ->required()
                            ->rows(5)
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Status & Tindak Lanjut')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'baru' => 'Baru',
                                'dibaca' => 'Sudah Dibaca',
                                'dibalas' => 'Sudah Dibalas',
                                'selesai' => 'Selesai',
                            ])
                            ->required()
                            ->default('baru')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $record) {
                                if ($state === 'dibaca' && $record && !$record->dibaca_pada) {
                                    $set('dibaca_pada', now());
                                }
                            }),
                        Forms\Components\DateTimePicker::make('dibaca_pada')
                            ->label('Dibaca Pada')
                            ->disabled(),
                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan Internal')
                            ->rows(3)
                            ->helperText('Catatan untuk internal admin, tidak dikirim ke pengirim')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),
                Tables\Columns\TextColumn::make('subjek')
                    ->label('Subjek')
                    ->searchable()
                    ->limit(40)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 40) {
                            return null;
                        }
                        return $state;
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'baru' => 'warning',
                        'dibaca' => 'info',
                        'dibalas' => 'success',
                        'selesai' => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'baru' => 'Baru',
                        'dibaca' => 'Dibaca',
                        'dibalas' => 'Dibalas',
                        'selesai' => 'Selesai',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diterima')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('dibaca_pada')
                    ->label('Dibaca')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'baru' => 'Baru',
                        'dibaca' => 'Sudah Dibaca',
                        'dibalas' => 'Sudah Dibalas',
                        'selesai' => 'Selesai',
                    ])
                    ->default('baru'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('markAsRead')
                    ->label('Tandai Dibaca')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->visible(fn (WebKontak $record): bool => $record->status === 'baru')
                    ->action(function (WebKontak $record) {
                        $record->update([
                            'status' => 'dibaca',
                            'dibaca_pada' => now(),
                        ]);
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Tandai sebagai Dibaca')
                    ->modalDescription('Apakah Anda yakin ingin menandai pesan ini sebagai sudah dibaca?'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('markAsRead')
                        ->label('Tandai Dibaca')
                        ->icon('heroicon-o-eye')
                        ->color('info')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update([
                                    'status' => 'dibaca',
                                    'dibaca_pada' => now(),
                                ]);
                            });
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s'); // Auto refresh every 30 seconds
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
            'index' => Pages\ListWebKontaks::route('/'),
            'create' => Pages\CreateWebKontak::route('/create'),
            'edit' => Pages\EditWebKontak::route('/{record}/edit'),
        ];
    }
}
