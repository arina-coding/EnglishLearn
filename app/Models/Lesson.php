<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'curriculum_id',
        'type',
        'topic',
        'slug',
        'due_date',
        'order',
        'status'
    ];

    protected $casts = [
        'due_date' => 'date'
    ];

    // Отношения
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function progress()
    {
        return $this->hasMany(LessonProgress::class);
    }

    // Получить прогресс конкретного студента
    public function studentProgress($studentId)
    {
        return $this->progress()->where('student_id', $studentId)->first();
    }

    // Получить информацию о теме (словарь или грамматика)
    public function getTopicInfo()
    {
        if ($this->type == 'vocabulary') {
            $words = Word::where('topic', $this->topic)->get();
            return [
                'title' => $this->topic,
                'description' => "Изучите слова по теме \"" . $this->topic . "\"",
                'words_count' => $words->count(),
                'route' => route('vocabulary.topic', $this->topic),
                'test_route' => route('test', $this->topic)
            ];
        } elseif ($this->type == 'grammar') {
            $topic = GrammarTopic::where('slug', $this->slug)->first();
            return [
                'title' => $topic ? $topic->title : $this->topic,
                'description' => $topic ? $topic->introduction : "Изучите тему \"" . $this->topic . "\"",
                'route' => route('grammar.topic', $this->slug),
                'test_route' => route('grammar.exercise', $this->slug)
            ];
        } elseif ($this->type == 'test') {
            $vocabularyTopic = Word::where('topic', $this->topic)->exists();
            $grammarTopic = GrammarTopic::where('title', $this->topic)->first();

            if ($vocabularyTopic) {
                return [
                    'title' => "Тест: " . $this->topic,
                    'description' => "Проверьте свои знания по теме \"" . $this->topic . "\"",
                    'test_route' => route('test', $this->topic)
                ];
            } elseif ($grammarTopic) {
                return [
                    'title' => "Тест: " . $this->topic,
                    'description' => "Проверьте свои знания по теме \"" . $this->topic . "\"",
                    'test_route' => route('grammar.exercise', $grammarTopic->slug)
                ];
            }
        }
        return null;
    }
}