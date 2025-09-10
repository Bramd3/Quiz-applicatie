@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-question-circle me-2"></i>Vragen Beheer</h2>
                <div>
                    <a href="{{ route('questions.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i>Nieuwe Vraag
                    </a>
                    <a href="{{ route('questions.import') }}" class="btn btn-info ms-2">
                        <i class="bi bi-upload me-1"></i>Import Vragen
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($questions->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="45%">Vraag</th>
                                        <th width="15%">Type</th>
                                        <th width="20%">Antwoord</th>
                                        <th width="15%">Acties</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($questions as $question)
                                        <tr>
                                            <td>{{ $question->id }}</td>
                                            <td>
                                                {{ Str::limit($question->question, 80) }}
                                                @if($question->options)
                                                    <div class="mt-1">
                                                        @foreach($question->options as $option)
                                                            <span class="badge bg-light text-dark me-1">{{ $option }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($question->type === 'multiple_choice')
                                                    <span class="badge bg-info">Multiple Choice</span>
                                                @else
                                                    <span class="badge bg-secondary">Open Vraag</span>
                                                @endif
                                            </td>
                                            <td>
                                                <strong class="text-success">{{ Str::limit($question->answer, 30) }}</strong>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('questions.edit', $question) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('questions.destroy', $question) }}" 
                                                          class="d-inline" onsubmit="return confirm('Weet je zeker dat je deze vraag wilt verwijderen?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $questions->links() }}
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-question-circle display-1 text-muted mb-4"></i>
                        <h4>Nog geen vragen toegevoegd</h4>
                        <p class="text-muted mb-4">Begin met het toevoegen van vragen om je quiz te vullen.</p>
                        <div>
                            <a href="{{ route('questions.create') }}" class="btn btn-success me-2">
                                <i class="bi bi-plus-circle me-1"></i>Eerste Vraag Toevoegen
                            </a>
                            <a href="{{ route('questions.import') }}" class="btn btn-info">
                                <i class="bi bi-upload me-1"></i>Vragen Importeren
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
