<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TeacherController extends Controller
{
    use AuthorizesRequests;
    // Teacher dashboard with statistics
    public function dashboard()
    {
        $totalQuestions = Question::count();
        $totalTests = Test::count();
        $totalStudents = User::where('role', 'student')->count();
        $recentTests = Test::with('user')->latest()->take(5)->get();
        
        // Calculate average score
        $averageScore = Test::whereNotNull('score')->avg('score');
        $averagePercentage = $totalTests > 0 && $averageScore ? round(($averageScore / $totalQuestions) * 100, 1) : 0;
        
        return view('teacher.dashboard', compact(
            'totalQuestions', 'totalTests', 'totalStudents', 
            'recentTests', 'averageScore', 'averagePercentage'
        ));
    }
    
    // Overzicht alle tests
    public function index()
    {
        $tests = Test::with('user')->latest()->paginate(20);
        return view('teacher.index', compact('tests'));
    }

    // Detailpagina met alle antwoorden + welke fout/goed
    public function show(Test $test)
    {
        $test->load(['user', 'answers.question']);
        $total = $test->answers()->count();
        return view('teacher.show', compact('test', 'total'));
    }
}
