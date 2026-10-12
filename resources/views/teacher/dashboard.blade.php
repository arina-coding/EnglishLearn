@extends('layouts.app')

@section('title', 'Панель преподавателя - ' . $teacher->name)

@section('content')
<div class="dashboard-container">
    <div class="container">
                @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <strong>Пожалуйста, исправьте следующие ошибки:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Приветствие -->
        <div class="dashboard-header">
            <div class="welcome-card">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="welcome-title">
                            <span class="greeting">Добро пожаловать,</span>
                            <span class="user-name">{{ $teacher->name }}</span>
                        </h1>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="user-avatar">
                            <div class="avatar-initials">
                                {{ mb_substr($teacher->name, 0, 1) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Статистика -->
        <div class="dashboard-section">
            <h2 class="section-title">
                <i class="bi bi-graph-up me-2"></i>Общая статистика
            </h2>

            <div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: #4e54c8; color: white;">
            <i class="bi bi-people"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $stats['total_students'] }}</div>
            <div class="stat-label">Всего студентов</div>
            <div class="stat-detail">{{ $stats['active_students'] }} активных</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #28a745; color: white;">
            <i class="bi bi-journal-check"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $stats['total_classes'] }}</div>
            <div class="stat-label">Групп</div>
            <div class="stat-detail">Управление группами</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #ffc107; color: white;">
            <i class="bi bi-card-checklist"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $stats['completed_tasks'] }}</div>
            <div class="stat-label">Заданий выполнено</div>
            <div class="stat-detail">Студентами</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #17a2b8; color: white;">
            <i class="bi bi-graph-up"></i>
        </div>
        <div class="stat-content">
            <div class="stat-number">{{ $stats['avg_score'] }}%</div>
            <div class="stat-label">Средняя успеваемость</div>
            <div class="stat-detail">По всем тестам</div>
        </div>
    </div>
</div>
        </div>

        <!-- Быстрые действия -->
<div class="dashboard-section">
    <h2 class="section-title">
        <i class="bi bi-lightning me-2"></i>Быстрые действия
    </h2>

    <div class="actions-grid">
        <a href="{{ route('teacher.classes.index') }}" class="action-card">
            <div class="action-icon" style="background: #4e54c8; color: white;">
                <i class="bi bi-people"></i>
            </div>
            <div class="action-content">
                <h4>Мои группы</h4>
                <p>Управление группами студентов</p>
            </div>
            <div class="action-arrow">
                <i class="bi bi-arrow-right"></i>
            </div>
        </a>

        <a href="{{ route('teacher.curricula.create') }}" class="action-card">
            <div class="action-icon" style="background: #28a745; color: white;">
                <i class="bi bi-calendar-plus"></i>
            </div>
            <div class="action-content">
                <h4>Создать план</h4>
                <p>Новый учебный план для класса</p>
            </div>
            <div class="action-arrow">
                <i class="bi bi-arrow-right"></i>
            </div>
        </a>

        <a href="{{ route('teacher.curricula.index') }}" class="action-card">
            <div class="action-icon" style="background: #ffc107; color: white;">
                <i class="bi bi-calendar-week"></i>
            </div>
            <div class="action-content">
                <h4>Учебные планы</h4>
                <p>Просмотр и управление</p>
            </div>
            <div class="action-arrow">
                <i class="bi bi-arrow-right"></i>
            </div>
        </a>

        <a href="#students-list" class="action-card">
            <div class="action-icon" style="background: #17a2b8; color: white;">
                <i class="bi bi-person-lines-fill"></i>
            </div>
            <div class="action-content">
                <h4>Студенты</h4>
                <p>Список всех студентов</p>
            </div>
            <div class="action-arrow">
                <i class="bi bi-arrow-right"></i>
            </div>
        </a>
    </div>
</div>

        <!-- Список студентов -->
        <div class="dashboard-section"  id="students-list">
            <div class="students-header">
                <h2 class="section-title">
                    <i class="bi bi-person-lines-fill me-2"></i>Студенты
                </h2>
                <span class="students-count">{{ count($students) }}</span>
            </div>

            @if(count($students) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Последний вход</th>
                                <th>Выучено слов</th>
                                <th>Точность</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                {{ mb_substr($student->name, 0, 1) }}
                                            </div>
                                            {{ $student->name }}
                                        </div>
                                    </td>
                                    <td>{{ $student->email }}</td>
                                    <td>
                                        @if($student->last_login_at)
                                            @php
                                                try {
                                                    $lastLogin = $student->last_login_at;
                                                    if (is_string($lastLogin)) {
                                                        $lastLogin = \Carbon\Carbon::parse($lastLogin);
                                                    }
                                                    echo $lastLogin->diffForHumans();
                                                } catch (\Exception $e) {
                                                    echo '<span class="text-muted">Дата не определена</span>';
                                                }
                                            @endphp
                                        @else
                                            <span class="text-muted">Никогда</span>
                                        @endif
                                    </td>
                                    <td>{{ $student->learned_words_count }}/{{ $student->total_words }}</td>
                                    <td>
                                        <span class="badge bg-{{ $student->accuracy >= 70 ? 'success' : ($student->accuracy >= 50 ? 'warning' : 'danger') }}">
                                            {{ $student->accuracy }}%
                                        </span>
                                    </td>
                                    <td>
<a href="{{ route('teacher.student', $student->id) }}" class="btn-view-student-light">
    <i class="bi bi-eye me-1"></i> Просмотр
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
                        <i class="bi bi-people"></i>
                    </div>
                    <p>Пока нет зарегистрированных студентов</p>
                </div>
            @endif
        </div>

        <!-- Недавняя активность -->
        <div class="dashboard-section">
    <div class="section-title">
        <h2 class="section-title">
            <i class="bi bi-clock-history me-2"></i>Недавняя активность
        </h2>
    </div>

    @if(isset($recentActivity) && $recentActivity->count() > 0)
        <div class="activity-list">
            @foreach($recentActivity as $activity)
            <div class="activity-item">
                <div class="activity-icon {{ $activity->icon_color }}">
                    <i class="bi {{ $activity->icon }}"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-main">
                        <strong>{{ $activity->student_name }}</strong>
                        @if($activity->type == 'test')
                            выполнил тест "{{ $activity->title }}"
                            @if($activity->score)
                                <span class="badge bg-{{ $activity->score >= 70 ? 'success' : ($activity->score >= 50 ? 'warning' : 'danger') }} ms-1">
                                    {{ $activity->score }}%
                                </span>
                            @endif
                        @elseif($activity->type == 'word')
                            выучил слово "{{ $activity->title }}"
                            <span class="activity-topic">{{ $activity->topic }}</span>
                        @elseif($activity->type == 'join')
                            {{ $activity->title }}
                        @elseif($activity->type == 'login')
                            {{ $activity->title }}
                        @endif
                    </div>
                    <div class="activity-meta">
                        <span class="activity-time">
                            <i class="bi bi-clock me-1"></i>
                            {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="empty-state small">
            <div class="empty-icon">
                <i class="bi bi-clock"></i>
            </div>
            <p>Пока нет активности от студентов</p>
        </div>
    @endif
</div>
    </div>
</div>


@endsection