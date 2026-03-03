<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratPermohonanResource\Pages;
use App\Models\SuratPermohonan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class SuratPermohonanResource extends Resource
{
    protected static ?string $model = SuratPermohonan::class;
    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?string $navigationLabel = 'Permohonan Masuk';
    protected static ?string $navigationGroup = 'Persuratan';
    protected static ?int $navigationSort = 4;
    protected static ?string $modelLabel = 'Permohonan Surat';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Data Permohonan')->schema([
                Forms\Components\Select::make('surat_jenis_id')
                    ->relationship('suratJenis', 'nama')
                    ->searchable()->preload()->required()->label('Jenis Surat'),
                Forms\Components\TextInput::make('nik')->required()->maxLength(16)->label('NIK'),
                Forms\Components\TextInput::make('nama')->required(),
                Forms\Components\Textarea::make('keperluan')->required()->rows(2),
            ])->columns(2),

            Forms\Components\Section::make('Status Proses')->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'menunggu' => '⏳ Menunggu',
                        'diproses' => '🔄 Diproses',
                        'selesai' => '✅ Selesai',
                        'ditolak' => '❌ Ditolak',
                    ])->default('menunggu')->required(),
                Forms\Components\Textarea::make('catatan_operator')->rows(2)->label('Catatan'),
                Forms\Components\Textarea::make('alasan_tolak')->rows(2)
                    ->visible(fn (Forms\Get $get) => $get('status') === 'ditolak'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->dateTime('d/m/Y H:i')->label('Tanggal')->sortable(),
                Tables\Columns\TextColumn::make('suratJenis.singkatan')->badge()->color('info')->label('Jenis'),
                Tables\Columns\TextColumn::make('nama')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('nik')->searchable()->label('NIK'),
                Tables\Columns\TextColumn::make('keperluan')->limit(30),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn (string $state) => match ($state) {
                        'menunggu' => 'warning',
                        'diproses' => 'info',
                        'selesai' => 'success',
                        'ditolak' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'menunggu' => '⏳ Menunggu',
                        'diproses' => '🔄 Diproses',
                        'selesai' => '✅ Selesai',
                        'ditolak' => '❌ Ditolak',
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('proses')
                    ->label('Proses')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn (SuratPermohonan $record) => $record->status === 'menunggu')
                    ->action(function (SuratPermohonan $record) {
                        $record->update([
                            'status' => 'diproses',
                            'diproses_oleh' => Auth::id(),
                            'diproses_at' => now(),
                        ]);
                        Notification::make()->success()->title('Permohonan sedang diproses')->send();
                    }),
                Tables\Actions\Action::make('tolak')
                    ->label('Tolak')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->visible(fn (SuratPermohonan $record) => in_array($record->status, ['menunggu', 'diproses']))
                    ->form([
                        Forms\Components\Textarea::make('alasan_tolak')->required()->label('Alasan Penolakan'),
                    ])
                    ->action(function (SuratPermohonan $record, array $data) {
                        $record->update([
                            'status' => 'ditolak',
                            'alasan_tolak' => $data['alasan_tolak'],
                            'diproses_oleh' => Auth::id(),
                            'diproses_at' => now(),
                        ]);
                        Notification::make()->warning()->title('Permohonan ditolak')->send();
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'menunggu' => 'Menunggu', 'diproses' => 'Diproses',
                        'selesai' => 'Selesai', 'ditolak' => 'Ditolak',
                    ]),
                Tables\Filters\SelectFilter::make('surat_jenis_id')
                    ->relationship('suratJenis', 'nama')->label('Jenis Surat'),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuratPermohonans::route('/'),
            'create' => Pages\CreateSuratPermohonan::route('/create'),
            'edit' => Pages\EditSuratPermohonan::route('/{record}/edit'),
        ];
    }
}
