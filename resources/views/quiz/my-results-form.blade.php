@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card quiz-card">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0"><i class="bi bi-clipboard-data me-2"></i>Mijn Quiz Resultaten</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Bekijk je quiz geschiedenis</h5>
                        <p class="text-muted">Voer je e-mailadres in om al je quiz resultaten te bekijken.</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('quiz.my-results') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mailadres</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required
                                   placeholder="Voer je e-mailadres in..." autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Dit is het e-mailadres waarmee je eerder quizzes hebt gemaakt.
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-info btn-lg">
                                <i class="bi bi-search me-2"></i>Resultaten Zoeken
                            </button>
                            <a href="{{ route('quiz.start') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Terug naar Quiz Start
                            </a>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Je ziet alleen voltooide quizzes die gekoppeld zijn aan je e-mailadres.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
