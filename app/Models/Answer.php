<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'question_id',
        'student_answer',
        'is_correct',
    ];

    // Antwoord hoort bij een test
    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    // Antwoord hoort bij een vraag
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
