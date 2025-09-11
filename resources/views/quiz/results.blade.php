@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    Resultaten
                </div>
                <div class="card-body">
                    <p><strong>Student:</strong> {{ $test->user->name }}</p>
                    <p><strong>Score:</strong> {{ $test->score }}</p>
                    <p><strong>Percentage:</strong> {{ $test->percentage }}%</p>

                    <h5 class="mt-4">Antwoorden</h5>
                    <ul class="list-group">
                        @foreach($test->answers as $answer)
                            <li class="list-group-item">
                                <strong>{{ $answer->question->question }}</strong><br>
                                <span class="text-muted">Jouw antwoord:</span> {{ $answer->student_answer ?? '-' }}<br>
                                <span class="text-muted">Correct antwoord:</span> {{ $answer->question->answer }}<br>
                                @if($answer->is_correct)
                                    <span class="badge bg-success">Correct</span>
                                @else
                                    <span class="badge bg-danger">Fout</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-3">
                        <a href="{{ route('quiz.start') }}" class="btn btn-primary">
                            Terug naar start
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
