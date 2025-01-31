<?php

namespace App\Filament\Admin\Resources\QuizResource\Api\Handlers;

use App\Filament\Admin\Resources\QuizResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Admin\Resources\QuizResource\Api\Requests\CreateQuizRequest; // Update this line with the correct namespace


class CreateHandler extends Handlers
{
    public static ?string $uri = '/'; // Sesuaikan URI sesuai kebutuhan

    public static ?string $resource = QuizResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel()
    {
        return static::$resource::getModel();
    }

    public function handler(Request $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}
