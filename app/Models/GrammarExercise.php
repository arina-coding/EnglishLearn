<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrammarExercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'grammar_topic_id',
        'question',
        'options',
        'correct_answer',
        'type',
        'order'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public function topic()
    {
        return $this->belongsTo(GrammarTopic::class, 'grammar_topic_id');
    }
}