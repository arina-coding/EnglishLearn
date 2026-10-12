@extends('layouts.app')

@section('title', $curriculum->title)

@section('content')
<div class="dashboard-container">
    <div class="container">
        <div class="dashboard-header">
            <div class="welcome-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="welcome-title">
                            <i class="bi bi-calendar-week me-2"></i>{{ $curriculum->title }}
                        </h1>
                        <p class="welcome-subtitle">
                            Класс: {{ $curriculum->class->name }}
                            @if($curriculum->end_date)
                                | Период: {{ \Carbon\Carbon::parse($curriculum->start_date)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($curriculum->end_date)->format('d.m.Y') }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('teacher.curricula.edit', $curriculum->id) }}" class="btn btn-outline-primary btn-edit-header">
                            <i class="bi bi-pencil me-2"></i>Редактировать
                        </a>
                        <a href="{{ route('teacher.curricula.index') }}" class="btn btn-outline-secondary">
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

        <!-- Список уроков -->
<div class="dashboard-section">
    <h3 class="section-title">
        <i class="bi bi-people me-2"></i>Прогресс студентов
    </h3>

    @if(count($studentStats) > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Студент</th>
                        <th>Выполнено</th>
                        <th>Средний балл</th>
                        <th>Прогресс</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($studentStats as $studentId => $stats)
                    <tr>
                        <td>{{ $stats['name'] }}</td>
                        <td>{{ $stats['completed'] }}/{{ $stats['total'] }}</td>
                        <td>
                            @if($stats['avg_score'] > 0)
                                <span class="badge bg-{{ $stats['avg_score'] >= 70 ? 'success' : ($stats['avg_score'] >= 50 ? 'warning' : 'danger') }}">
                                    {{ $stats['avg_score'] }}%
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                     style="width: {{ $stats['percentage'] }}%"
                                     aria-valuenow="{{ $stats['percentage'] }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100">
                                    {{ $stats['percentage'] }}%
                                </div>
                            </div>
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

<!-- Список тестов в учебном плане -->
<div class="dashboard-section">
    <div class="section-header-wrapper">
        <div class="section-header-left">
            <h3 class="section-title text-primary">
                <i class="bi bi-list-check me-2"></i>Содержание учебного плана
            </h3>
        </div>

    </div>

    @if($curriculum->lessons->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px">№</th>
                        <th>Тема теста</th>
                        <th>Дата выполнения</th>
                        <th>Статус</th>
                        <th style="width: 100px">Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curriculum->lessons as $lesson)
                    <tr>
                        <td class="text-muted">{{ $lesson->order }}</td>
                        <td>
                            <strong>{{ $lesson->topic }}</strong>
                        </td>

                        <td>
                            <span class="meta-date">
                                <i class="bi bi-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($lesson->due_date)->format('d.m.Y') }}
                            </span>
                        </td>
                        <td>
                            @php
                                $completedCount = $lesson->progress()->where('status', 'completed')->count();
                                $totalStudents = $curriculum->class->students->count();
                                $percent = $totalStudents > 0 ? round(($completedCount / $totalStudents) * 100) : 0;
                            @endphp
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress" style="width: 80px; height: 4px;">
                                    <div class="progress-bar bg-success" style="width: {{ $percent }}%"></div>
                                </div>
                                <small class="text-muted">{{ $completedCount }}/{{ $totalStudents }}</small>
                            </div>
                        </td>
                        <td>
                            <a href="{{ $lesson->getTopicInfo()['test_route'] ?? '#' }}"
                               class="btn-class-view flex-fill"
                               title="Перейти к тесту">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Просмотр
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state small">
            <div class="empty-icon">
                <i class="bi bi-journal-x"></i>
            </div>
            <p>В этом учебном плане пока нет тестов</p>
            <a href="{{ route('teacher.curricula.edit', $curriculum->id) }}" class="btn-edit-header mt-2">
                <i class="bi bi-plus-circle me-1"></i> Добавить тесты
            </a>
        </div>
    @endif
</div>

<style>
.section-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}
</style>
@endsection




