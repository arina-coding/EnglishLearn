<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\LessonProgress;
use Illuminate\Http\Request;// метод для работы с http запросами
use Illuminate\Support\Facades\Auth;// фасад для работы с аутентификацией
use App\Models\User;
use App\Models\Word;
use App\Models\UserProgress;

class DashboardController extends Controller
{
    // Личный кабинет учителя
    public function index()
    {
        $teacher = Auth::user();// текущий авторизованный пользователь

        // Получаем все классы учителя
        $classes = Classes::where('teacher_id', $teacher->id)->with('students')->get();

        // Общее количество студентов во всех классах учителя
        $totalStudents = 0;
        $totalClasses = $classes->count();
        $totalCompletedTasks = 0;
        $activeStudents = 0;

        foreach ($classes as $class) {
            $studentsCount = $class->students->count();
            $totalStudents += $studentsCount;

            // Считаем активных студентов (заходили за последние 7 дней)
            $activeInClass = $class->students->filter(function($student) {
                return $student->last_login_at && \Carbon\Carbon::parse($student->last_login_at)->diffInDays(now()) <= 7;
            })->count();
            $activeStudents += $activeInClass;

            // Считаем выполненные задания по всем учебным планам класса
            foreach ($class->curricula as $curriculum) {
                foreach ($curriculum->lessons as $lesson) {
                    $completedCount = LessonProgress::where('lesson_id', $lesson->id)
                        ->where('status', 'completed')
                        ->count();
                    $totalCompletedTasks += $completedCount;
                }
            }
        }

        // Средняя успеваемость по всем тестам
        $avgScore = LessonProgress::where('status', 'completed')
            ->whereNotNull('score')
            ->avg('score');

        $avgScore = round($avgScore ?? 0);

        $stats = [
            'total_students' => $totalStudents,
            'active_students' => $activeStudents,
            'total_classes' => $totalClasses,
            'completed_tasks' => $totalCompletedTasks,
            'avg_score' => $avgScore
        ];

        // Получаем недавнюю активность
        $recentActivity = $this->getRecentActivity($teacher);

        // Получаем студентов с прогрессом (только из классов учителя)
        $studentIds = [];
        foreach ($classes as $class) {
            foreach ($class->students as $student) {
                $studentIds[$student->id] = $student->id;
            }
        }

        $students = User::whereIn('id', $studentIds)->get();

        $studentsData = [];
        foreach ($students as $student) {
            // Выученные слова студента
            $learnedWords = UserProgress::where('user_id', $student->id)
                ->where('learned', true)
                ->count();

            // Слов всего
            $totalWords = Word::count();

            $totalAttempts = UserProgress::where('user_id', $student->id)->sum('total_attempts');// суммирует все попытки ввести правильное слово
            $correctAnswers = UserProgress::where('user_id', $student->id)->sum('correct_answers');// суммирует правильные ответы

            $accuracy = 0;// точность
            if ($totalAttempts > 0) {// если попытки ответов были, то: вычисляем точность в %
                $accuracy = round(($correctAnswers / $totalAttempts) * 100);// round()- округление
            }

            $lastLoginAt = $student->last_login_at;// берем значения из крайнего входа

            $lastLoginFormatted = null;// готовая к выводу дата

            if ($lastLoginAt) {// если дата есть:
                try { // блок в котором отслеживаются возможные исключения
                    if (is_string($lastLoginAt)) {// если является строкой:
                        $lastLoginAt = \Carbon\Carbon::parse($lastLoginAt);// преобразуем в объект
                    }
                    $lastLoginFormatted = $lastLoginAt;// копирует значение $lastLoginAt(теперь это объект Carbon)
                } catch (\Exception $e) {// если при обработке возникла ошибка.
                // Exception- базовый класс всех ошибок.
                // $e- имя переменной в которую попадет объект ошибки.
                    $lastLoginFormatted = null;// действие при ошибке
                }
            }

            $studentsData[] = (object) [// превращаем массив в объект и кладем данные
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
                'last_login_at' => $lastLoginFormatted,
                'learned_words_count' => $learnedWords,
                'accuracy' => $accuracy,
                'total_words' => $totalWords
            ];
        }

        return view('teacher.dashboard', [
            'teacher' => $teacher,
            'students' => $studentsData,
            'stats' => $stats,
            'recentActivity' => $recentActivity
        ]);
    }

    // Просмотр профиля студента
    public function showStudent($id)
    {
        $student = User::where('id', $id)->where('role', 'student')->firstOrFail();// ищем студента
        // select * from users where id=6 and role='student' limit 1

        // количество изученных слов студента
        $learnedWords = UserProgress::where('user_id', $student->id)
            ->where('learned', true)
            ->count();
        //select count(*) from user_progress where user_id=6 and learned=1

        $totalWords = Word::count();// общее кол-во слов

        $totalAttempts = UserProgress::where('user_id', $student->id)->sum('total_attempts');
        $correctAnswers = UserProgress::where('user_id', $student->id)->sum('correct_answers');
        $accuracy = $totalAttempts > 0 ? round(($correctAnswers / $totalAttempts) * 100) : 0;

        $progress = [
            'learned_words' => $learnedWords,
            'accuracy' => $accuracy,
            'login_streak' => $student->current_streak ?? 0,
            'total_words' => $totalWords,
            'percentage' => $totalWords > 0 ? round(($learnedWords / $totalWords) * 100) : 0// % изучения словаря
        ];

        // Получаем реальную активность студента
        $recentActivity = $student->getRecentActivity(10);

        return view('teacher.student', compact('student', 'progress', 'recentActivity'));
    }

    // Получает недавнюю активность студентов учителя
    private function getRecentActivity($teacher)
    {
        $classes = Classes::where('teacher_id', $teacher->id)->with('students')->get();

        $studentIds = [];
        foreach ($classes as $class) {
            foreach ($class->students as $student) {
                $studentIds[] = $student->id;
            }
        }
        $studentIds = array_unique($studentIds);

        if (empty($studentIds)) {
            return collect([]);
        }

        $activities = [];

        $completedTests = LessonProgress::whereIn('student_id', $studentIds)
            ->where('status', 'completed')
            ->with(['student', 'lesson'])
            ->orderBy('completed_at', 'desc')
            ->limit(10)
            ->get();

        foreach ($completedTests as $test) {
            $activities[] = (object) [
                'type' => 'test',
                'student_name' => $test->student->name,
                'student_id' => $test->student->id,
                'title' => $test->lesson->topic,
                'score' => $test->score,
                'created_at' => $test->completed_at,
                'icon' => 'bi-pencil-square',
                'icon_color' => 'text-primary'
            ];
        }

        $learnedWords = UserProgress::whereIn('user_id', $studentIds)
            ->where('learned', true)
            ->with(['user', 'word'])
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        foreach ($learnedWords as $word) {
            $activities[] = (object) [
                'type' => 'word',
                'student_name' => $word->user->name,
                'student_id' => $word->user->id,
                'title' => $word->word->english . ' - ' . $word->word->russian,
                'topic' => $word->word->topic,
                'created_at' => $word->updated_at,
                'icon' => 'bi-book',
                'icon_color' => 'text-success'
            ];
        }

        $classStudent = \Illuminate\Support\Facades\DB::table('class_student')
            ->whereIn('student_id', $studentIds)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        foreach ($classStudent as $cs) {
            $student = User::find($cs->student_id);
            if ($student) {
                $activities[] = (object) [
                    'type' => 'join',
                    'student_name' => $student->name,
                    'student_id' => $student->id,
                    'title' => 'Присоединился к классу',
                    'created_at' => \Carbon\Carbon::parse($cs->created_at),
                    'icon' => 'bi-person-plus',
                    'icon_color' => 'text-warning'
                ];
            }
        }

        $recentLogins = User::whereIn('id', $studentIds)
            ->whereNotNull('last_login_at')
            ->orderBy('last_login_at', 'desc')
            ->limit(5)
            ->get();

        foreach ($recentLogins as $login) {
            $activities[] = (object) [
                'type' => 'login',
                'student_name' => $login->name,
                'student_id' => $login->id,
                'title' => 'Зашел в систему',
                'created_at' => $login->last_login_at,
                'icon' => 'bi-box-arrow-in-right',
                'icon_color' => 'text-info'
            ];
        }

        usort($activities, function($a, $b) {
            return strtotime($b->created_at) - strtotime($a->created_at);
        });

        return collect(array_slice($activities, 0, 10));
    }


}