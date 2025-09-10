@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            @php
                $answer = $answers[$current];
                $q = $answer->question;
                $options = $q->options ?? [];
                $progressPercentage = (($current + 1) / $total) * 100;
            @endphp
            
            <!-- Progress Section -->
            <div class="card mb-4">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <small class="text-muted">Voortgang Quiz</small>
                        <small class="text-muted">Vraag {{ $current + 1 }} van {{ $total }}</small>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" role="progressbar" 
                             style="width: {{ $progressPercentage }}%" 
                             aria-valuenow="{{ $progressPercentage }}" 
                             aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Question Card -->
            <div class="card question-card quiz-card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-question-circle me-2"></i>Vraag {{ $current + 1 }}
                        </h5>
                        <span class="badge bg-light text-dark">
                            @if($q->type === 'multiple_choice')
                                <i class="bi bi-list-check"></i> Multiple Choice
                            @else
                                <i class="bi bi-pencil"></i> Open Vraag
                            @endif
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="question-text mb-4">
                        <p class="fs-5 mb-0 fw-normal">{{ $q->question }}</p>
                        @if($q->type === 'multiple_choice' && count($options) > 0)
                            <small class="text-muted mt-2 d-block">
                                <i class="bi bi-info-circle me-1"></i>
                                Kies het juiste antwoord uit {{ count($options) }} opties
                            </small>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('quiz.submit', $test) }}">
                        @csrf
                        
                        @if($q->type === 'multiple_choice')
                            <!-- Multiple Choice Options -->
                            <div class="row g-3">
                                @foreach($options as $index => $option)
                                    <div class="col-md-6">
                                        <button type="submit" name="answer" value="{{ $option }}"
                                                class="btn btn-outline-primary w-100 py-3 text-start option-btn">
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-primary rounded-pill me-3">{{ chr(65 + $index) }}</span>
                                                <span>{{ $option }}</span>
                                            </div>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Open Answer -->
                            <div class="mb-3">
                                <label for="answer" class="form-label">Jouw antwoord:</label>
                                <input type="text" class="form-control form-control-lg" 
                                       id="answer" name="answer" required 
                                       placeholder="Typ hier je antwoord..." autofocus>
                            </div>
                            
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-arrow-right me-2"></i>
                                    @if($current + 1 >= $total)
                                        Quiz Voltooien
                                    @else
                                        Volgende Vraag
                                    @endif
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
                
                @if($q->type === 'multiple_choice')
                    <div class="card-footer bg-light">
                        <small class="text-muted">
                            <i class="bi bi-lightbulb me-1"></i>
                            Klik op het antwoord dat je denkt dat juist is.
                        </small>
                    </div>
                @endif
            </div>
            
            <!-- Navigation Hint -->
            <div class="text-center mt-3">
                <small class="text-muted">
                    @if($current + 1 >= $total)
                        <i class="bi bi-flag-checkered me-1"></i>Dit is de laatste vraag!
                    @else
                        <i class="bi bi-arrow-repeat me-1"></i>{{ $total - ($current + 1) }} {{ ($total - ($current + 1)) == 1 ? 'vraag' : 'vragen' }} te gaan
                    @endif
                </small>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.option-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.option-btn:focus {
    transform: none;
}
.option-btn:disabled {
    transform: none;
    opacity: 0.8;
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
    border-color: #0056b3;
}
.loading-pulse {
    animation: pulse 1.5s infinite;
}
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}
</style>
@endpush

@push('scripts')
<script>
// Enhanced button feedback for better UX
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const optionButtons = document.querySelectorAll('.option-btn');
    let submitted = false;
    
    // Add click handlers for option buttons
    optionButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            if (submitted) return;
            
            // Immediate visual feedback
            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-primary', 'loading-pulse');
            
            // Disable all other buttons
            optionButtons.forEach(btn => {
                if (btn !== this) {
                    btn.disabled = true;
                    btn.style.opacity = '0.3';
                }
            });
            
            // Show loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="bi bi-check-circle me-2"></i>Geselecteerd...';
        });
    });
    
    // Form submission handler
    if (form) {
        form.addEventListener('submit', function(e) {
            if (submitted) {
                e.preventDefault();
                return false;
            }
            submitted = true;
        });
    }
});
</script>
@endpush
@endsection
