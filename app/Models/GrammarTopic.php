<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrammarTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'theory',
        'examples',
        'exercise_question',
        'exercise_options',
        'correct_answer',
        'level',
        'order',
        'is_active'
    ];

    protected $casts = [
        'exercise_options' => 'array',
        'is_active' => 'boolean'
    ];

    public function exercises()
{
    return $this->hasMany(GrammarExercise::class)->orderBy('order');
}
}
