<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'type',
        'options',
        'answer',
    ];

    protected $casts = [
        'options' => 'array', // zorgt dat JSON automatisch array wordt
    ];

    // Een vraag kan meerdere antwoorden van studenten hebben
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
