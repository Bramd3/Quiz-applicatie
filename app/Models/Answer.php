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

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    /**
     * Check if this answer has been submitted
     */
    public function isSubmitted()
    {
        return !is_null($this->student_answer);
    }

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
