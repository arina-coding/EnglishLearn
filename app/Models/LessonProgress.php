<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'student_id',
        'status',
        'score',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime'
    ];

    // Отношения
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Отметить как выполненное
    public function complete($score = null)
    {
        $this->status = 'completed';
        $this->score = $score;
        $this->completed_at = now();
        $this->save();
    }
}