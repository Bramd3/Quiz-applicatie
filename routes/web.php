<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ResultController;

// ===========================
// Publieke routes (geen login vereist)
// ===========================

// Startpagina quiz
Route::get('/', [QuizController::class, 'startForm'])->name('quiz.start');
Route::post('/quiz/start', [QuizController::class, 'start'])->name('quiz.start.post');

// Quiz spelen
Route::get('/quiz/{test}', [QuizController::class, 'play'])->name('quiz.play');
Route::post('/quiz/{test}/submit', [QuizController::class, 'submit'])->name('quiz.submit');

// Resultaten van een specifieke test
Route::get('/quiz/{test}/results', [QuizController::class, 'showResults'])->name('quiz.results');

// ===========================
// Student routes (inloggen vereist)
// ===========================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/my-results', [ResultController::class, 'myResults'])->name('results.my');

    Route::get('/dashboard', function () {
        if (auth()->check() && auth()->user()->isTeacher()) {
            return redirect()->route('teacher.dashboard');
        }
        return redirect()->route('quiz.start');
    })->name('dashboard');
});

// ===========================
// Teacher routes (alleen docenten)
// ===========================
Route::middleware(['auth', 'verified', 'can:teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');

    Route::resource('questions', QuestionController::class);

    Route::get('/questions-import', [QuestionController::class, 'importForm'])->name('questions.import');
    Route::post('/questions-import', [QuestionController::class, 'import'])->name('questions.import.store');

    Route::get('/teacher/results', [TeacherController::class, 'index'])->name('teacher.results');
    Route::get('/teacher/results/{test}', [TeacherController::class, 'show'])->name('teacher.results.show');
});

// ===========================
// Profielbeheer
// ===========================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
