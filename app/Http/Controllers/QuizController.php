<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function startForm()
    {
        $questionCount = Question::count();
        return view('quiz.start', compact('questionCount'));
    }

    public function start(Request $request)
    {
        $data = $request->validate([
            'count' => 'required|integer|min:1'
        ]);

        $user = Auth::user();

        $questions = Question::inRandomOrder()->limit($data['count'])->get();

        if ($questions->isEmpty()) {
            return back()->withErrors(['count' => 'Er zijn nog geen vragen beschikbaar.']);
        }

        $test = Test::create([
            'user_id' => $user->id,
            'score' => null,
            'total_questions' => null,
            'percentage' => null,
        ]);

        foreach ($questions as $q) {
            Answer::create([
                'test_id' => $test->id,
                'question_id' => $q->id,
                'student_answer' => null,
                'is_correct' => null,
            ]);
        }

        session(['current_question' => 0]);

        return redirect()->route('quiz.play', $test->id);
    }

    public function play(Test $test)
    {
        $answers = $test->answers()->with('question')->get();

        if ($answers->isEmpty()) {
            abort(404, 'Geen vragen beschikbaar voor deze test.');
        }

        if (!is_null($test->score)) {
            return redirect()->route('quiz.results', $test->id);
        }

        $current = session('current_question', 0);
        $total = $answers->count();

        if ($current >= $total) {
            session()->forget('current_question');
            return redirect()->route('quiz.results', $test->id);
        }

        $question = $answers[$current];

        return view('quiz.play', compact('test', 'answers', 'question', 'current', 'total'));
    }

    public function submit(Request $request, Test $test)
    {
        $answers = $test->answers()->with('question')->get();
        $current = session('current_question', 0);

        if ($current >= $answers->count()) {
            session()->forget('current_question');
            return redirect()->route('quiz.results', $test->id);
        }

        $answer = $answers[$current];
        $question = $answer->question;

        $payload = $request->validate([
            'answer' => 'required|string'
        ]);

        $studentValue = trim($payload['answer']);
        $isCorrect = strcasecmp($studentValue, $question->answer) === 0;

        $answer->update([
            'student_answer' => $studentValue,
            'is_correct' => $isCorrect
        ]);

        $current++;
        session(['current_question' => $current]);

        if ($current >= $answers->count()) {
            // ✅ Bereken score en percentage
            $score = $answers->where('is_correct', true)->count();
            $total = $answers->count();
            $percentage = $total > 0 ? round(($score / $total) * 100, 1) : 0;

            $test->update([
                'score' => $score,
                'total_questions' => $total,
                'percentage' => $percentage
            ]);

            session()->forget('current_question');

            return redirect()->route('quiz.results', $test->id)
                             ->with('success', 'Quiz voltooid! Je antwoorden zijn opgeslagen.');
        }

        return redirect()->route('quiz.play', $test->id);
    }

    public function showResults(Test $test)
    {
        if (is_null($test->score)) {
            return redirect()->route('quiz.play', $test->id)
                             ->with('error', 'Deze quiz is nog niet voltooid.');
        }

        $test->load(['user', 'answers.question']);

        return view('quiz.results', compact('test'));
    }

    public function myResults()
    {
        $user = Auth::user();

        $tests = Test::where('user_id', $user->id)
            ->whereNotNull('score')
            ->with(['answers.question'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('quiz.my-results', compact('tests', 'user'));
    }
}
