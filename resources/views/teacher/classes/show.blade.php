@extends('layouts.app')

@section('title', $class->name . ' - Панель преподавателя')

@section('content')
<div class="dashboard-container">
    <div class="container">
        <div class="dashboard-header">
            <div class="welcome-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="welcome-title">
                            <i class="bi bi-people me-2"></i>{{ $class->name }}
                        </h1>
                        <p class="welcome-subtitle text-muted">
                            Управление классом и студентами
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('teacher.classes.edit', $class->id) }}" class="btn btn-outline-primary btn-edit-header">
                            <i class="bi bi-pencil me-2"></i>Редактировать
                        </a>
                        <a href="{{ route('teacher.classes.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Назад
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Статистика класса -->
        <div class="dashboard-section">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="stat-card text-center">
                        <div class="stat-number">{{ $stats['total_students'] }}</div>
                        <div class="stat-label">Студентов</div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stat-card text-center">
                        <div class="stat-number">{{ $stats['total_tasks'] }}</div>
                        <div class="stat-label">Заданий</div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stat-card text-center">
                        <div class="stat-number">{{ $stats['completed_tasks'] }}</div>
                        <div class="stat-label">Выполнено</div>
                    </div>
                </div>
            </div>
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
                                <th>Дата присоединения</th>
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
                    <p class="small">Отправьте студентам код приглашения: <strong>{{ $class->code }}</strong></p>
                </div>
            @endif
        </div>

        <!-- Задания класса -->
        <div class="dashboard-section">
            <div class="students-header">
                <h2 class="section-title">
            <i class="bi bi-calendar-week me-2"></i>Учебные планы
        </h2>
        <a href="{{ route('teacher.curricula.create') }}?class_id={{ $class->id }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-circle"></i> Создать учебный план
        </a>
    </div>

    @if($class->curricula && $class->curricula->count() > 0)
        <div class="list-group">
            @foreach($class->curricula as $curriculum)
                <a href="{{ route('teacher.curricula.show', $curriculum->id) }}" class="list-group-item list-group-item-action">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">{{ $curriculum->title }}</h6>
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>
                                Период: {{ \Carbon\Carbon::parse($curriculum->start_date)->format('d.m.Y') }}
                                @if($curriculum->end_date)
                                    - {{ \Carbon\Carbon::parse($curriculum->end_date)->format('d.m.Y') }}
                                @endif
                            </small>
                            <br>
                            <small class="text-muted">
                                <i class="bi bi-journal-bookmark me-1"></i>
                                Уроков: {{ $curriculum->lessons->count() }}
                            </small>
                        </div>
                        <span class="badge bg-{{ $curriculum->status == 'active' ? 'success' : 'secondary' }}">
                            {{ $curriculum->status == 'active' ? 'Активен' : 'Завершен' }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="empty-state small">
            <div class="empty-icon">
                <i class="bi bi-calendar-plus"></i>
            </div>
            <p>Для этого класса пока нет учебных планов</p>

        </div>
    @endif
</div>


@endsection