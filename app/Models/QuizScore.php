<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizScore extends Model
{
    protected $fillable = [
        'name',
        'email',
        'user_id',
        'score',
        'correct_answers',
        'difficulty',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
