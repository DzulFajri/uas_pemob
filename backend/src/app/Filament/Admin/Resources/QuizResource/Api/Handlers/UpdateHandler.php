<?php

namespace App\Filament\Admin\Resources\QuizResource\Api\Handlers;

use App\Filament\Admin\Resources\QuizResource;
use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;

class UpdateHandler extends Handlers
{
    public static ?string $uri = '/{id}'; // Sesuaikan URI sesuai kebutuhan

    public static ?string $resource = QuizResource::class;

    public static function getMethod()
    {
        return Handlers::PUT; // Menggunakan metode PUT untuk pembaruan
    }

    public static function getModel()
    {
        return static::$resource::getModel(); // Mengembalikan model yang digunakan
    }

    public function handler(Request $request)
    {
        $id = $request->route('id'); // Mengambil ID dari rute

        $quiz = static::getModel()::with('questions')->find($id); // Mencari model berdasarkan ID

        if (!$quiz) {
            return static::sendNotFoundResponse(); // Mengembalikan respons jika model tidak ditemukan
        }

        // Validasi data yang diterima
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:numbers,letters,animals',
            'question' => 'required|string',
            'image' => 'nullable|image',
            'option_one' => 'required|string',
            'option_two' => 'required|string',
            'correct_answer' => 'required|string',
        ]);

        // Mengupdate data kuis
        $quiz->fill($validatedData);
        $quiz->save(); // Menyimpan perubahan

        // Mengupdate pertanyaan terkait
        if ($quiz->questions->isNotEmpty()) {
            $question = $quiz->questions->first(); // Mengambil pertanyaan pertama
            $question->fill($validatedData); // Mengisi pertanyaan dengan data yang divalidasi
            if ($request->hasFile('image')) {
                $question->image = $request->file('image')->store('images'); // Menyimpan gambar jika ada
            }
            $question->save(); // Menyimpan perubahan pertanyaan
        }

        return static::sendSuccessResponse($quiz, 'Successfully Updated Resource'); // Mengembalikan respons sukses
    }
}
