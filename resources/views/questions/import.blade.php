@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0"><i class="bi bi-upload me-2"></i>Vragen Importeren</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="bi bi-info-circle me-2"></i>Ondersteunde formaten:</h6>
                        <ul class="mb-0">
                            <li><strong>JSON:</strong> Gestructureerde data met vraag, type, opties en antwoord</li>
                            <li><strong>CSV:</strong> Komma-gescheiden waarden met headers</li>
                        </ul>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h6>Er zijn fouten opgetreden:</h6>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('questions.import.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="file" class="form-label">Selecteer bestand</label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                   id="file" name="file" accept=".json,.csv,.txt" required>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('questions.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Terug
                            </a>
                            <button type="submit" class="btn btn-info">
                                <i class="bi bi-upload me-1"></i>Importeren
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Format Examples -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bi bi-filetype-csv me-2"></i>CSV Formaat</h6>
                        </div>
                        <div class="card-body">
                            <h6>Nieuwe formaat (aanbevolen):</h6>
                            <pre class="small bg-light p-2 rounded">question,type,answer,option_1,option_2,option_3,option_4
"Wat is 2+2?",multiple_choice,"4","2","4","6","8"
"Hoofdstad Nederland?",open,"Amsterdam"</pre>
                            
                            <h6 class="mt-3">Oude formaat (nog ondersteund):</h6>
                            <pre class="small bg-light p-2 rounded">question,correct_answer,answer_a,answer_b,answer_c
"Wat is 2+2?",b,"2","4","6"
"Multiple choice vraag",a,"Juist","Fout","Misschien"</pre>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="bi bi-filetype-json me-2"></i>JSON Formaat</h6>
                        </div>
                        <div class="card-body">
                            <pre class="small bg-light p-2 rounded">[
  {
    "question": "Wat is 2+2?",
    "type": "multiple_choice",
    "options": ["2", "4", "6", "8"],
    "answer": "4"
  },
  {
    "question": "Hoofdstad van Nederland?",
    "type": "open",
    "answer": "Amsterdam"
  }
]</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
