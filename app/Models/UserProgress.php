<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    use HasFactory;

    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'word_id',
        'correct_answers',
        'total_attempts',
        'learned',
        'last_practiced_at'
    ];

    protected $casts = [
        'learned' => 'boolean',
        'last_practiced_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function word()
    {
        return $this->belongsTo(Word::class);
    }

    public static function updateProgress($userId, $wordId, $isCorrect)
    {
        $progress = self::firstOrCreate(
            ['user_id' => $userId, 'word_id' => $wordId],
            ['correct_answers' => 0, 'total_attempts' => 0]
        );

        $progress->total_attempts++;
        if ($isCorrect) {
            $progress->correct_answers++;
        }

        if ($progress->correct_answers >= 3) {
            $progress->learned = true;
        }

        $progress->last_practiced_at = now();
        $progress->save();

        return $progress;
    }
}