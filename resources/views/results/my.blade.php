@extends('layouts.app')

@section('content')    <h1 class="text-2xl font-bold mb-6">Mijn resultaten</h1>

    @if($results->isEmpty())
        <p>Je hebt nog geen quizresultaten.</p>
    @else
        <table class="w-full border-collapse bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="p-3 text-left">Quiz</th>
                    <th class="p-3 text-left">Score</th>
                    <th class="p-3 text-left">Percentage</th>
                    <th class="p-3 text-left">Datum</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                    <tr class="border-t">
                        <td class="p-3">{{ $result->quiz->title }}</td>
                        <td class="p-3">{{ $result->score }} / {{ $result->total_questions }}</td>
                        <td class="p-3">{{ round($result->percentage, 1) }}%</td>
                        <td class="p-3">{{ $result->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
