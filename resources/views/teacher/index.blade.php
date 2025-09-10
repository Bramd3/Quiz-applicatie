@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-bar-chart-line me-2"></i>Alle Test Resultaten</h2>
        <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-primary">
            <i class="bi bi-speedometer2 me-1"></i>Dashboard
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            @if($tests->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Student</th>
                                <th>Email</th>
                                <th>Score</th>
                                <th>Percentage</th>
                                <th>Datum</th>
                                <th>Status</th>
                                <th>Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalQuestions = \App\Models\Question::count();
                            @endphp
                            @foreach($tests as $test)
                                @php
                                    $percentage = $test->score && $totalQuestions > 0 
                                        ? round(($test->score / $totalQuestions) * 100, 1) 
                                        : 0;
                                    $badgeClass = $percentage >= 80 ? 'success' : ($percentage >= 60 ? 'warning' : 'danger');
                                    $statusClass = $test->score !== null ? 'success' : 'warning';
                                    $statusText = $test->score !== null ? 'Voltooid' : 'In uitvoering';
                                @endphp
                                <tr>
                                    <td><strong>{{ $test->id }}</strong></td>
                                    <td>
                                        <i class="bi bi-person-circle me-2"></i>{{ $test->user->name }}
                                    </td>
                                    <td><small>{{ $test->user->email }}</small></td>
                                    <td>
                                        @if($test->score !== null)
                                            <strong>{{ $test->score }}/{{ $totalQuestions }}</strong>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($test->score !== null)
                                            <span class="badge bg-{{ $badgeClass }}">{{ $percentage }}%</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $test->created_at->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('teacher.results.show', $test) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i>Bekijken
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if(method_exists($tests, 'links'))
                    <div class="d-flex justify-content-center mt-4">
                        {{ $tests->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="bi bi-clipboard-x display-1 text-muted mb-4"></i>
                    <h4>Nog geen resultaten</h4>
                    <p class="text-muted">Er zijn nog geen quizzes afgenomen.</p>
                    <a href="{{ route('quiz.start') }}" class="btn btn-primary">
                        <i class="bi bi-play-circle me-1"></i>Eerste Quiz Starten
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
