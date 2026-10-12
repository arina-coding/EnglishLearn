<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Curriculum;
use App\Models\LessonProgress;
use App\Models\Lesson;

class CurriculumController extends Controller
{
    // Главная страница студента
    public function index()
    {
        $student = Auth::user();

        $curricula = Curriculum::whereIn('class_id', $student->classes()->pluck('classes.id'))
            ->where('status', 'active')
            ->with(['lessons' => function($query) {
                $query->orderBy('due_date')->orderBy('order');
            }])
            ->get();

        $todaysLessons = [];
        $weeklyLessons = [];
        $overdueLessons = [];

        foreach ($curricula as $curriculum) {
            foreach ($curriculum->lessons as $lesson) {
                $progress = $lesson->studentProgress($student->id);
                $isCompleted = $progress && $progress->status == 'completed';

                if ($isCompleted) {
                    continue;
                }

                $lessonData = [
                    'id' => $lesson->id,
                    'title' => $lesson->topic,
                    'type' => $lesson->type,
                    'due_date' => $lesson->due_date,
                    'completed' => $isCompleted,
                    'score' => $progress ? $progress->score : null,
                    'info' => $lesson->getTopicInfo(),
                    'curriculum_title' => $curriculum->title
                ];

                if ($lesson->due_date < today()) {
                    $overdueLessons[] = $lessonData;
                }
                elseif ($lesson->due_date == today()) {
                    $todaysLessons[] = $lessonData;
                }
                elseif ($lesson->due_date > today() && $lesson->due_date <= today()->addDays(7)) {
                    $weeklyLessons[] = $lessonData;
                }
            }
        }

        $stats = $this->getStudentStats($student);

        return view('student.tasks', compact('todaysLessons', 'weeklyLessons', 'overdueLessons', 'stats'));
    }



    // Получить статистику студента
    private function getStudentStats($student)
    {
        $completedLessons = LessonProgress::where('student_id', $student->id)
            ->where('status', 'completed')
            ->count();

        $totalLessons = 0;
        $curricula = Curriculum::whereIn('class_id', $student->classes()->pluck('classes.id'))
            ->where('status', 'active')
            ->with('lessons')
            ->get();

        foreach ($curricula as $curriculum) {
            $totalLessons += $curriculum->lessons->count();
        }

        $avgScore = LessonProgress::where('student_id', $student->id)
            ->whereNotNull('score')
            ->avg('score');

        return [
            'completed_lessons' => $completedLessons,
            'total_lessons' => $totalLessons,
            'completion_percentage' => $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0,
            'avg_score' => round($avgScore ?? 0),
            'streak' => $student->current_streak ?? 0
        ];
    }
}