<?php

namespace App\Filament\Admin\Resources\QuizResource\Api\Handlers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CheckAnswerHandler
{
    public function __invoke(Request $request, $quiz_id): JsonResponse
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'selected_answer' => 'required|string'
        ]);

        $question = Question::find($request->question_id);
        $isCorrect = $question->correct_answer === $request->selected_answer;

        return response()->json([
            'correct' => $isCorrect
        ]);
    }
}
