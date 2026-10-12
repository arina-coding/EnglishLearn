<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LessonProgress;
use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\UserProgress;
use Illuminate\Support\Facades\Auth;

class WordController extends Controller
{
    // Показ всех слов по темам
    public function index()
    {
        $topics = Word::select('topic')->distinct()->get();
        $words = Word::all();

        return view('words.index', compact('topics', 'words'));
    }

    // Показ слов определенной темы
    public function showTopic($topic)
    {
        $words = Word::where('topic', $topic)->get();
        $topics = Word::select('topic')->distinct()->get();

        return view('words.topic', compact('words', 'topics', 'topic'));
    }


    // Тест на проверку знаний
    public function test($topic)
    {
        $words = Word::where('topic', $topic)->inRandomOrder()->limit(10)->get();
        return view('words.test', compact('words', 'topic'));
    }

    // Проверка ответов теста с обновлением прогресса
    public function checkTest(Request $request)
    {
        $topic = $request->topic;
        $answers = $request->answers ?? [];
        $total = count($answers);
        $score = 0;
        $mistakes = [];

        foreach ($answers as $wordId => $userAnswer) {
            $word = Word::find($wordId);
            $isCorrect = false;

            if (mb_strtolower(trim($userAnswer)) === mb_strtolower(trim($word->english))) {
                $score++;
                $isCorrect = true;
            } else {
                $mistakes[] = [
                    'word' => $word,
                    'user_answer' => trim($userAnswer),
                    'correct_answer' => $word->english,
                    'russian' => $word->russian
                ];
            }

            if (Auth::check()) {
                UserProgress::updateProgress(Auth::id(), $wordId, $isCorrect);
            }
        }

        $percentage = $total > 0 ? round(($score / $total) * 100) : 0;

        $this->saveTestResult($topic, $percentage);

        return view('words.result', compact('score', 'total', 'mistakes', 'topic', 'percentage'));
    }

    // сохранения результата теста
    private function saveTestResult($topic, $percentage)
    {
        $studentId = Auth::id();

        $lesson = Lesson::where('topic', $topic)
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