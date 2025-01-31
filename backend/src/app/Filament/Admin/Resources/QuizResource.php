<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\QuizResource\Pages;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuizResource extends Resource
{
    // Model yang digunakan
    protected static ?string $model = Quiz::class;

    // Ikon untuk resource ini
    protected static ?string $navigationIcon = 'heroicon-o-folder';

    // Label untuk navigasi
    protected static ?string $navigationLabel = 'Quizzes';

    // Grup navigasi
    protected static ?string $navigationGroup = 'Education';

    // Judul untuk setiap record
    protected static ?string $recordTitleAttribute = 'title';

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
            Forms\Components\TextInput::make('title')
                ->required()
                ->label('Quiz Title'),
            Forms\Components\Select::make('type')
                ->options([
                    'numbers' => 'Numbers',
                    'letters' => 'Letters',
                    'animals' => 'Animals',
                    'fruits' => 'Fruits',
                ])
                ->required()
                ->label('Quiz Type'),
            Forms\Components\TextInput::make('question')
                ->required()
                ->label('Question'),
            Forms\Components\FileUpload::make('image')
                ->label('Image (optional)')
                ->nullable(),
            Forms\Components\TextInput::make('option_one')
                ->required()
                ->label('Option One'),
            Forms\Components\TextInput::make('option_two')
                ->required()
                ->label('Option Two'),
            Forms\Components\TextInput::make('correct_answer')
                ->required()
                ->label('Correct Answer'),
        ]);
    }

    // Schema tabel
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('title')
                ->sortable()
                ->searchable()
                ->label('Quiz Title'),
            Tables\Columns\TextColumn::make('type')
                ->sortable()
                ->label('Quiz Type'),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Created At')
                ->date()
                ->sortable(),
            Tables\Columns\ImageColumn::make('image') // Menambahkan kolom untuk gambar
                ->label('Image')
                ->sortable()
                ->url(fn ($record) => $record->image ? asset('storage/' . $record->image) : null), // Menampilkan URL gambar
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
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
        ];
    }
}
