<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Vragen importeren</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family:sans-serif; max-width:720px; margin:32px auto;">
    <h1>Upload vragenbestand (JSON/CSV)</h1>

    @if(session('success'))
        <p style="color:#065f46">{{ session('success') }}</p>
    @endif
    @if ($errors->any())
        <div style="color:#b91c1c; margin:12px 0;">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('questions.import.store') }}" method="POST" enctype="multipart/form-data" style="display:grid; gap:12px;">
        @csrf
        <input type="file" name="file" required>
        <button type="submit" style="padding:10px 16px;">Upload</button>
    </form>

    <p style="margin-top:24px;">
        <a href="{{ route('quiz.start') }}">← Terug naar start</a>
    </p>
</body>
</html>
