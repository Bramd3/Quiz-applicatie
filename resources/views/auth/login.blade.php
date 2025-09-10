@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card quiz-card">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">
                        <i class="bi bi-mortarboard me-2"></i>Quiz Applicatie
                    </h3>
                    <p class="mb-0 mt-2">Docent Login</p>
                </div>
                
                <div class="card-body p-5">
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-1"></i>E-mailadres
                            </label>
                            <input id="email" type="email" 
                                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" 
                                   required autofocus autocomplete="username"
                                   placeholder="Voer je e-mailadres in">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock me-1"></i>Wachtwoord
                            </label>
                            <input id="password" type="password" 
                                   class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password"
                                   placeholder="Voer je wachtwoord in">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                <label class="form-check-label" for="remember_me">
                                    Onthoud mij
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Inloggen
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none" href="{{ route('password.request') }}">
                                    <i class="bi bi-question-circle me-1"></i>Wachtwoord vergeten?
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light text-center">
                    <small class="text-muted">
                        Nog geen account? 
                        <a href="{{ route('register') }}" class="text-decoration-none">Registreer hier</a>
                    </small>
                    <br>
                    <small class="text-muted mt-2 d-block">
                        Student? <a href="{{ route('quiz.start') }}" class="text-decoration-none">Start direct een quiz</a>
                    </small>
                </div>
            </div>
            
            <!-- Test Accounts Info -->
            @if(config('app.debug'))
                <div class="card mt-3">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="bi bi-info-circle me-1"></i>Test Accounts</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <strong>Docent:</strong><br>
                                <small>teacher@quiz.app</small><br>
                                <small>password123</small>
                            </div>
                            <div class="col-6">
                                <strong>Student:</strong><br>
                                <small>student@quiz.app</small><br>
                                <small>password123</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
