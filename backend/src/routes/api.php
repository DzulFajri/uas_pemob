<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Import Handlers untuk Quiz
use App\Filament\Admin\Resources\QuizResource\Api\Handlers\{
    CreateHandler as QuizCreateHandler,
    DeleteHandler as QuizDeleteHandler,
    DetailHandler as QuizDetailHandler,
    PaginationHandler as QuizPaginationHandler,
    UpdateHandler as QuizUpdateHandler
};

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', function () {
    return Product::all();
});

// API untuk Quizzes
Route::prefix('quizzes')->group(function () {
    Route::post('/quizzes', [QuizCreateHandler::class, 'handler'])->name('api.quizzes.create');
    Route::get('/quizzes', [QuizPaginationHandler::class, 'handler'])->name('api.quizzes.paginate');
    Route::get('/quizzes/{id}', [QuizDetailHandler::class, 'handler'])->name('api.quizzes.detail');
    Route::put('/quizzes/{id}', [QuizUpdateHandler::class, 'handler'])->name('api.quizzes.update');
    Route::delete('/quizzes/{id}', [QuizDeleteHandler::class, 'handler'])->name('api.quizzes.delete');
});
