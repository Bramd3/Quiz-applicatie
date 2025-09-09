<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>Resultaten test #{{ $test->id }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family:sans-serif; max-width:1000px; margin:32px auto;">
    <h1>Resultaten test #{{ $test->id }}</h1>

    @if (session('success'))
        <p style="color:#065f46">{{ session('success') }}</p>
    @endif

    <p>
        Student: <strong>{{ $test->user->name }}</strong> ({{ $test->user->email }})<br>
        Datum: {{ $test->created_at->format('d-m-Y H:i') }}<br>
        Score: <strong>{{ $test->score }}</strong> / {{ $total }}
    </p>

    <hr style="margin:16px 0;">

    <ol>
        @foreach ($test->answers as $idx => $ans)
            <li style="margin-bottom:16px;">
                <div style="font-weight:600;">{{ $ans->question->question }}</div>
                <div>Jouw antwoord: <strong>{{ $ans->student_answer ?? '—' }}</strong></div>
                <div>Correct antwoord: <strong>{{ $ans->question->answer }}</strong></div>
                <div>
                    Status:
                    @if ($ans->is_correct)
                        <span style="color:#065f46">✔️ Correct</span>
                    @else
                        <span style="color:#b91c1c">❌ Fout</span>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>

    <p><a href="{{ route('teacher.results') }}">← Terug naar overzicht</a></p>
</body>
</html>
