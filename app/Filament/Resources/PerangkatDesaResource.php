<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerangkatDesaResource\Pages;
use App\Models\PerangkatDesa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PerangkatDesaResource extends Resource
{
    protected static ?string $model = PerangkatDesa::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Perangkat Desa';
    protected static ?string $navigationGroup = 'Info Desa';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Perangkat Desa';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Pribadi')->schema([
                Forms\Components\TextInput::make('nama')->required()->maxLength(255),
                Forms\Components\TextInput::make('nik')->maxLength(16)->label('NIK'),
                Forms\Components\TextInput::make('nip')->maxLength(255)->label('NIP'),
                Forms\Components\TextInput::make('jabatan')->required(),
                Forms\Components\TextInput::make('telepon'),
                Forms\Components\TextInput::make('email')->email(),
                Forms\Components\Textarea::make('alamat')->rows(2),
                Forms\Components\FileUpload::make('foto')->image()->directory('perangkat')->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Periode & Status')->schema([
                Forms\Components\DatePicker::make('periode_mulai'),
                Forms\Components\DatePicker::make('periode_selesai'),
                Forms\Components\Toggle::make('aktif')->default(true),
                Forms\Components\Toggle::make('tampil_web')->default(true)->label('Tampil di Web'),
                Forms\Components\TextInput::make('urutan')->numeric()->default(0),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('urutan')->label('#')->sortable(),
                Tables\Columns\ImageColumn::make('foto')->circular()->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=P&background=1B5E20&color=fff'),
                Tables\Columns\TextColumn::make('nama')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('jabatan')->searchable(),
                Tables\Columns\TextColumn::make('telepon'),
                Tables\Columns\IconColumn::make('aktif')->boolean(),
                Tables\Columns\IconColumn::make('tampil_web')->boolean()->label('Web'),
            ])
            ->defaultSort('urutan')
            ->reorderable('urutan');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPerangkatDesas::route('/'),
            'create' => Pages\CreatePerangkatDesa::route('/create'),
            'edit' => Pages\EditPerangkatDesa::route('/{record}/edit'),
        ];
    }
}
