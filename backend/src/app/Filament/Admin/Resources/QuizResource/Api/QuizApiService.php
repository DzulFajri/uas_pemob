<?php

namespace App\Filament\Admin\Resources\QuizResource\Api;

use App\Filament\Admin\Resources\QuizResource;
use Rupadana\ApiService\ApiService;

class QuizApiService extends ApiService
{
    protected static ?string $resource = QuizResource::class; // Menggunakan QuizResource

    public static function handlers(): array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class,
        ];
    }
}
