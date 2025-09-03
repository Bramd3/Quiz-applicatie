<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'score',
    ];

    // Een test hoort bij een student (user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Een test bevat meerdere antwoorden
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
