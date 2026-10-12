<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Classes;
use App\Models\User;

class ClassController extends Controller
{
    // Список классов преподавателя
    public function index()
    {
        $teacher = Auth::user();
        $classes = Classes::where('teacher_id', $teacher->id)
            ->withCount('students')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('teacher.classes.index', compact('classes'));
    }

    // Форма создания класса
    public function create()
    {
        return view('teacher.classes.create');
    }

    // Сохранение нового класса
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'student_emails' => 'nullable|string'
        ]);

        $class = Classes::create([
            'teacher_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description
        ]);

        if ($request->filled('student_emails')) {
            $emails = explode(',', $request->student_emails);
            $emails = array_map('trim', $emails);

            foreach ($emails as $email) {
                $student = User::where('email', $email)->where('role', 'student')->first();
                if ($student && !$class->students()->where('student_id', $student->id)->exists()) {
                    $class->students()->attach($student->id);
                }
            }
        }

        return redirect()->route('teacher.classes.show', $class->id)
            ->with('success', 'Класс "' . $class->name . '" успешно создан!');
    }

    // Просмотр класса
    public function show($id)
    {
        $class = Classes::where('teacher_id', Auth::id())
            ->with(['students', 'curricula' => function($query) {
                $query->with('lessons')->orderBy('created_at', 'desc');
            }])
            ->findOrFail($id);

        // Статистика класса
        $stats = [
            'total_students' => $class->students->count(),
            'total_curricula' => $class->curricula->count(),
            'total_tasks' => $class->curricula->sum(function($curriculum) {
                return $curriculum->lessons->count();
            }),
            'completed_tasks' => 0
        ];

        return view('teacher.classes.show', compact('class', 'stats'));
    }

    // Редактирование класса
    public function edit($id)
    {
        $class = Classes::where('teacher_id', Auth::id())->findOrFail($id);
        return view('teacher.classes.edit', compact('class'));
    }

    // Обновление класса
    public function update(Request $request, $id)
    {
        $class = Classes::where('teacher_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000'
        ]);

        $class->update($request->only(['name', 'description']));

        return redirect()->route('teacher.classes.show', $class->id)
            ->with('success', 'Класс успешно обновлен');
    }

    // Удаление класса
    public function destroy($id)
    {
        $class = Classes::where('teacher_id', Auth::id())->findOrFail($id);
        $class->delete();

        return redirect()->route('teacher.classes.index')
            ->with('success', 'Класс успешно удален');
    }

    // Добавление студента в класс
    public function addStudent(Request $request, $id)
    {
        $class = Classes::where('teacher_id', Auth::id())->findOrFail($id);

        $request->validate([
            'student_email' => 'required|email|exists:users,email'
        ]);

        $student = User::where('email', $request->student_email)
            ->where('role', 'student')
            ->first();

        if (!$student) {
            return back()->with('error', 'Студент с таким email не найден');
        }

        if ($class->students()->where('student_id', $student->id)->exists()) {
            return back()->with('error', 'Студент уже состоит в этом классе');
        }

        $class->students()->attach($student->id);

        return back()->with('success', 'Студент успешно добавлен в класс');
    }

    // Удаление студента из класса
    public function removeStudent($classId, $studentId)
    {
        $class = Classes::where('teacher_id', Auth::id())->findOrFail($classId);

        if (!$class->students()->where('student_id', $studentId)->exists()) {
            return back()->with('error', 'Студент не найден в этом классе');
        }

        $class->students()->detach($studentId);

        return back()->with('success', 'Студент успешно исключен из класса');
    }
}