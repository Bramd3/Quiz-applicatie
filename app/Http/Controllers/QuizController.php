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

    // Maak (of vind) een student user + test + selecteer vragen
    public function start(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'count' => 'required|integer|min:1'
        ]);

        // Vind of maak user
        $user = User::firstOrCreate(
            ['email' => $data['email']],
            ['name' => $data['name'], 'password' => Str::password(12), 'role' => 'student']
        );

        // Kies vragen (random)
        $questions = Question::inRandomOrder()->limit($data['count'])->get();

        if ($questions->isEmpty()) {
            return back()->withErrors(['count' => 'Er zijn nog geen vragen beschikbaar. Importeer eerst vragen.']);
        }

        // Maak test
        $test = Test::create([
            'user_id' => $user->id,
            'score' => null,
        ]);

        // Maak lege Answer records zodat we per vraag een id hebben
        foreach ($questions as $q) {
            Answer::create([
                'test_id' => $test->id,
                'question_id' => $q->id,
                'student_answer' => null,
                'is_correct' => null,
            ]);
        }

        return redirect()->route('quiz.play', $test);
    }

    // Toon quiz met vragen
    public function play(Test $test)
    {
        // Laad vragen via answers-relatie
        $answers = $test->answers()->with('question')->get();

        // Als al nagekeken is, ga naar resultaten
        if (!is_null($test->score)) {
            return redirect()->route('teacher.results.show', $test->id);
        }

        return view('quiz.play', compact('test', 'answers'));
    }

    // Ontvang inzending, check automatisch en bereken score
    public function submit(Request $request, Test $test)
    {
        // Zorg dat we alleen kunnen indienen als test nog niet is nagekeken
        if (!is_null($test->score)) {
            return redirect()->route('teacher.results.show', $test->id);
        }

        // Antwoorden binnen: array[answer_id => value]
        $payload = $request->validate([
            'answers' => 'required|array'
        ]);

        DB::transaction(function () use ($payload, $test) {
            $correct = 0;

            foreach ($payload['answers'] as $answerId => $value) {
                /** @var Answer $answer */
                $answer = Answer::where('id', $answerId)->where('test_id', $test->id)->with('question')->first();
                if (!$answer) continue;

                $studentValue = is_string($value) ? trim($value) : $value;
                $question = $answer->question;

                // Auto-checker
                $isCorrect = false;

                if ($question->type === 'multiple_choice') {
                    // Vergelijk exact op tekstoptie (zoals we ze opslaan bij import)
                    $isCorrect = strcasecmp((string)$studentValue, (string)$question->answer) === 0;
                } else {
                    // open vraag: normalizeer (case-insensitief, trim)
                    $isCorrect = strcasecmp((string)$studentValue, (string)trim($question->answer)) === 0;
                }

                $answer->update([
                    'student_answer' => $studentValue,
                    'is_correct' => $isCorrect,
                ]);

                if ($isCorrect) $correct++;
            }

            // Score = #correct
            $test->update(['score' => $correct]);
        });

        // Toon resultaat pagina met feedback
        return redirect()->route('teacher.results.show', $test->id)
            ->with('success', 'Je antwoorden zijn ingediend en nagekeken.');
    }
}
