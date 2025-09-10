<x-app-layout>
    <x-slot name="header">
        Resultaten test #{{ $test->id }}
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">

        @if(session('success'))
            <div class="bg-green-100 text-green-800 rounded-lg p-4">{{ session('success') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 space-y-2">
            <p><span class="font-semibold">Student:</span> {{ $test->user->name }} ({{ $test->user->email }})</p>
            <p><span class="font-semibold">Datum:</span> {{ $test->created_at->format('d-m-Y H:i') }}</p>
            <p><span class="font-semibold">Score:</span> {{ $test->score }} / {{ $total }}</p>
        </div>

        <div class="space-y-4">
            @foreach($test->answers as $idx => $ans)
                <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-4 space-y-2">
                    <p class="font-semibold">{{ $idx+1 }}. {{ $ans->question->question }}</p>
                    <p>Jouw antwoord: <strong>{{ $ans->student_answer ?? '—' }}</strong></p>
                    <p>Correct antwoord: <strong>{{ $ans->question->answer }}</strong></p>
                    <p>
                        Status:
                        @if($ans->is_correct)
                            <span class="text-green-600 font-semibold">✔️ Correct</span>
                        @else
                            <span class="text-red-600 font-semibold">❌ Fout</span>
                        @endif
                    </p>
                </div>
            @endforeach
        </div>

        <div>
            <a href="{{ route('teacher.results') }}" class="text-indigo-600 hover:underline">← Terug naar overzicht</a>
        </div>
    </div>
</x-app-layout>
