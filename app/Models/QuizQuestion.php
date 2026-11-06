<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = [
        'difficulty',
        'question',
        'choices',
        'answer_index',
        'explanation',
    ];

    protected function casts(): array
    {
        return [
            'choices' => 'array',
            'answer_index' => 'integer',
        ];
    }
}
