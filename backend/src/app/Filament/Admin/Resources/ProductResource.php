<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    // Model yang digunakan
    protected static ?string $model = Product::class;

    // Ikon untuk resource ini
    protected static ?string $navigationIcon = 'heroicon-o-folder';  // Ikon untuk grup 'Inventory'

    // Grup navigasi
    protected static ?string $navigationGroup = 'Inventory';

    // Judul untuk setiap record
    protected static ?string $recordTitleAttribute = 'name';

    // Urutan navigasi
    protected static ?int $navigationSort = 1;

    // Badge navigasi untuk menghitung total data
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    // Schema form
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->minLength(2)
                    ->maxLength(255)
                    ->label('Product Name'),
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->columnSpan('full'),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->label('Price'),
            ]),
        ]);
    }

    // Schema tabel
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('name')
                ->sortable()
                ->searchable()
                ->label('Product Name'),
            Tables\Columns\TextColumn::make('description') // Menambahkan kolom deskripsi
                ->sortable()
                ->label('Description'),
            Tables\Columns\TextColumn::make('price')
                ->sortable()
                ->label('Price')
                ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Created At')
                ->date()
                ->sortable(),
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
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    // Relasi (kosong jika tidak ada)
    public static function getRelations(): array
    {
        return [];
    }

    // Halaman yang digunakan
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
