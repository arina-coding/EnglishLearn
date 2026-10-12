<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'city',
    'school',
    'description',
    'last_login_at',
    'login_streak',
    'current_streak'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'class_student', 'student_id', 'class_id');
    }

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function isStudent()
    {
        return $this->role === 'student' || !$this->role;
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'role' => 'string'
        ];
    }

    // Прогресс
    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }

    // Выученные слова
    public function learnedWords()
    {
        return $this->belongsToMany(Word::class, 'user_progress')
                    ->wherePivot('learned', true)
                    ->withTimestamps();
    }

    // Статистика
    // Аксессор - метод который преобразует значение атрибута при его получении. Позволяет обращаться к вычисленным данным как к обычному свойству(без скобок)
    // get{ИмяПоля}Attribute()

public function getStatsAttribute()
{
    $learnedWords = $this->learnedWords()->count();
    $totalAttempts = $this->progress()->sum('total_attempts');
    $correctAnswers = $this->progress()->sum('correct_answers');
    $accuracy = $totalAttempts > 0 ? round(($correctAnswers / $totalAttempts) * 100) : 0;

    $grammarTopics = \App\Models\GrammarTopic::pluck('title')->toArray();

    $completedGrammarTests = LessonProgress::where('student_id', $this->id)
        ->where('status', 'completed')
        ->whereHas('lesson', function($query) use ($grammarTopics) {
            $query->whereIn('topic', $grammarTopics);
        })
        ->count();

    $averageGrammarScore = LessonProgress::where('student_id', $this->id)
        ->where('status', 'completed')
        ->whereNotNull('score')
        ->whereHas('lesson', function($query) use ($grammarTopics) {
            $query->whereIn('topic', $grammarTopics);
        })
        ->avg('score');
    $averageGrammarScore = round($averageGrammarScore ?? 0);

    // Текущая серия
    $currentStreak = $this->current_streak ?? 0;

    return [
        // Слова
        'learned_words' => $learnedWords,
        'total_attempts' => $totalAttempts,
        'correct_answers' => $correctAnswers,
        'accuracy' => $accuracy,
        'total_words' => \App\Models\Word::count(),

        // Тесты по грамматике
        'completed_grammar_tests' => $completedGrammarTests,
        'average_grammar_score' => $averageGrammarScore,

        // Серия
        'login_streak' => $currentStreak,
    ];
}

    // Прогресс по темам
    public function getTopicProgress()
    {
        $allTopics = \App\Models\Word::select('topic')->distinct()->get();
        $progress = [];

        foreach ($allTopics as $topic) {
            $topicName = $topic->topic;
            $totalWords = \App\Models\Word::where('topic', $topicName)->count();

            if ($totalWords > 0) {
                $learnedWords = $this->learnedWords()
                    ->where('topic', $topicName)
                    ->count();

                $percentage = round(($learnedWords / $totalWords) * 100);

                $progress[$topicName] = [
                    'total' => $totalWords,
                    'learned' => $learnedWords,
                    'percentage' => $percentage
                ];
            }
        }

        return $progress;
    }

    // Недавняя активность
    public function getRecentActivity($limit = 5)
    {
        return $this->progress()
            ->with(['word' => function($query) {
                $query->select('id', 'english', 'russian', 'topic');
            }])
            ->orderBy('last_practiced_at', 'desc')
            ->limit($limit)
            ->get();
    }

    // Обновление серии при входе
    public function updateLoginStreak()
    {
        $now = now();

        if (!$this->last_login_at) {
            $this->current_streak = 1;
            $this->last_login_at = $now;
            $this->save();
            return;
        }

        $lastLogin = $this->last_login_at;
        if (is_string($lastLogin)) {
            $lastLogin = \Carbon\Carbon::parse($lastLogin);
        }

        $yesterday = $now->copy()->subDay();

        if ($lastLogin->format('Y-m-d') === $yesterday->format('Y-m-d')) {
            $this->current_streak = ($this->current_streak ?? 0) + 1;
        }
        elseif ($lastLogin->format('Y-m-d') !== $now->format('Y-m-d')) {
            if ($lastLogin->diffInDays($now) > 1) {
                $this->current_streak = 1;
            }
        }

        $this->last_login_at = $now;
        $this->save();
    }


    }