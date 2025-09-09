<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    /**
     * Upload en import vragen via JSON of CSV
     */
   public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:csv,txt'
    ]);

    $file = $request->file('file');
    $path = $file->getRealPath();

    $questions = [];

    $handle = fopen($path, 'r');
    $header = fgetcsv($handle, 1000, ';'); // LET OP: puntkomma als delimiter

    while (($row = fgetcsv($handle, 1000, ';')) !== false) {
        $rowData = array_combine($header, $row);

        // Bouw de opties-array uit de kolommen answer_a, answer_b, answer_c
        $options = [];
        if (!empty($rowData['answer_a'])) $options[] = $rowData['answer_a'];
        if (!empty($rowData['answer_b'])) $options[] = $rowData['answer_b'];
        if (!empty($rowData['answer_c'])) $options[] = $rowData['answer_c'];

        // correct_answer is a/b/c -> vertaal naar juiste optie
        $correct = null;
        if (strtolower($rowData['correct_answer']) === 'a') $correct = $rowData['answer_a'];
        if (strtolower($rowData['correct_answer']) === 'b') $correct = $rowData['answer_b'];
        if (strtolower($rowData['correct_answer']) === 'c') $correct = $rowData['answer_c'];

        $questions[] = [
            'question' => $rowData['question'],
            'type'     => 'multiple_choice',
            'options'  => json_encode($options),
            'answer'   => $correct,
        ];
    }
    fclose($handle);

    foreach ($questions as $q) {
        \App\Models\Question::create($q);
    }

    return back()->with('success', 'Vragen succesvol geïmporteerd!');
}


}
