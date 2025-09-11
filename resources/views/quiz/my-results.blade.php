@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm">
            <div class="card-header">Mijn Resultaten</div>
            <div class="card-body">
                @if($tests->isEmpty())
                    <div class="alert alert-warning">Je hebt nog geen quiz gemaakt.</div>
                @else
                    <ul class="list-group mb-3">
                        @foreach($tests as $test)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{ route('quiz.results', $test->id) }}">
                                    Quiz op {{ $test->created_at->format('d-m-Y H:i') }}
                                </a>
                                <span>
                                    {{ $test->score }} / {{ $test->answers->count() }}
                                    ({{ round(($test->score / $test->answers->count()) * 100, 1) }}%)
                                </span>
                            </li>
                        @endforeach
                    </ul>

                    {{ $tests->links('pagination::bootstrap-5') }}
                @endif

                <div class="mt-3">
                    <a href="{{ route('quiz.start') }}" class="btn btn-primary">Nieuwe quiz starten</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
