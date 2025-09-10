<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    // Startformulier: naam, e-mail, aantal vragen
    public function startForm()
    {
        $questionCount = Question::count();
        return view('quiz.start', compact('questionCount'));
    }

    // Maak (of vind) student user + test + selecteer vragen
    public function start(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'count' => 'required|integer|min:1'
        ]);

        $user = User::firstOrCreate(
            ['email' => $data['email']],
            ['name' => $data['name'], 'password' => Str::password(12), 'role' => 'student']
        );

        $questions = Question::inRandomOrder()->limit($data['count'])->get();

        if ($questions->isEmpty()) {
            return back()->withErrors(['count' => 'Er zijn nog geen vragen beschikbaar. Importeer eerst vragen.']);
        }

        $test = Test::create([
            'user_id' => $user->id,
            'score' => null,
        ]);

        foreach ($questions as $q) {
            Answer::create([
                'test_id' => $test->id,
                'question_id' => $q->id,
                'student_answer' => null,
                'is_correct' => null,
            ]);
        }

        // Start bij eerste vraag
        session(['current_question' => 0]);

        return redirect()->route('quiz.play', $test);
    }

    // Toon quiz vraag-voor-vraag
    public function play(Test $test)
    {
        $answers = $test->answers()->with('question')->get();

        if ($answers->isEmpty()) {
            abort(404, 'Geen vragen beschikbaar voor deze test.');
        }

        // Als al nagekeken is, ga naar resultaten
        if (!is_null($test->score)) {
            return redirect()->route('teacher.results.show', $test->id);
        }

        // Huidige vraag index uit session
        $current = session('current_question', 0);
        $total = $answers->count();

        // Zorg dat index binnen range is
        if ($current >= $total) {
            session()->forget('current_question');
            return redirect()->route('teacher.results.show', $test->id);
        }

        $question = $answers[$current];

        return view('quiz.play', compact('test', 'answers', 'question', 'current', 'total'));
    }

    // Ontvang antwoord en ga naar volgende vraag
    public function submit(Request $request, Test $test)
    {
        $answers = $test->answers()->with('question')->get();
        $current = session('current_question', 0);

        if ($current >= $answers->count()) {
            session()->forget('current_question');
            return redirect()->route('teacher.results.show', $test->id);
        }

        $answer = $answers[$current];
        $question = $answer->question;

        // Antwoord van gebruiker
        $payload = $request->validate([
            'answer' => 'required|string'
        ]);

        $studentValue = trim($payload['answer']);
        $isCorrect = false;

        if ($question->type === 'multiple_choice') {
            $isCorrect = strcasecmp($studentValue, $question->answer) === 0;
        } else {
            $isCorrect = strcasecmp($studentValue, trim($question->answer)) === 0;
        }

        $answer->update([
            'student_answer' => $studentValue,
            'is_correct' => $isCorrect
        ]);

        // Volgende vraag index opslaan
        $current++;
        if ($current >= $answers->count()) {
            // Bereken score
            $score = $answers->where('is_correct', true)->count();
            $test->update(['score' => $score]);
            session()->forget('current_question');

            return redirect()->route('teacher.results.show', $test->id)
                             ->with('success', 'Quiz voltooid! Je antwoorden zijn opgeslagen.');
        }

        session(['current_question' => $current]);

        return redirect()->route('quiz.play', $test);
    }
}
