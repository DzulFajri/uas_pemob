<?php

namespace App\Filament\Admin\Resources\QuizResource\Api\Handlers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GetQuestionsHandler
{
    public function __invoke(Request $request, $quiz_id): JsonResponse
    {
        $questions = Question::where('quiz_id', $quiz_id)->get();

        return response()->json($questions);
    }
}
