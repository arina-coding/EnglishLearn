<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Classes;
use App\Models\Curriculum;
use App\Models\Lesson;
use App\Models\Word;
use App\Models\GrammarTopic;

class CurriculumController extends Controller
{
    // Список учебных планов
    public function index()
    {
        $teacher = Auth::user();
        $curricula = Curriculum::where('teacher_id', $teacher->id)
            ->with('class')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('teacher.curricula.index', compact('curricula'));
    }

    // Форма создания плана
    public function create()
    {
        $classes = Classes::where('teacher_id', Auth::id())->get();
        $vocabularyTopics = Word::select('topic')->distinct()->get();
        $grammarTopics = GrammarTopic::where('is_active', true)->get();

        return view('teacher.curricula.create', compact('classes', 'vocabularyTopics', 'grammarTopics'));
    }

    // Сохранение плана
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'class_id' => 'required|exists:classes,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'lessons' => 'required|array|min:1',
            'lessons.*.type' => 'required|in:test',
            'lessons.*.topic' => 'required|string',
            'lessons.*.due_date' => 'required|date',
            'lessons.*.order' => 'required|integer'
        ]);

        $class = Classes::where('id', $request->class_id)
            ->where('teacher_id', Auth::id())
            ->firstOrFail();

        $curriculum = Curriculum::create([
            'teacher_id' => Auth::id(),
            'class_id' => $request->class_id,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active'
        ]);

        foreach ($request->lessons as $lessonData) {
            $slug = \Illuminate\Support\Str::slug($lessonData['topic']);

            $exists = Lesson::where('curriculum_id', $curriculum->id)
                ->where('type', 'test')
                ->where('slug', $slug)
                ->exists();

            if (!$exists) {
                Lesson::create([
                    'curriculum_id' => $curriculum->id,
                    'type' => 'test',
                    'topic' => $lessonData['topic'],
                    'slug' => $slug,
                    'due_date' => $lessonData['due_date'],
                    'order' => $lessonData['order'],
                    'status' => 'pending'
                ]);
            }
        }

        return redirect()->route('teacher.curricula.show', $curriculum->id)
            ->with('success', 'Учебный план успешно создан');
    }

    // Просмотр плана
    public function show($id)
    {
        $curriculum = Curriculum::where('teacher_id', Auth::id())
            ->with(['class', 'lessons'])
            ->findOrFail($id);

        $students = $curriculum->class->students;

        $studentStats = [];
        foreach ($students as $student) {
            $completedLessons = 0;
            $totalLessons = $curriculum->lessons->count();
            $totalScore = 0;
            $completedWithScore = 0;

            foreach ($curriculum->lessons as $lesson) {
                $progress = $lesson->studentProgress($student->id);
                if ($progress && $progress->status == 'completed') {
                    $completedLessons++;
                    if ($progress->score) {
                        $totalScore += $progress->score;
                        $completedWithScore++;
                    }
                }
            }

            $avgScore = $completedWithScore > 0 ? round($totalScore / $completedWithScore) : 0;

            $studentStats[$student->id] = [
                'name' => $student->name,
                'completed' => $completedLessons,
                'total' => $totalLessons,
                'percentage' => $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0,
                'avg_score' => $avgScore
            ];
        }

        return view('teacher.curricula.show', compact('curriculum', 'studentStats'));
    }

    // Редактирование плана
    public function edit($id)
    {
        $curriculum = Curriculum::where('teacher_id', Auth::id())
            ->with('lessons')
            ->findOrFail($id);

        $classes = Classes::where('teacher_id', Auth::id())->get();
        $vocabularyTopics = Word::select('topic')->distinct()->get();
        $grammarTopics = GrammarTopic::where('is_active', true)->get();

        return view('teacher.curricula.edit', compact('curriculum', 'classes', 'vocabularyTopics', 'grammarTopics'));
    }

    // Обновление плана
    public function update(Request $request, $id)
    {
        $curriculum = Curriculum::where('teacher_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'class_id' => 'required|exists:classes,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'lessons' => 'required|array|min:1',
            'lessons.*.type' => 'required|in:test',
            'lessons.*.topic' => 'required|string',
            'lessons.*.due_date' => 'required|date',
            'lessons.*.order' => 'required|integer'
        ]);

        $class = Classes::where('id', $request->class_id)
            ->where('teacher_id', Auth::id())
            ->firstOrFail();

        $curriculum->update([
            'title' => $request->title,
            'description' => $request->description,
            'class_id' => $request->class_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        $curriculum->lessons()->delete();

        foreach ($request->lessons as $lessonData) {
            $slug = \Illuminate\Support\Str::slug($lessonData['topic']);

            Lesson::create([
                'curriculum_id' => $curriculum->id,
                'type' => 'test',
                'topic' => $lessonData['topic'],
                'slug' => $slug,
                'due_date' => $lessonData['due_date'],
                'order' => $lessonData['order'],
                'status' => 'pending'
            ]);
        }

        return redirect()->route('teacher.curricula.show', $curriculum->id)
            ->with('success', 'Учебный план обновлен');
    }

    // Удаление плана
    public function destroy($id)
    {
        $curriculum = Curriculum::where('teacher_id', Auth::id())->findOrFail($id);
        $curriculum->delete();

        return redirect()->route('teacher.curricula.index')
            ->with('success', 'Учебный план удален');
    }
}