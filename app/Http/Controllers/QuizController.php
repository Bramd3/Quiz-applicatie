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

        // Create Answer records for tracking
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
            return redirect()->route('results.show', $test->id);
        }

        // Huidige vraag index uit session
        $current = session('current_question', 0);
        $total = $answers->count();

        // Zorg dat index binnen range is
        if ($current >= $total) {
            session()->forget('current_question');
            return redirect()->route('results.show', $test->id);
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
            return redirect()->route('results.show', $test->id);
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

            return redirect()->route('results.show', $test->id)
                             ->with('success', 'Quiz voltooid! Je antwoorden zijn opgeslagen.');
        }

        session(['current_question' => $current]);

        return redirect()->route('quiz.play', $test);
    }

    // Show quiz results (accessible by anyone with the link)
    public function showResults(Test $test)
    {
        // Make sure the test has been completed
        if (is_null($test->score)) {
            return redirect()->route('quiz.play', $test)
                ->with('error', 'Deze quiz is nog niet voltooid.');
        }

        $test->load(['user', 'answers.question']);
        $total = $test->answers()->count();
        
        return view('quiz.results', compact('test', 'total'));
    }
    
    // Show student's own quiz history
    public function myResults(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Geen gebruiker gevonden met dit e-mailadres.']);
        }
        
        $tests = Test::where('user_id', $user->id)
            ->whereNotNull('score')
            ->with(['answers.question'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('quiz.my-results', compact('tests', 'user'));
    }
}
