<!-- resources/views/quiz/start.blade.php -->
@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">Start de Quiz</div>
            <div class="card-body">
                @auth
                    <p>Welkom <strong>{{ auth()->user()->name }}</strong>!</p>

                    <form action="{{ route('quiz.start.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="count" class="form-label">Aantal vragen</label>
                            <input type="number" name="count" id="count" class="form-control" min="1" max="{{ $questionCount }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Start quiz</button>
                    </form>

                    <div class="mt-3">
                        <a href="{{ route('results.my') }}" class="btn btn-outline-secondary">Mijn resultaten</a>
                    </div>
                @else
                    <p>Log in om een quiz te starten.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">Inloggen</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">Registreren</a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
