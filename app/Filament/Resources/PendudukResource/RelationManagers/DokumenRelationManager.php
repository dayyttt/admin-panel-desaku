<?php

namespace App\Filament\Resources\PendudukResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class DokumenRelationManager extends RelationManager
{
    protected static string $relationship = 'dokumen';
    protected static ?string $title = 'Dokumen Penduduk';
    protected static ?string $modelLabel = 'Dokumen';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('jenis_dokumen')
                ->options([
                    'ktp' => 'KTP', 'kk' => 'Kartu Keluarga',
                    'akta_lahir' => 'Akta Lahir', 'akta_nikah' => 'Akta Nikah',
                    'ijazah' => 'Ijazah', 'bpjs' => 'BPJS',
                    'paspor' => 'Paspor', 'lainnya' => 'Lainnya',
                ])->required(),
            Forms\Components\TextInput::make('nama_dokumen')->required(),
            Forms\Components\TextInput::make('nomor_dokumen'),
            Forms\Components\DatePicker::make('tanggal_dokumen'),
            Forms\Components\DatePicker::make('masa_berlaku'),
            Forms\Components\FileUpload::make('file_path')
                ->required()->directory('dokumen-penduduk')
                ->label('File Scan'),
            Forms\Components\Textarea::make('keterangan')->rows(2),
            Forms\Components\Hidden::make('diupload_oleh')->default(fn () => Auth::id()),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jenis_dokumen')->badge()
                    ->formatStateUsing(fn (string $state) => strtoupper(str_replace('_', ' ', $state))),
                Tables\Columns\TextColumn::make('nama_dokumen')->weight('bold'),
                Tables\Columns\TextColumn::make('nomor_dokumen'),
                Tables\Columns\TextColumn::make('masa_berlaku')->date('d/m/Y'),
                Tables\Columns\TextColumn::make('created_at')->date('d/m/Y')->label('Diupload'),
            ]);
    }
}
