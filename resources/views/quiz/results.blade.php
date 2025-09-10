@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            <!-- Congratulations Card -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white text-center">
                    <h3 class="mb-0">
                        <i class="bi bi-trophy-fill me-2"></i>Quiz Voltooid!
                    </h3>
                </div>
                <div class="card-body text-center">
                    @php
                        $percentage = $total > 0 ? round(($test->score / $total) * 100, 1) : 0;
                        $badgeClass = $percentage >= 80 ? 'success' : ($percentage >= 60 ? 'warning' : 'danger');
                        $message = $percentage >= 80 ? 'Uitstekend!' : ($percentage >= 60 ? 'Goed gedaan!' : 'Blijf oefenen!');
                        $emoji = $percentage >= 80 ? '🎉' : ($percentage >= 60 ? '👍' : '💪');
                    @endphp
                    
                    <div class="mb-4">
                        <h1 class="display-4 mb-3">
                            <span class="badge bg-{{ $badgeClass }} fs-1">{{ $test->score }}/{{ $total }}</span>
                        </h1>
                        <h2 class="text-{{ $badgeClass }}">{{ $percentage }}%</h2>
                        <p class="lead">{{ $message }} {{ $emoji }}</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-2"><strong>Student:</strong></div>
                            <div>{{ $test->user->name }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2"><strong>Voltooid op:</strong></div>
                            <div>{{ $test->updated_at->format('d-m-Y H:i') }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2"><strong>Aantal vragen:</strong></div>
                            <div>{{ $total }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Answers -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-list-check me-2"></i>Jouw Antwoorden
                        <small class="text-muted ms-2">- Leer van je fouten!</small>
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($test->answers as $idx => $answer)
                        <div class="card mb-3 {{ $answer->is_correct ? 'result-correct' : 'result-incorrect' }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title mb-0">
                                        <span class="badge bg-primary me-2">{{ $idx + 1 }}</span>
                                        {{ $answer->question->question }}
                                    </h6>
                                    <span class="badge bg-{{ $answer->is_correct ? 'success' : 'danger' }}">
                                        @if($answer->is_correct)
                                            <i class="bi bi-check-circle me-1"></i>Correct
                                        @else
                                            <i class="bi bi-x-circle me-1"></i>Incorrect
                                        @endif
                                    </span>
                                </div>
                                
                                @if($answer->question->type === 'multiple_choice')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small class="text-muted">Beschikbare opties:</small>
                                            <ul class="list-unstyled mt-1">
                                                @foreach($answer->question->options as $option)
                                                    <li class="mb-1">
                                                        @if($option === $answer->student_answer)
                                                            <i class="bi bi-arrow-right-circle-fill text-primary me-1"></i>
                                                            <strong>{{ $option }}</strong> (jouw keuze)
                                                        @elseif($option === $answer->question->answer)
                                                            <i class="bi bi-check-circle-fill text-success me-1"></i>
                                                            <strong class="text-success">{{ $option }}</strong> (correct)
                                                        @else
                                                            <i class="bi bi-circle me-1"></i>{{ $option }}
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <small class="text-muted">Jouw antwoord:</small>
                                                <br><strong class="{{ $answer->is_correct ? 'text-success' : 'text-danger' }}">{{ $answer->student_answer }}</strong>
                                            </div>
                                            @if(!$answer->is_correct)
                                                <div>
                                                    <small class="text-muted">Correct antwoord:</small>
                                                    <br><strong class="text-success">{{ $answer->question->answer }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small class="text-muted">Jouw antwoord:</small>
                                            <br><strong class="{{ $answer->is_correct ? 'text-success' : 'text-danger' }}">{{ $answer->student_answer ?? '—' }}</strong>
                                        </div>
                                        @if(!$answer->is_correct)
                                            <div class="col-md-6">
                                                <small class="text-muted">Correct antwoord:</small>
                                                <br><strong class="text-success">{{ $answer->question->answer }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center mt-4">
                <div class="btn-group" role="group">
                    <a href="{{ route('quiz.start') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-arrow-repeat me-2"></i>Nieuwe Quiz Starten
                    </a>
                    
                    <a href="{{ route('quiz.my-results.form') }}" class="btn btn-outline-info btn-lg">
                        <i class="bi bi-clipboard-data me-2"></i>Mijn Alle Resultaten
                    </a>
                    
                    @auth
                        @if(auth()->user()->isTeacher())
                            <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-primary btn-lg">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
            
            <!-- Study Tips -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="bi bi-lightbulb me-2"></i>Studietips</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="text-success"><i class="bi bi-check-circle me-1"></i>Goed beantwoord</h6>
                            <p class="small">Je hebt <strong>{{ $test->answers->where('is_correct', true)->count() }}</strong> vragen correct beantwoord. Goed gedaan!</p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-warning"><i class="bi bi-exclamation-circle me-1"></i>Aandachtspunten</h6>
                            <p class="small">
                                @if($test->answers->where('is_correct', false)->count() > 0)
                                    Bestudeer de <strong>{{ $test->answers->where('is_correct', false)->count() }}</strong> foute antwoorden nog eens.
                                @else
                                    Perfect! Alle vragen correct beantwoord.
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-primary"><i class="bi bi-graph-up me-1"></i>Blijf oefenen</h6>
                            <p class="small">Herhaling is de sleutel tot succes. Probeer regelmatig nieuwe quizzes!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.result-correct {
    border-left: 4px solid #28a745;
    background-color: #d4edda;
}
.result-incorrect {
    border-left: 4px solid #dc3545;
    background-color: #f8d7da;
}
</style>
@endpush
@endsection
