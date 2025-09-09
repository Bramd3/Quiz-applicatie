<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TeacherController;



Route::get('/', [QuizController::class, 'startForm'])->name('quiz.start');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/questions/import', function () {
    return view('questions.import');
})->name('questions.import');

Route::post('/questions/import', [QuestionController::class, 'import'])
    ->name('questions.import.store');


Route::post('/quiz/start', [QuizController::class, 'start'])->name('quiz.start.post');
Route::get('/quiz/{test}', [QuizController::class, 'play'])->name('quiz.play');
Route::post('/quiz/{test}/submit', [QuizController::class, 'submit'])->name('quiz.submit');


Route::get('/teacher/results', [TeacherController::class, 'index'])->name('teacher.results');
Route::get('/teacher/results/{test}', [TeacherController::class, 'show'])->name('teacher.results.show');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
