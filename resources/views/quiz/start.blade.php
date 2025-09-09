<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>Start quiz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family:sans-serif; max-width:720px; margin:32px auto;">
    <h1>Start een nieuwe quiz</h1>

    @if ($errors->any())
        <div style="color:#b91c1c; margin:12px 0;">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('quiz.start.post') }}" style="display:grid; gap:12px;">
        @csrf

        <label>
            Naam
            <input type="text" name="name" required value="{{ old('name') }}" style="width:100%; padding:8px;">
        </label>

        <label>
            E-mail
            <input type="email" name="email" required value="{{ old('email') }}" style="width:100%; padding:8px;">
        </label>

        <label>
            Aantal vragen (beschikbaar: {{ $questionCount }})
            <input type="number" name="count" min="1" max="{{ $questionCount }}" required value="{{ min(10, max(1, $questionCount)) }}" style="width:100%; padding:8px;">
        </label>

        <button type="submit" style="padding:10px 16px;">Start</button>
    </form>

    <p style="margin-top:24px;">
        Docent? Bekijk <a href="{{ route('teacher.results') }}">resultaten</a>.
    </p>
</body>
</html>
