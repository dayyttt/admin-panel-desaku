<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BantuanProgramResource\Pages;
use App\Filament\Resources\BantuanProgramResource\RelationManagers;
use App\Models\BantuanProgram;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BantuanProgramResource extends Resource
{
    protected static ?string $model = BantuanProgram::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $navigationGroup = 'Bantuan Sosial';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Program Bantuan';
    protected static ?string $pluralModelLabel = 'Program Bantuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Program')->schema([
                    Forms\Components\TextInput::make('nama')
                        ->required()
                        ->maxLength(255)
                        ->label('Nama Program')
                        ->placeholder('Contoh: Program Keluarga Harapan (PKH)'),
                    Forms\Components\TextInput::make('singkatan')
                        ->maxLength(255)
                        ->label('Singkatan')
                        ->placeholder('Contoh: PKH'),
                    Forms\Components\Textarea::make('deskripsi')
                        ->rows(3)
                        ->label('Deskripsi Program'),
                ])->columns(2),

                Forms\Components\Section::make('Sumber & Penyelenggara')->schema([
                    Forms\Components\Select::make('sumber_dana')
                        ->options([
                            'APBN' => 'APBN',
                            'APBD Provinsi' => 'APBD Provinsi',
                            'APBD Kabupaten' => 'APBD Kabupaten',
                            'APBDes' => 'APBDes',
                            'Swasta' => 'Swasta',
                            'Lainnya' => 'Lainnya',
                        ])
                        ->label('Sumber Dana'),
                    Forms\Components\TextInput::make('penyelenggara')
                        ->maxLength(255)
                        ->label('Penyelenggara')
                        ->placeholder('Contoh: Kemensos, Pemkab, dll'),
                ])->columns(2),

                Forms\Components\Section::make('Jenis & Nominal')->schema([
                    Forms\Components\Select::make('jenis_bantuan')
                        ->required()
                        ->options([
                            'uang_tunai' => 'Uang Tunai',
                            'sembako' => 'Sembako',
                            'layanan' => 'Layanan',
                            'barang' => 'Barang',
                            'lainnya' => 'Lainnya',
                        ])
                        ->label('Jenis Bantuan'),
                    Forms\Components\TextInput::make('nominal_per_penerima')
                        ->numeric()
                        ->prefix('Rp')
                        ->label('Nominal per Penerima'),
                    Forms\Components\TextInput::make('satuan_nominal')
                        ->maxLength(255)
                        ->label('Satuan Nominal')
                        ->placeholder('Contoh: per bulan, per tahap, per tahun'),
                    Forms\Components\Toggle::make('aktif')
                        ->required()
                        ->default(true)
                        ->label('Program Aktif'),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->weight('bold')
                    ->label('Nama Program'),
                Tables\Columns\TextColumn::make('singkatan')
                    ->searchable()
                    ->badge()
                    ->color('info')
                    ->label('Singkatan'),
                Tables\Columns\TextColumn::make('jenis_bantuan')
                    ->badge()
                    ->colors([
                        'success' => 'uang_tunai',
                        'warning' => 'sembako',
                        'info' => 'layanan',
                        'primary' => 'barang',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'uang_tunai' => 'Uang Tunai',
                        'sembako' => 'Sembako',
                        'layanan' => 'Layanan',
                        'barang' => 'Barang',
                        default => 'Lainnya',
                    })
                    ->label('Jenis'),
                Tables\Columns\TextColumn::make('nominal_per_penerima')
                    ->money('IDR')
                    ->sortable()
                    ->label('Nominal'),
                Tables\Columns\TextColumn::make('penerima_count')
                    ->counts('penerima')
                    ->label('Penerima')
                    ->badge()
                    ->color('success'),
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean()
                    ->label('Aktif'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_bantuan')
                    ->options([
                        'uang_tunai' => 'Uang Tunai',
                        'sembako' => 'Sembako',
                        'layanan' => 'Layanan',
                        'barang' => 'Barang',
                        'lainnya' => 'Lainnya',
                    ])
                    ->label('Jenis Bantuan'),
                Tables\Filters\TernaryFilter::make('aktif')
                    ->label('Status Program'),
            ])
            ->actions([
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
            'index' => Pages\ListBantuanPrograms::route('/'),
            'create' => Pages\CreateBantuanProgram::route('/create'),
            'edit' => Pages\EditBantuanProgram::route('/{record}/edit'),
        ];
    }
}
