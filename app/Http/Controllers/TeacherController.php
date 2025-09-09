<?php

namespace App\Http\Controllers;

use App\Models\Test;

class TeacherController extends Controller
{
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
