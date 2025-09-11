@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">{{ $quiz->title }}</h1>

    <form action="{{ route('quiz.submit', $quiz) }}" method="POST" class="space-y-6">
        @csrf
        @foreach($questions as $index => $question)
            <div class="p-4 border rounded-lg bg-gray-50 dark:bg-gray-800">
                <p class="font-semibold mb-2">{{ $index+1 }}. {{ $question->question }}</p>

                @if($question->type === 'multiple_choice')
                    @foreach(json_decode($question->options, true) as $option)
                        <label class="block">
                            <input type="radio" name="question_{{ $question->id }}" value="{{ $option }}" required>
                            {{ $option }}
                        </label>
                    @endforeach
                @else
                    <input type="text" name="question_{{ $question->id }}" class="w-full border p-2 rounded" required>
                @endif
            </div>
        @endforeach

        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
            Verzenden
        </button>
    </form>
@endsection