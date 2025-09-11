<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    // Alle resultaten van de ingelogde leerling
    public function myResults()
    {
        $results = Result::where('user_id', Auth::id())->latest()->get();
        return view('results.my', compact('results'));
    }
}
