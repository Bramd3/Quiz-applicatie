<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class QuestionController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of questions for teachers
     */
    public function index()
    {
        $this->authorize('teacher');
        $questions = Question::paginate(15);
        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new question
     */
    public function create()
    {
        $this->authorize('teacher');
        return view('questions.create');
    }

    /**
     * Store a newly created question
     */
    public function store(Request $request)
    {
        $this->authorize('teacher');
        
        $request->validate([
            'question' => 'required|string|max:1000',
            'type' => 'required|in:multiple_choice,open',
            'answer' => 'required|string|max:500',
            'options' => 'array|nullable',
            'options.*' => 'string|max:200'
        ]);

        Question::create([
            'question' => $request->question,
            'type' => $request->type,
            'options' => $request->type === 'multiple_choice' ? $request->options : null,
            'answer' => $request->answer,
        ]);

        return redirect()->route('questions.index')
            ->with('success', 'Vraag succesvol toegevoegd!');
    }

    /**
     * Show the form for editing the specified question
     */
    public function edit(Question $question)
    {
        $this->authorize('teacher');
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified question
     */
    public function update(Request $request, Question $question)
    {
        $this->authorize('teacher');
        
        $request->validate([
            'question' => 'required|string|max:1000',
            'type' => 'required|in:multiple_choice,open',
            'answer' => 'required|string|max:500',
            'options' => 'array|nullable',
            'options.*' => 'string|max:200'
        ]);

        $question->update([
            'question' => $request->question,
            'type' => $request->type,
            'options' => $request->type === 'multiple_choice' ? $request->options : null,
            'answer' => $request->answer,
        ]);

        return redirect()->route('questions.index')
            ->with('success', 'Vraag succesvol bijgewerkt!');
    }

    /**
     * Remove the specified question
     */
    public function destroy(Question $question)
    {
        $this->authorize('teacher');
        
        $question->delete();
        
        return redirect()->route('questions.index')
            ->with('success', 'Vraag succesvol verwijderd!');
    }

    /**
     * Show import form
     */
    public function importForm()
    {
        $this->authorize('teacher');
        return view('questions.import');
    }

    /**
     * Upload en import vragen via JSON of CSV
     */
    public function import(Request $request)
    {
        $this->authorize('teacher');
        
        $request->validate([
            'file' => 'required|mimes:csv,txt,json'
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $extension = $file->getClientOriginalExtension();

        $questions = [];

        try {
            if ($extension === 'json') {
                $questions = $this->importJson($path);
            } else {
                $questions = $this->importCsv($path);
            }

            foreach ($questions as $q) {
                Question::create($q);
            }

            return redirect()->route('questions.index')
                ->with('success', count($questions) . ' vragen succesvol geïmporteerd!');
                
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Fout bij importeren: ' . $e->getMessage()]);
        }
    }

    /**
     * Import questions from JSON file
     */
    private function importJson($path)
    {
        $content = file_get_contents($path);
        $data = json_decode($content, true);
        
        if (!$data || !is_array($data)) {
            throw new \Exception('Ongeldig JSON formaat');
        }

        $questions = [];
        
        foreach ($data as $item) {
            if (!isset($item['question']) || !isset($item['answer'])) {
                continue;
            }
            
            $type = $item['type'] ?? 'open';
            $options = null;
            
            if ($type === 'multiple_choice' && isset($item['options'])) {
                $options = $item['options'];
            }
            
            $questions[] = [
                'question' => $item['question'],
                'type' => $type,
                'options' => $options,
                'answer' => $item['answer'],
            ];
        }
        
        return $questions;
    }

    /**
     * Import questions from CSV file
     */
    private function importCsv($path)
    {
        $questions = [];
        $handle = fopen($path, 'r');
        
        if (!$handle) {
            throw new \Exception('Kan bestand niet openen');
        }
        
        $header = fgetcsv($handle, 1000, ';');
        
        if (!$header) {
            fclose($handle);
            throw new \Exception('Ongeldig CSV formaat - geen header gevonden');
        }

        while (($row = fgetcsv($handle, 1000, ';')) !== false) {
            if (count($row) !== count($header)) {
                continue; // Skip invalid rows
            }
            
            $rowData = array_combine($header, $row);

            // Support both old format and new format
            if (isset($rowData['question']) && isset($rowData['answer'])) {
                // New simple format
                $type = $rowData['type'] ?? 'open';
                $options = null;
                
                if ($type === 'multiple_choice') {
                    $options = [];
                    for ($i = 1; $i <= 4; $i++) {
                        $optionKey = 'option_' . $i;
                        if (isset($rowData[$optionKey]) && !empty($rowData[$optionKey])) {
                            $options[] = $rowData[$optionKey];
                        }
                    }
                }
                
                $questions[] = [
                    'question' => $rowData['question'],
                    'type' => $type,
                    'options' => $options,
                    'answer' => $rowData['answer'],
                ];
            } else if (isset($rowData['question']) && isset($rowData['correct_answer'])) {
                // Old format with answer_a, answer_b, etc.
                $options = [];
                if (!empty($rowData['answer_a'])) $options[] = $rowData['answer_a'];
                if (!empty($rowData['answer_b'])) $options[] = $rowData['answer_b'];
                if (!empty($rowData['answer_c'])) $options[] = $rowData['answer_c'];
                if (!empty($rowData['answer_d'])) $options[] = $rowData['answer_d'];

                $correct = null;
                $correctLetter = strtolower($rowData['correct_answer']);
                if ($correctLetter === 'a' && isset($rowData['answer_a'])) $correct = $rowData['answer_a'];
                if ($correctLetter === 'b' && isset($rowData['answer_b'])) $correct = $rowData['answer_b'];
                if ($correctLetter === 'c' && isset($rowData['answer_c'])) $correct = $rowData['answer_c'];
                if ($correctLetter === 'd' && isset($rowData['answer_d'])) $correct = $rowData['answer_d'];

                if ($correct) {
                    $questions[] = [
                        'question' => $rowData['question'],
                        'type' => 'multiple_choice',
                        'options' => $options,
                        'answer' => $correct,
                    ];
                }
            }
        }
        
        fclose($handle);
        return $questions;
    }


}
