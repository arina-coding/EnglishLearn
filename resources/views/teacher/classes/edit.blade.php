@extends('layouts.app')

@section('title', 'Редактирование класса - Панель преподавателя')

@section('content')
<div class="dashboard-container">
    <div class="container">
        <div class="dashboard-header">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif


            <div class="welcome-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="welcome-title">
                            <i class="bi bi-pencil-square me-2"></i>Редактирование класса
                        </h1>
                        <p class="welcome-subtitle">
                            {{ $class->name }}
                        </p>
                    </div>
                    <a href="{{ route('teacher.classes.show', $class->id) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Назад
                    </a>
                </div>
            </div>
        </div>

        <!-- Форма редактирования названия и описания -->
        <div class="dashboard-section">
            <form method="POST" action="{{ route('teacher.classes.update', $class->id) }}" id="editClassForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-4">
                            <label for="name" class="form-label">Название класса/группы</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $class->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Описание</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4">{{ old('description', $class->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Добавление студента -->
        <div class="dashboard-section">
            <h2 class="section-title">
                <i class="bi bi-person-plus me-2"></i>Добавить студента
            </h2>
            <form method="POST" action="{{ route('teacher.classes.add-student', $class->id) }}" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <input type="email" class="form-control" name="student_email"
                           placeholder="Email студента" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Добавить
                    </button>
                </div>
            </form>
        </div>

        <!-- Список студентов -->
        <div class="dashboard-section">
            <div class="students-header">
                <h2 class="section-title">
                    <i class="bi bi-person-lines-fill me-2"></i>Студенты
                </h2>
                <span class="section-badge">{{ $class->students->count() }}</span>
            </div>


            @if($class->students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Присоединился</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($class->students as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>
                                    @if($student->pivot->created_at)
                                        {{ \Carbon\Carbon::parse($student->pivot->created_at)->format('d.m.Y') }}
                                    @else
                                        <span class="text-muted">Дата неизвестна</span>
                                    @endif
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('teacher.classes.remove-student', [$class->id, $student->id]) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-student-remove">
                                            <i class="bi bi-person-x"></i> Исключить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state small">
                    <div class="empty-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <p>В этом классе пока нет студентов</p>
                </div>
            @endif
        </div>

        <!-- Кнопки сохранения и отмены -->
        <div class="dashboard-section border-0 bg-transparent">
            <div class="d-flex justify-content-between gap-2">
                <a href="{{ route('teacher.classes.show', $class->id) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-1"></i>Отмена
                </a>
                <button type="submit" form="editClassForm" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Сохранить изменения
                </button>
            </div>
        </div>
    </div>
</div>

@endsection