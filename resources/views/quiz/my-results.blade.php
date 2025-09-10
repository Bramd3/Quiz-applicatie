@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-person-circle me-2"></i>Quiz Resultaten voor {{ $user->name }}</h2>
                <a href="{{ route('quiz.my-results.form') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Terug
                </a>
            </div>
        </div>
    </div>

    @if($tests->count() > 0)
        <!-- Statistics Card -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <i class="bi bi-clipboard-check display-4 mb-2"></i>
                        <h3>{{ $tests->count() }}</h3>
                        <p class="mb-0">Voltooide Quizzes</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <i class="bi bi-graph-up display-4 mb-2"></i>
                        @php
                            $totalQuestions = \App\Models\Question::count();
                            $averageScore = $tests->avg('score');
                            $averagePercentage = $totalQuestions > 0 ? round(($averageScore / $totalQuestions) * 100, 1) : 0;
                        @endphp
                        <h3>{{ $averagePercentage }}%</h3>
                        <p class="mb-0">Gemiddelde Score</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <i class="bi bi-trophy display-4 mb-2"></i>
                        <h3>{{ $tests->max('score') }}</h3>
                        <p class="mb-0">Hoogste Score</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar-check display-4 mb-2"></i>
                        <h3>{{ $tests->first()->created_at->format('d/m') }}</h3>
                        <p class="mb-0">Laatste Quiz</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quiz Results Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Alle Quiz Resultaten</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Datum & Tijd</th>
                                <th>Score</th>
                                <th>Percentage</th>
                                <th>Prestatie</th>
                                <th>Actie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tests as $test)
                                @php
                                    $totalQuestions = $test->answers->count();
                                    $percentage = $totalQuestions > 0 ? round(($test->score / $totalQuestions) * 100, 1) : 0;
                                    $badgeClass = $percentage >= 80 ? 'success' : ($percentage >= 60 ? 'warning' : 'danger');
                                    $performanceText = $percentage >= 80 ? 'Uitstekend' : ($percentage >= 60 ? 'Goed' : 'Oefenen');
                                    $emoji = $percentage >= 80 ? '🏆' : ($percentage >= 60 ? '👍' : '📚');
                                @endphp
                                <tr>
                                    <td><strong>{{ $test->id }}</strong></td>
                                    <td>
                                        <div>{{ $test->created_at->format('d-m-Y') }}</div>
                                        <small class="text-muted">{{ $test->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $test->score }}/{{ $totalQuestions }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $badgeClass }} fs-6">{{ $percentage }}%</span>
                                    </td>
                                    <td>
                                        <span class="text-{{ $badgeClass }}">
                                            {{ $emoji }} {{ $performanceText }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('results.show', $test) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i>Bekijk Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $tests->links() }}
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center mt-4">
            <a href="{{ route('quiz.start') }}" class="btn btn-success btn-lg">
                <i class="bi bi-plus-circle me-2"></i>Nieuwe Quiz Starten
            </a>
        </div>

    @else
        <!-- No Results State -->
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox display-1 text-muted mb-4"></i>
                <h4>Nog geen quiz resultaten</h4>
                <p class="text-muted mb-4">
                    Er zijn nog geen voltooide quizzes gevonden voor <strong>{{ $user->email }}</strong>.
                </p>
                <div>
                    <a href="{{ route('quiz.start') }}" class="btn btn-primary btn-lg me-2">
                        <i class="bi bi-play-circle me-2"></i>Eerste Quiz Starten
                    </a>
                    <a href="{{ route('quiz.my-results.form') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Terug
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Tips Card -->
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0"><i class="bi bi-lightbulb me-2"></i>Tips voor betere resultaten</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h6 class="text-primary"><i class="bi bi-arrow-repeat me-1"></i>Blijf oefenen</h6>
                    <p class="small">Herhaling is de sleutel tot succes. Maak regelmatig nieuwe quizzes om je kennis te versterken.</p>
                </div>
                <div class="col-md-4">
                    <h6 class="text-success"><i class="bi bi-book me-1"></i>Bestudeer fouten</h6>
                    <p class="small">Kijk terug naar je foute antwoorden en leer van je vergissingen.</p>
                </div>
                <div class="col-md-4">
                    <h6 class="text-info"><i class="bi bi-target me-1"></i>Stel doelen</h6>
                    <p class="small">Probeer elke keer een hoger percentage te behalen dan je vorige poging.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
