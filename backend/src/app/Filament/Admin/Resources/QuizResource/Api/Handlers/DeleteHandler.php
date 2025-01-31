<?php

namespace App\Filament\Admin\Resources\QuizResource\Api\Handlers;

use App\Filament\Admin\Resources\QuizResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;

class DeleteHandler extends Handlers
{
    public static ?string $uri = '/{id}'; // Sesuaikan URI sesuai kebutuhan

    public static ?string $resource = QuizResource::class;

    public static function getMethod()
    {
        return Handlers::DELETE;
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }

    public function handler(Request $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) {
            return static::sendNotFoundResponse();
        }

        $model->delete();

        return static::sendSuccessResponse(null, 'Successfully Deleted Resource');
    }
}
