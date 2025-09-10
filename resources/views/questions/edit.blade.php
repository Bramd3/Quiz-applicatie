@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Vraag Bewerken</h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('questions.update', $question) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="question" class="form-label">Vraag</label>
                            <textarea class="form-control @error('question') is-invalid @enderror" 
                                      id="question" name="question" rows="3" required 
                                      placeholder="Typ hier je vraag...">{{ old('question', $question->question) }}</textarea>
                            @error('question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Type Vraag</label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" name="type" required onchange="toggleOptions()">
                                <option value="">Selecteer type...</option>
                                <option value="multiple_choice" {{ old('type', $question->type) == 'multiple_choice' ? 'selected' : '' }}>
                                    Multiple Choice
                                </option>
                                <option value="open" {{ old('type', $question->type) == 'open' ? 'selected' : '' }}>
                                    Open Vraag
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="options-section" class="mb-3" style="display: {{ old('type', $question->type) == 'multiple_choice' ? 'block' : 'none' }};">
                            <label class="form-label">Antwoordopties (Multiple Choice)</label>
                            <div id="options-container">
                                @php
                                    $oldOptions = old('options', $question->options ?? []);
                                    $maxOptions = max(4, count($oldOptions));
                                @endphp
                                
                                @for($i = 0; $i < $maxOptions; $i++)
                                    <div class="input-group mb-2">
                                        <span class="input-group-text">{{ chr(65 + $i) }}</span>
                                        <input type="text" class="form-control" 
                                               name="options[]" 
                                               placeholder="Antwoordoptie {{ chr(65 + $i) }}" 
                                               value="{{ $oldOptions[$i] ?? '' }}">
                                        @if($i >= 2)
                                            <button type="button" class="btn btn-outline-danger" 
                                                    onclick="removeOption(this)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addOption()">
                                <i class="bi bi-plus me-1"></i>Optie Toevoegen
                            </button>
                            <small class="form-text text-muted">Voer minimaal 2 antwoordopties in.</small>
                        </div>

                        <div class="mb-3">
                            <label for="answer" class="form-label">Correct Antwoord</label>
                            <input type="text" class="form-control @error('answer') is-invalid @enderror" 
                                   id="answer" name="answer" value="{{ old('answer', $question->answer) }}" required
                                   placeholder="Typ het correcte antwoord...">
                            @error('answer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Voor multiple choice: typ het exacte antwoord zoals hierboven ingevoerd.<br>
                                Voor open vragen: typ het verwachte antwoord.
                            </small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('questions.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Terug
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle me-1"></i>Wijzigingen Opslaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let optionCount = {{ max(4, count($question->options ?? [])) }};

function toggleOptions() {
    const type = document.getElementById('type').value;
    const optionsSection = document.getElementById('options-section');
    
    if (type === 'multiple_choice') {
        optionsSection.style.display = 'block';
    } else {
        optionsSection.style.display = 'none';
    }
}

function addOption() {
    const container = document.getElementById('options-container');
    const letter = String.fromCharCode(65 + optionCount);
    
    const optionHtml = `
        <div class="input-group mb-2">
            <span class="input-group-text">${letter}</span>
            <input type="text" class="form-control" 
                   name="options[]" 
                   placeholder="Antwoordoptie ${letter}">
            <button type="button" class="btn btn-outline-danger" 
                    onclick="removeOption(this)">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', optionHtml);
    optionCount++;
}

function removeOption(button) {
    button.closest('.input-group').remove();
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleOptions();
});
</script>
@endpush
@endsection
