<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GrammarTopic;
use App\Models\Lesson;
use App\Models\LessonProgress;
use Illuminate\Support\Facades\Auth;

class GrammarController extends Controller
{
    // Показ всех тем грамматики
    public function index()
    {
        $topics = GrammarTopic::where('is_active', true)
                            ->orderBy('order')
                            ->orderBy('title')
                            ->get();


        return view('grammar.index', compact('topics'));
    }

    // Показ конкретной темы
    public function showTopic($slug)
    {
        $topic = GrammarTopic::where('slug', $slug)->firstOrFail();
        $allTopics = GrammarTopic::where('is_active', true)
                                ->orderBy('order')
                                ->get();

        return view('grammar.topic', compact('topic', 'allTopics'));
    }

    // Показ упражнения для темы
    public function exercise($slug)
    {
        $topic = GrammarTopic::with('exercises')->where('slug', $slug)->firstOrFail();

        return view('grammar.exercise', compact('topic'));
    }

    // Проверка упражнений
    public function checkExercise(Request $request)
    {
        $topic = GrammarTopic::findOrFail($request->topic_id);
        $exercises = $topic->exercises;

        $total = $exercises->count();
        $score = 0;
        $mistakes = [];

        if ($request->answers) {
            foreach ($request->answers as $exerciseId => $userAnswer) {
                $exercise = $exercises->firstWhere('id', $exerciseId);

                if ($exercise && mb_strtolower(trim($userAnswer)) === mb_strtolower(trim($exercise->correct_answer))) {
                    $score++;
                } else {
                    $mistakes[] = [
                        'question' => $exercise ? $exercise->question : 'Вопрос не найден',
                        'user_answer' => trim($userAnswer) ?: '(нет ответа)',
                        'correct_answer' => $exercise ? $exercise->correct_answer : 'Ответ не найден'
                    ];
                }
            }
        }

        $percentage = $total > 0 ? round(($score / $total) * 100) : 0;

        $this->saveGrammarTestResult($topic, $percentage);

        return view('grammar.result', [
            'topic' => $topic,
            'score' => $score,
            'total' => $total,
            'percentage' => $percentage,
            'mistakes' => $mistakes
        ]);
    }

    // метод для сохранения результата теста по грамматике
    private function saveGrammarTestResult($topic, $percentage)
    {
        $studentId = Auth::id();

        $lesson = Lesson::where('topic', $topic->title)
            ->where('type', 'test')
            ->whereHas('curriculum', function($query) use ($studentId) {
                $query->whereHas('class', function($q) use ($studentId) {
                    $q->whereHas('students', function($sq) use ($studentId) {
                        $sq->where('users.id', $studentId);
                    });
                });
            })
            ->first();

        if ($lesson) {
            $progress = LessonProgress::where('lesson_id', $lesson->id)
                ->where('student_id', $studentId)
                ->first();

            if ($progress && $progress->status != 'completed') {
                $progress->complete($percentage);
            } elseif (!$progress) {
                LessonProgress::create([
                    'lesson_id' => $lesson->id,
                    'student_id' => $studentId,
                    'status' => 'completed',
                    'score' => $percentage,
                    'completed_at' => now()
                ]);
            }
        }
    }
}