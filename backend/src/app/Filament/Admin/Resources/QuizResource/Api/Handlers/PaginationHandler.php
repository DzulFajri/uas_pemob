<?php

namespace App\Filament\Admin\Resources\QuizResource\Api\Handlers;

use App\Filament\Admin\Resources\QuizResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class PaginationHandler extends Handlers
{
    public static ?string $uri = '/'; // Sesuaikan URI sesuai kebutuhan

    public static ?string $resource = QuizResource::class;

    public function handler()
    {
        $query = static::getEloquentQuery();
        $model = static::getModel();

        $query = QueryBuilder::for($query)
            ->allowedFields($this->getAllowedFields() ?? [])
            ->allowedSorts($this->getAllowedSorts() ?? [])
            ->allowedFilters($this->getAllowedFilters() ?? [])
            ->allowedIncludes($this->getAllowedIncludes() ?? [])
            ->paginate(request()->query('per_page', 10)) // Default 10 per page
            ->appends(request()->query());

        return static::getApiTransformer()::collection($query);
    }
}
