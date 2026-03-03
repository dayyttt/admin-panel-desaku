<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Manajemen User';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'User';

    public static function shouldRegisterNavigation(): bool
    {
        // Hanya superadmin yang bisa melihat menu ini
        return auth()->user()->tipe === 'superadmin';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Akun')->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(255)->label('Nama Lengkap'),
                Forms\Components\TextInput::make('username')->required()->unique(ignoreRecord: true)->maxLength(50),
                Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('nik')->maxLength(16)->label('NIK'),
                Forms\Components\TextInput::make('telepon'),
                Forms\Components\Select::make('tipe')->options([
                    'superadmin' => 'Super Admin',
                    'operator' => 'Operator Desa',
                    'kepala_desa' => 'Kepala Desa',
                    'warga' => 'Warga',
                ])->required()->label('Tipe User'),
                Forms\Components\Toggle::make('aktif')->default(true),
            ])->columns(2),

            Forms\Components\Section::make('Password')->schema([
                Forms\Components\TextInput::make('password')
                    ->password()->revealable()
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pin')
                    ->password()->revealable()
                    ->maxLength(6)->label('PIN (6 digit)')
                    ->helperText('PIN untuk login warga dari mobile app'),
            ])->columns(2),

            Forms\Components\Section::make('Foto')->schema([
                Forms\Components\FileUpload::make('foto')->image()->directory('users'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')->circular()->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&background=1B5E20&color=fff'),
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->weight('bold')->sortable(),
                Tables\Columns\TextColumn::make('username')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('tipe')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'superadmin' => 'danger',
                        'operator' => 'info',
                        'kepala_desa' => 'success',
                        'warga' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('aktif')->boolean(),
                Tables\Columns\TextColumn::make('last_login_at')->label('Login Terakhir')->dateTime('d/m/Y H:i')->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tipe')->options([
                    'superadmin' => 'Super Admin',
                    'operator' => 'Operator',
                    'kepala_desa' => 'Kepala Desa',
                    'warga' => 'Warga',
                ]),
                Tables\Filters\TernaryFilter::make('aktif')->label('Status Aktif'),
            ])
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
