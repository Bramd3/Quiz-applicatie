@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Summary Card -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="bi bi-check2-circle me-2"></i>Resultaten test #{{ $test->id }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-2"><strong>Student:</strong></div>
                            <div>{{ $test->user->name }} <small class="text-muted">({{ $test->user->email }})</small></div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2"><strong>Datum:</strong></div>
                            <div>{{ $test->created_at->format('d-m-Y H:i') }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2"><strong>Score:</strong></div>
                            @php
                                $percentage = $test->total_questions 
                                    ? round(($test->score / $test->total_questions) * 100, 1) 
                                    : 0;
                                $badgeClass = $percentage >= 80 ? 'success' : ($percentage >= 60 ? 'warning' : 'danger');
                            @endphp
                            <div>
                                <span class="badge bg-{{ $badgeClass }} fs-6">{{ $test->score }} / {{ $test->total_questions }} ({{ $percentage }}%)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Answers -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-card-checklist me-2"></i>Antwoorden</h5>
                </div>
                <div class="card-body">
                    @foreach($test->answers as $idx => $ans)
                        <div class="card mb-3 {{ $ans->is_correct ? 'result-correct' : 'result-incorrect' }}">
                            <div class="card-body">
                                <h6 class="card-title mb-2">{{ $idx + 1 }}. {{ $ans->question->question }}</h6>
                                <p class="mb-1">Jouw antwoord: <strong>{{ $ans->student_answer ?? '—' }}</strong></p>
                                <p class="mb-0">Correct antwoord: <strong class="text-success">{{ $ans->question->answer }}</strong></p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('teacher.results') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Terug naar overzicht
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
