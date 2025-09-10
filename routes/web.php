<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TeacherController;

// Public quiz start page
Route::get('/', [QuizController::class, 'startForm'])->name('quiz.start');
Route::post('/quiz/start', [QuizController::class, 'start'])->name('quiz.start.post');

// Quiz playing (public access)
Route::get('/quiz/{test}', [QuizController::class, 'play'])->name('quiz.play');
Route::post('/quiz/{test}/submit', [QuizController::class, 'submit'])->name('quiz.submit');

// Quiz results (public access)
Route::get('/quiz/{test}/results', [QuizController::class, 'showResults'])->name('quiz.results');

// Student's own quiz history
Route::get('/my-results', function() {
    return view('quiz.my-results-form');
})->name('quiz.my-results.form');
Route::post('/my-results', [QuizController::class, 'myResults'])->name('quiz.my-results');

// Dashboard - redirect based on role
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->isTeacher()) {
        return redirect()->route('teacher.dashboard');
    }
    // Students go to quiz start page
    return redirect()->route('quiz.start');
})->middleware(['auth', 'verified'])->name('dashboard');

// Teacher routes - protected
Route::middleware(['auth', 'verified'])->group(function () {
    // Teacher dashboard
    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])
        ->middleware('can:teacher')
        ->name('teacher.dashboard');
        
    // Question management
    Route::resource('questions', QuestionController::class)
        ->middleware('can:teacher');
        
    // Question import
    Route::get('/questions-import', [QuestionController::class, 'importForm'])
        ->middleware('can:teacher')
        ->name('questions.import');
    Route::post('/questions-import', [QuestionController::class, 'import'])
        ->middleware('can:teacher')
        ->name('questions.import.store');
        
    // Results viewing
    Route::get('/teacher/results', [TeacherController::class, 'index'])
        ->middleware('can:teacher')
        ->name('teacher.results');
    Route::get('/teacher/results/{test}', [TeacherController::class, 'show'])
        ->name('teacher.results.show'); // Both teachers and students can view results
});

// Results page (accessible by both students and teachers)
Route::get('/results/{test}', [QuizController::class, 'showResults'])->name('results.show');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
