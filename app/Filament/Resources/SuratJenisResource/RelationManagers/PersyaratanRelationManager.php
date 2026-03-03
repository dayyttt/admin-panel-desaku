<?php

namespace App\Filament\Resources\SuratJenisResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PersyaratanRelationManager extends RelationManager
{
    protected static string $relationship = 'persyaratan';
    protected static ?string $title = 'Persyaratan Surat';
    protected static ?string $modelLabel = 'Persyaratan';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama_syarat')->required()->label('Nama Syarat'),
            Forms\Components\Textarea::make('keterangan')->rows(2),
            Forms\Components\Toggle::make('wajib')->default(true),
            Forms\Components\TextInput::make('urutan')->numeric()->default(0),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_syarat')->weight('bold'),
                Tables\Columns\IconColumn::make('wajib')->boolean(),
                Tables\Columns\TextColumn::make('keterangan')->limit(50),
            ])
            ->reorderable('urutan')
            ->defaultSort('urutan');
    }
}
