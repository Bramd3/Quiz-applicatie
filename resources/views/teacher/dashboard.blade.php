@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-speedometer2 me-2"></i>Docent Dashboard</h2>
                <div>
                    <a href="{{ route('questions.create') }}" class="btn btn-success me-2">
                        <i class="bi bi-plus-circle me-1"></i>Nieuwe Vraag
                    </a>
                    <a href="{{ route('questions.import') }}" class="btn btn-info">
                        <i class="bi bi-upload me-1"></i>Import Vragen
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body text-center">
                    <i class="bi bi-question-circle display-4 mb-2"></i>
                    <h3>{{ $totalQuestions }}</h3>
                    <p class="mb-0">Totaal Vragen</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body text-center">
                    <i class="bi bi-clipboard-check display-4 mb-2"></i>
                    <h3>{{ $totalTests }}</h3>
                    <p class="mb-0">Gemaakte Tests</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body text-center">
                    <i class="bi bi-people display-4 mb-2"></i>
                    <h3>{{ $totalStudents }}</h3>
                    <p class="mb-0">Studenten</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up display-4 mb-2"></i>
                    <h3>{{ $averagePercentage }}%</h3>
                    <p class="mb-0">Gemiddelde Score</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Snelle Acties</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('questions.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-gear me-2"></i>Vragen Beheren
                        </a>
                        <a href="{{ route('teacher.results') }}" class="btn btn-outline-success">
                            <i class="bi bi-bar-chart me-2"></i>Alle Resultaten
                        </a>
                        <a href="{{ route('questions.create') }}" class="btn btn-outline-info">
                            <i class="bi bi-plus-square me-2"></i>Nieuwe Vraag Toevoegen
                        </a>
                        <a href="{{ route('questions.import') }}" class="btn btn-outline-warning">
                            <i class="bi bi-file-earmark-arrow-up me-2"></i>Vragen Importeren
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Tests -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Recente Tests</h5>
                    <a href="{{ route('teacher.results') }}" class="btn btn-sm btn-outline-primary">
                        Bekijk Alle
                    </a>
                </div>
                <div class="card-body">
                    @if($recentTests->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Score</th>
                                        <th>Percentage</th>
                                        <th>Datum</th>
                                        <th>Actie</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTests as $test)
                                        @php
                                            // Gebruik waarden uit de database, voorkom deling door 0
                                            $score = $test->score ?? 0;
                                            $percentage = $test->percentage ?? 0;
                                            $badgeClass = $percentage >= 80 ? 'success' : ($percentage >= 60 ? 'warning' : 'danger');
                                        @endphp
                                        <tr>
                                            <td>
                                                <i class="bi bi-person-circle me-2"></i>{{ $test->user->name }}
                                            </td>
                                            <td>
                                                <strong>{{ $score }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $badgeClass }}">{{ $percentage }}%</span>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $test->created_at->format('d/m H:i') }}</small>
                                            </td>
                                            <td>
                                                <a href="{{ route('teacher.results.show', $test) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if(method_exists($recentTests, 'links'))
                            <div class="d-flex justify-content-center mt-3">
                                {{ $recentTests->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox display-4 text-muted mb-3"></i>
                            <p class="text-muted">Nog geen tests gemaakt</p>
                            <a href="{{ route('quiz.start') }}" class="btn btn-primary">
                                <i class="bi bi-play-circle me-2"></i>Start Eerste Quiz
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
