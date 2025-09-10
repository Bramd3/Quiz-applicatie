<x-app-layout>
    <x-slot name="header">
        Quiz: {{ $test->title ?? 'Beantwoord de vragen' }}
    </x-slot>

<div class="max-w-2xl mx-auto space-y-6">

    <!-- Progress bar -->
    <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-4 overflow-hidden">
        <div class="bg-purple-500 h-4 rounded-full transition-all"
             style="width: {{ ($current+1)/$total*100 }}%;"></div>
    </div>

    <!-- Vraag card -->
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-6 space-y-4">
        @php
            $answer = $answers[$current];
            $q = $answer->question;
            $options = [];
            if ($q->type === 'multiple_choice' && $q->options) {
                $options = json_decode($q->options, true);
            }
        @endphp

        <p class="text-xl font-semibold">Vraag {{ $current+1 }} / {{ $total }}</p>
        <p class="text-gray-700 dark:text-gray-200 text-lg">{{ $q->question }}</p>

        <form action="{{ route('quiz.submit', $test) }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="answer_id" value="{{ $answer->id }}">

            @if($q->type === 'multiple_choice')
                <div class="grid grid-cols-1 gap-3">
                    @foreach($options as $opt)
                        <button type="submit" name="answer" value="{{ $opt }}"
                                class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold py-3 rounded-xl hover:from-indigo-600 hover:to-purple-700 transition">
                            {{ $opt }}
                        </button>
                    @endforeach
                </div>
            @else
                <div class="flex space-x-2">
                    <input type="text" name="answer" required
                           class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <button type="submit"
                            class="bg-purple-500 hover:bg-purple-600 text-white font-semibold px-4 rounded-lg transition">
                        Volgende
                    </button>
                </div>
            @endif
        </form>
    </div>
</div>
</x-app-layout>
