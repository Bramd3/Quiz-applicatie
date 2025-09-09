<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>Resultaten overzicht</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family:sans-serif; max-width:1000px; margin:32px auto;">
    <h1>Resultaten overzicht</h1>

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse:collapse; width:100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>Student</th>
                <th>Email</th>
                <th>Score</th>
                <th>Datum</th>
                <th>Actie</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tests as $t)
                <tr>
                    <td>{{ $t->id }}</td>
                    <td>{{ $t->user->name }}</td>
                    <td>{{ $t->user->email }}</td>
                    <td>{{ $t->score ?? '—' }}</td>
                    <td>{{ $t->created_at->format('d-m-Y H:i') }}</td>
                    <td><a href="{{ route('teacher.results.show', $t) }}">Bekijken</a></td>
                </tr>
            @empty
                <tr><td colspan="6">Nog geen resultaten.</td></tr>
            @endforelse
        </tbody>
    </table>

    <p style="margin-top:16px;">
        <a href="{{ route('quiz.start') }}">Nieuwe quiz starten</a>
    </p>

    @if (method_exists($tests, 'links'))
        <div style="margin-top:12px;">
            {{ $tests->links() }}
        </div>
    @endif
</body>
</html>
