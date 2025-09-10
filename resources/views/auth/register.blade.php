@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card quiz-card">
                <div class="card-header bg-success text-white text-center">
                    <h3 class="mb-0">
                        <i class="bi bi-person-plus me-2"></i>Quiz Applicatie
                    </h3>
                    <p class="mb-0 mt-2">Docent Registratie</p>
                </div>
                
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="bi bi-person me-1"></i>Naam
                            </label>
                            <input id="name" type="text" 
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" 
                                   required autofocus autocomplete="name"
                                   placeholder="Voer je volledige naam in">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-1"></i>E-mailadres
                            </label>
                            <input id="email" type="email" 
                                   class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" 
                                   required autocomplete="username"
                                   placeholder="Voer je e-mailadres in">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Role Selection -->
                        <div class="mb-3">
                            <label for="role" class="form-label">
                                <i class="bi bi-shield me-1"></i>Rol
                            </label>
                            <select id="role" name="role" class="form-select form-select-lg @error('role') is-invalid @enderror" required>
                                <option value="">Selecteer je rol...</option>
                                <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>
                                    <i class="bi bi-mortarboard"></i> Docent
                                </option>
                                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>
                                    <i class="bi bi-person"></i> Student
                                </option>
                            </select>
                            @error('role')
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
                                   name="password" required autocomplete="new-password"
                                   placeholder="Kies een veilig wachtwoord">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">
                                <i class="bi bi-lock-fill me-1"></i>Bevestig Wachtwoord
                            </label>
                            <input id="password_confirmation" type="password" 
                                   class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" 
                                   name="password_confirmation" required autocomplete="new-password"
                                   placeholder="Herhaal je wachtwoord">
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-person-plus me-2"></i>Account Aanmaken
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light text-center">
                    <small class="text-muted">
                        Al een account? 
                        <a href="{{ route('login') }}" class="text-decoration-none">Login hier</a>
                    </small>
                    <br>
                    <small class="text-muted mt-2 d-block">
                        Student? <a href="{{ route('quiz.start') }}" class="text-decoration-none">Start direct een quiz</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
