<?php

namespace App\Filament\Resources\ApbdesResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class BidangRelationManager extends RelationManager
{
    protected static string $relationship = 'bidang';
    protected static ?string $title = 'Bidang / Sub-Bidang / Kegiatan';
    protected static ?string $modelLabel = 'Bidang';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('level')
                ->options([
                    'bidang' => '📂 Bidang',
                    'sub_bidang' => '📁 Sub Bidang',
                    'kegiatan' => '📋 Kegiatan',
                ])->required(),
            Forms\Components\Select::make('parent_id')
                ->label('Parent')
                ->options(fn ($livewire) => \App\Models\ApbdesBidang::where('apbdes_id', $livewire->ownerRecord->id)
                    ->whereIn('level', ['bidang', 'sub_bidang'])
                    ->pluck('nama', 'id'))
                ->searchable(),
            Forms\Components\TextInput::make('kode')->required()->placeholder('1.1'),
            Forms\Components\TextInput::make('nama')->required()->placeholder('Bidang Penyelenggaraan Pemerintahan'),
            Forms\Components\Select::make('jenis')
                ->options([
                    'pendapatan' => '💰 Pendapatan',
                    'belanja' => '💸 Belanja',
                    'pembiayaan' => '🏦 Pembiayaan',
                ])->default('belanja'),
            Forms\Components\TextInput::make('anggaran')->numeric()->prefix('Rp')->default(0),
            Forms\Components\TextInput::make('realisasi')->numeric()->prefix('Rp')->default(0),
            Forms\Components\Textarea::make('keterangan')->rows(2),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('nama')->weight('bold')->searchable(),
                Tables\Columns\TextColumn::make('level')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'bidang' => 'info', 'sub_bidang' => 'warning', 'kegiatan' => 'success',
                    }),
                Tables\Columns\TextColumn::make('jenis')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'pendapatan' => 'success', 'belanja' => 'danger', 'pembiayaan' => 'info',
                    }),
                Tables\Columns\TextColumn::make('anggaran')->money('IDR'),
                Tables\Columns\TextColumn::make('realisasi')->money('IDR'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('level')
                    ->options(['bidang' => 'Bidang', 'sub_bidang' => 'Sub Bidang', 'kegiatan' => 'Kegiatan']),
                Tables\Filters\SelectFilter::make('jenis')
                    ->options(['pendapatan' => 'Pendapatan', 'belanja' => 'Belanja', 'pembiayaan' => 'Pembiayaan']),
            ])
            ->reorderable('urutan')
            ->defaultSort('urutan');
    }
}
