<x-app-layout>
    <x-slot name="header">
        Start een nieuwe quiz
    </x-slot>

    <div class="max-w-lg mx-auto">
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 rounded-lg p-4 mb-4">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('quiz.start.post') }}" method="POST" class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6 space-y-4">
            @csrf

            <label class="block">
                <span class="text-gray-700 dark:text-gray-200 font-medium">Naam</span>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </label>

            <label class="block">
                <span class="text-gray-700 dark:text-gray-200 font-medium">E-mail</span>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </label>

            <label class="block">
                <span class="text-gray-700 dark:text-gray-200 font-medium">Aantal vragen (beschikbaar: {{ $questionCount }})</span>
                <input type="number" name="count" min="1" max="{{ $questionCount }}" value="{{ min(10,max(1,$questionCount)) }}" required
                    class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </label>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-6 rounded-lg transition">
                Start
            </button>
        </form>

        <p class="text-center mt-4 text-gray-600 dark:text-gray-400">
            Docent? Bekijk <a href="{{ route('teacher.results') }}" class="text-indigo-600 hover:underline">resultaten</a>.
        </p>
    </div>
</x-app-layout>
