<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;// фасад для работы с аутентификации
use App\Models\Word;
use App\Models\UserProgress;
use App\Models\Curriculum;
use App\Models\LessonProgress;

class DashboardController extends Controller
{
    // Показывает личный кабинет студента
    public function index()
    {
        $user = Auth::user(); // получаем текущего зарегистрированного пользователя
        $stats = $user->stats;// Получаем статистику через модель (отношение в модели User)
        $topicProgress = $this->getTopicProgress($user); // из текущего объекта контроллера получаем прогресс по темам
        $recentActivity = $this->getRecentActivity($user);//из текущего объекта контроллера получаем недавнюю активность
        $upcomingLessons = $this->getUpcomingLessons($user);//ближайшие задания для студента
        return view('dashboard', compact('stats', 'topicProgress', 'recentActivity', 'upcomingLessons'));// view загружает blade-шаблоны. compact создает массив данных. Передаем переменный в шаблон где можно их использовать
    }

    // Вычисляет прогресс пользователя по всем темам
    private function getTopicProgress($user)//метод доступен только внутри этого класса, другой контроллер не может его вызвать
    {
        $topicProgress = [];// создаем пустой массив
        $allTopics = Word::select('topic')->distinct()->get(); //1) select- выбрать отдельный столбец. 2) distinct- убрать дубликаты. 3) get- выполняет запрос и возвращает коллекцию объектов
        // SELECT DISTINCT `topic` FROM `words`;

        foreach ($allTopics as $topic) { // цикл повториться столько раз сколько уникальных тем в словаре. на каждую итерацию в переменную $topic попадет 1 объект темы
            $topicName = $topic->topic;// строковое название темы. н-р family
            $totalWords = Word::where('topic', $topicName)->count();//сколько слов в текущей теме
            //SELECT COUNT(*) FROM words WHERE topic = 'family';

            if ($totalWords > 0) {// если есть хотя бы одно, то:
                $learnedWords = UserProgress::where('user_id', $user->id)//записи, у которых user_id = id текущего пользователя
                    ->where('learned', true)// у которых learned = true
                    ->whereHas('word', function($query) use ($topicName) {//'word'-метод в модели UserProgress. function($query)- функция где описываются условия для связанной таблицы
                        $query->where('topic', $topicName);// оставить только те записи, где topic="family"
                    })
                    ->count();// возваращает кол-во запесей
                        //SELECT COUNT(*)
                        // FROM user_progress
                        // WHERE user_id = 5
                        //   AND learned = 1
                        //   AND word_id IN (
                        // SELECT id FROM words WHERE topic = 'family')

                // % выученных слов в теме
                $percentage = round(($learnedWords / $totalWords) * 100);// round()- округление

                $topicProgress[$topicName] = [// сохраняем данные в массив для шаблона
                    'total' => $totalWords,
                    'learned' => $learnedWords,
                    'percentage' => $percentage
                ];
            }
        }

        return $topicProgress;// возвращает в index()
    }

    // Получает последние 5 активностей пользователя
    private function getRecentActivity($user)
    {
        return UserProgress::where('user_id', $user->id)
            ->with(['word' => function($query) {
                $query->select('id', 'english', 'russian', 'topic');
            }])
            ->orderBy('last_practiced_at', 'desc')
            ->limit(5)
            ->get();
    }

    // Получает ближайшие задания для студента
    private function getUpcomingLessons($user)
    {
        $upcomingLessons = [];

        $studentClasses = $user->classes()->pluck('classes.id')->toArray();

        if (!empty($studentClasses)) {
            $curricula = Curriculum::whereIn('class_id', $studentClasses)
                ->where('status', 'active')
                ->get();

            foreach ($curricula as $curriculum) {
                foreach ($curriculum->lessons as $lesson) {
                    $progress = LessonProgress::where('lesson_id', $lesson->id)
                        ->where('student_id', $user->id)
                        ->first();

                    if (!$progress || $progress->status != 'completed') {
                        $info = $lesson->getTopicInfo();
                        if ($info && isset($info['test_route'])) {
                            $upcomingLessons[] = [
                                'id' => $lesson->id,
                                'title' => $lesson->topic,
                                'type' => $lesson->type,
                                'due_date' => $lesson->due_date,
                                'info' => $info
                            ];
                        }
                    }
                }
            }

            usort($upcomingLessons, function($a, $b) {
                return strtotime($a['due_date']) - strtotime($b['due_date']);
            });

            $upcomingLessons = array_slice($upcomingLessons, 0, 3);
        }

        return $upcomingLessons;
    }
}

