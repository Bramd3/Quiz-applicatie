@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card quiz-card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="bi bi-play-circle me-2"></i>Quiz Starten</h3>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Welkom bij de Quiz Applicatie!</h5>
                        <p class="text-muted">Test je kennis met onze interactieve quiz. Vul je gegevens in om te beginnen.</p>
                        
                        @if($questionCount > 0)
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Er zijn momenteel <strong>{{ $questionCount }}</strong> vragen beschikbaar.
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Er zijn momenteel geen vragen beschikbaar. Neem contact op met je docent.
                            </div>
                        @endif
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

                    <form method="POST" action="{{ route('quiz.start.post') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Naam</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mailadres</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="count" class="form-label">Aantal vragen</label>
                            <select class="form-select @error('count') is-invalid @enderror" id="count" name="count" required>
                                <option value="">Kies aantal vragen...</option>
                                @for($i = 1; $i <= min($questionCount, 20); $i++)
                                    <option value="{{ $i }}" {{ old('count') == $i ? 'selected' : '' }}>
                                        {{ $i }} {{ $i == 1 ? 'vraag' : 'vragen' }}
                                    </option>
                                @endfor
                            </select>
                            @error('count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" {{ $questionCount == 0 ? 'disabled' : '' }}>
                                <i class="bi bi-play-fill me-2"></i>Quiz Starten
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light">
                    <small class="text-muted">
                        <i class="bi bi-clock me-1"></i>
                        De quiz wordt automatisch opgeslagen. Je kunt je antwoorden niet meer wijzigen na het indienen.
                    </small>
                </div>
            </div>
            
            <div class="text-center mt-3">
                @auth
                    @if(auth()->user()->isTeacher())
                        <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-primary me-2">
                            <i class="bi bi-speedometer2 me-2"></i>Naar Docent Dashboard
                        </a>
                    @endif
                @endauth
                
                <a href="{{ route('quiz.my-results.form') }}" class="btn btn-outline-info">
                    <i class="bi bi-clipboard-data me-2"></i>Mijn Quiz Resultaten
                </a>
                
                @guest
                    <div class="mt-2">
                        <p class="text-muted">
                            Docent? <a href="{{ route('login') }}" class="text-decoration-none">Log hier in</a>
                        </p>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection
