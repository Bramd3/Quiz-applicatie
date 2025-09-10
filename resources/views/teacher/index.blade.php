<x-app-layout>
    <x-slot name="header">
        Resultaten overzicht
    </x-slot>

    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-lg rounded-xl">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Student</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Datum</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actie</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($tests as $t)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4">{{ $t->id }}</td>
                        <td class="px-6 py-4">{{ $t->user->name }}</td>
                        <td class="px-6 py-4">{{ $t->user->email }}</td>
                        <td class="px-6 py-4">{{ $t->score ?? '—' }}</td>
                        <td class="px-6 py-4">{{ $t->created_at->format('d-m-Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('teacher.results.show', $t) }}" class="text-indigo-600 hover:underline">Bekijken</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Nog geen resultaten.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('quiz.start') }}" class="inline-block bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-6 rounded-lg transition">
            Nieuwe quiz starten
        </a>
    </div>

    @if(method_exists($tests, 'links'))
        <div class="mt-4">
            {{ $tests->links() }}
        </div>
    @endif
</x-app-layout>
