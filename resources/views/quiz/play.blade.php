<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>Quiz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: sans-serif;
            max-width: 900px;
            margin: 32px auto;
        }
        fieldset {
            border: 1px solid #ddd;
            padding: 16px;
            border-radius: 8px;
        }
        legend {
            font-weight: bold;
        }
        label {
            display: block;
            margin: 6px 0;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
        }
        button {
            padding: 10px 16px;
            margin-top: 16px;
        }
    </style>
</head>
<body>
    <h1>Beantwoord de vragen</h1>

    <form action="{{ route('quiz.submit', $test) }}" method="POST" style="display:grid; gap:24px;">
        @csrf

        @foreach ($answers as $index => $answer)
            @php
                $q = $answer->question;

                // Decode JSON voor multiple choice
                $options = [];
                if ($q->type === 'multiple_choice' && $q->options) {
                    $options = json_decode($q->options, true);
                }
            @endphp

            <fieldset>
                <legend>Vraag {{ $index + 1 }}</legend>
                <p style="font-weight:600; margin-bottom:10px;">{{ $q->question }}</p>

                @if ($q->type === 'multiple_choice')
                    @foreach ($options as $opt)
                        <label>
                            <input type="radio" name="answers[{{ $answer->id }}]" value="{{ $opt }}" required>
                            {{ $opt }}
                        </label>
                    @endforeach
                @else
                    <input type="text" name="answers[{{ $answer->id }}]" required>
                @endif
            </fieldset>
        @endforeach

        <button type="submit">Inleveren en nakijken</button>
    </form>
</body>
</html>
