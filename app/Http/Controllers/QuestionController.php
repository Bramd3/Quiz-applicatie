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
        'file' => 'required|mimes:json,csv,txt'
    ]);

    $file = $request->file('file');
    $extension = strtolower($file->getClientOriginalExtension());
    $path = $file->getRealPath();

    $questions = [];

    if ($extension === 'json') {
        $data = json_decode(file_get_contents($path), true);
        foreach ($data as $row) {
            $questions[] = [
                'question' => $row['question'] ?? null,
                'type'     => $row['type'] ?? null,
                'options'  => isset($row['options']) ? json_encode($row['options']) : null,
                'answer'   => $row['answer'] ?? null,
            ];
        }
    } elseif ($extension === 'csv') {
        $handle = fopen($path, 'r');
        $header = fgetcsv($handle, 1000, ',');
        $header = array_map(fn($h) => strtolower(trim($h)), $header); // lowercase & trim

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            if (count($row) !== count($header)) {
                continue; // skip verkeerde rijen
            }

            $rowData = array_combine($header, $row);

            $questions[] = [
                'question' => $rowData['question'] ?? $rowData['vraag'] ?? null,
                'type'     => $rowData['type'] ?? $rowData['soort'] ?? null,
                'options'  => !empty($rowData['options'] ?? $rowData['opties'] ?? null)
                                ? json_encode(explode('|', $rowData['options'] ?? $rowData['opties']))
                                : null,
                'answer'   => $rowData['answer'] ?? $rowData['antwoord'] ?? null,
            ];
        }
        fclose($handle);
    }

    foreach ($questions as $q) {
        if (!empty($q['question']) && !empty($q['type'])) {
            Question::create($q);
        }
    }

    return back()->with('success', 'Vragen succesvol geïmporteerd!');
}

}
