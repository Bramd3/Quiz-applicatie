<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>Quiz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family:sans-serif; max-width:900px; margin:32px auto;">
    <h1>Beantwoord de vragen</h1>

    <form action="{{ route('quiz.submit', $test) }}" method="POST" style="display:grid; gap:24px;">
        @csrf

        @foreach ($answers as $index => $answer)
            @php
                $q = $answer->question;
            @endphp
            <fieldset style="border:1px solid #ddd; padding:16px; border-radius:8px;">
                <legend>Vraag {{ $index + 1 }}</legend>
                <p style="font-weight:600; margin-bottom:10px;">{{ $q->question }}</p>

                @if ($q->type === 'multiple_choice')
                    @foreach ($q->options ?? [] as $opt)
                        <label style="display:block; margin:6px 0;">
                            <input type="radio" name="answers[{{ $answer->id }}]" value="{{ $opt }}" required>
                            {{ $opt }}
                        </label>
                    @endforeach
                @else
                    <input type="text" name="answers[{{ $answer->id }}]" required style="width:100%; padding:8px;">
                @endif
            </fieldset>
        @endforeach

        <button type="submit" style="padding:10px 16px;">Inleveren en nakijken</button>
    </form>
</body>
</html>
