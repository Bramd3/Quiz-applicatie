<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Vragen importeren</title>
</head>
<body>
    <h1>Upload vragenbestand (JSON/CSV)</h1>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <form action="{{ route('questions.import.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
