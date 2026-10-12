@extends('layouts.app')

@section('title', 'Личный кабинет - ' . Auth::user()->name)

@section('content')
<div class="dashboard-container">
    <div class="container">
        <!-- Уведомление об успехе -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

<div class="dashboard-container">
    <div class="container">
        <!-- Приветствие пользователя -->
        <div class="dashboard-header">
            <div class="welcome-card">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="welcome-title">
                            <span class="greeting">Добро пожаловать,</span>
                            <span class="user-name">{{ Auth::user()->name }}</span>
                        </h1>
                        <p class="welcome-subtitle">
                            <i class="bi bi-calendar-check me-2"></i>
                            Сегодня {{ date('d.m.Y') }} • Серия:
                            <span class="streak-badge">{{ $stats['login_streak'] }} {{ trans_choice('день|дня|дней', $stats['login_streak']) }}</span>
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="user-avatar">
                            <div class="avatar-initials">
                                {{ mb_substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Основная статистика -->
        <div class="dashboard-section">
            <h2 class="section-title">
                <i class="bi bi-graph-up me-2"></i>Ваша статистика
            </h2>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-book"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['learned_words'] }}</div>
                        <div class="stat-label">Выучено слов</div>
                        <div class="stat-detail">После 3х правильных ответов</div>
                        <div class="stat-progress">
                            <div class="progress">
                                <div class="progress-bar" style="width: {{ min(($stats['learned_words'] / $stats['total_words']) * 100, 100) }}%"></div>
                            </div>
                            <span class="progress-text">{{ $stats['learned_words'] }}/{{ $stats['total_words'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['accuracy'] }}%</div>
                        <div class="stat-label">Точность слов</div>
                        <div class="stat-detail">
                            {{ $stats['correct_answers'] }}/{{ $stats['total_attempts'] }} правильных
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['completed_grammar_tests'] }}</div>
                        <div class="stat-label">Тестов грамматики</div>
                        <div class="stat-detail">
                            Средний балл: {{ $stats['average_grammar_score'] }}%
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="bi bi-fire"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $stats['login_streak'] }}</div>
                        <div class="stat-label">Дней подряд</div>
                        <div class="stat-detail">
                            @if($stats['login_streak'] > 0)
                                Так держать!
                            @else
                                Начните серию сегодня!
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-section">
            <div class="students-header">
                <h2 class="section-title">
            <i class="bi bi-calendar-check me-2"></i>Ближайшие задания
        </h2>
        <a href="{{ route('student.tasks') }}" class="section-link">
            Все задания <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    @if(isset($upcomingLessons) && count($upcomingLessons) > 0)
        <div class="upcoming-tasks">
            @foreach($upcomingLessons as $lesson)
            <div class="upcoming-task-item">
                <div class="task-info">
                    <div class="task-type-badge {{ $lesson['type'] }}">
                        @if($lesson['type'] == 'vocabulary')
                            <i class="bi bi-book"></i>
                        @elseif($lesson['type'] == 'grammar')
                            <i class="bi bi-journal-text"></i>
                        @else
                            <i class="bi bi-pencil-square"></i>
                        @endif
                    </div>
                    <div class="task-details">
                        <strong>{{ $lesson['title'] }}</strong>
                        <span class="task-due">
                            <i class="bi bi-calendar me-1"></i>
                            @if($lesson['due_date'] == date('Y-m-d'))
                                Сегодня
                            @else
                                {{ \Carbon\Carbon::parse($lesson['due_date'])->diffForHumans() }}
                            @endif
                        </span>
                    </div>
                </div>
                <a href="{{ $lesson['info']['test_route'] ?? '#' }}" class="btn-test-sm">
                    <i class="bi bi-play-fill me-1"></i>Выполнить
                </a>
            </div>
            @endforeach
        </div>
    @else
        <div class="empty-state-small">
            <i class="bi bi-check-circle text-success"></i>
            <p>На сегодня нет запланированных заданий</p>
        </div>
    @endif
</div>

        <!-- Прогресс по темам -->
        <div class="dashboard-section">
            <div class="students-header">
                <h2 class="section-title">
                    <i class="bi bi-bar-chart me-2"></i>Прогресс по темам
                </h2>
                <a href="{{ route('vocabulary') }}" class="section-link">
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            @if(!empty($topicProgress))
                <div class="progress-grid">
                    @foreach($topicProgress as $topic => $progress)
                        <div class="progress-card">
                            <div class="progress-header">
                                <div class="topic-info">
                                    <h4 class="topic-name">{{ $topic }}</h4>
                                    <span class="topic-count">{{ $progress['learned'] }}/{{ $progress['total'] }}</span>
                                </div>
                                <div class="topic-percentage">{{ $progress['percentage'] }}%</div>
                            </div>

                            <div class="progress-bar-container">
                                <div class="progress-bar" style="width: {{ $progress['percentage'] }}%">
                                    <span class="progress-fill"></span>
                                </div>
                            </div>

                            <div class="progress-footer">
                                @if($progress['percentage'] < 30)
                                    <span class="progress-status status-beginner">
                                        <i class="bi bi-clock me-1"></i>Начало
                                    </span>
                                @elseif($progress['percentage'] < 70)
                                    <span class="progress-status status-progress">
                                        <i class="bi bi-lightning me-1"></i>В процессе
                                    </span>
                                @else
                                    <span class="progress-status status-completed">
                                        <i class="bi bi-check-circle me-1"></i>Завершено
                                    </span>
                                @endif
                                <a href="{{ route('vocabulary.topic', $topic) }}" class="btn-progress">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-journal"></i>
                    </div>
                    <h4>Прогресс по темам</h4>
                    <p>Начните изучать слова, чтобы увидеть ваш прогресс</p>
                    <a href="{{ route('vocabulary') }}" class="btn btn-primary">
                        <i class="bi bi-play-circle me-2"></i>Начать обучение
                    </a>
                </div>
            @endif
        </div>

        <!-- Быстрые действия -->
        <div class="dashboard-section">
            <h2 class="section-title">
                <i class="bi bi-lightning me-2"></i>Быстрые действия
            </h2>

            <div class="actions-grid">
                <a href="{{ route('vocabulary') }}" class="action-card">
                    <div class="action-icon">
                        <i class="bi bi-book"></i>
                    </div>
                    <div class="action-content">
                        <h4>Изучать слова</h4>
                        <p>Расширяйте словарный запас</p>
                    </div>
                    <div class="action-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>

                <a href="{{ route('grammar') }}" class="action-card">
                    <div class="action-icon">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <div class="action-content">
                        <h4>Изучать грамматику</h4>
                        <p>Осваивайте правила языка</p>
                    </div>
                    <div class="action-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>

                <a href="{{ route('vocabulary') }}" class="action-card">
                    <div class="action-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div class="action-content">
                        <h4>Пройти тест</h4>
                        <p>Проверьте свои знания</p>
                    </div>
                    <div class="action-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>

                <a href="{{ route('vocabulary') }}" class="action-card">
                    <div class="action-icon">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <div class="action-content">
                        <h4>Повторить слова</h4>
                        <p>Закрепите изученное</p>
                    </div>
                    <div class="action-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
        </div>

        <!-- Недавняя активность -->
        <div class="dashboard-section">
            <div class="students-header">
                <h2 class="section-title">
                    <i class="bi bi-clock-history me-2"></i>Недавняя активность
                </h2>
                <span class="section-badge">{{ $recentActivity->count() }}</span>
            </div>

            @if($recentActivity->count() > 0)
                <div class="activity-list">
                    @foreach($recentActivity as $activity)
                        <div class="activity-item">
                            <div class="activity-icon">
                                @if($activity->learned)
                                    <i class="bi bi-check-circle text-success"></i>
                                @else
                                    <i class="bi bi-book text-primary"></i>
                                @endif
                            </div>
                            <div class="activity-content">
                                <div class="activity-main">
                                    <strong>{{ $activity->word->english }}</strong> - {{ $activity->word->russian }}
                                    <span class="activity-topic">{{ $activity->word->topic }}</span>
                                </div>
                                <div class="activity-meta">
                                    <span class="activity-time">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ optional($activity->last_practiced_at)->diffForHumans() ?? 'Недавно' }}
                                    </span>
                                    <span class="activity-stats">
                                        <i class="bi bi-check-circle me-1"></i>
                                        {{ $activity->correct_answers }}/{{ $activity->total_attempts }}
                                    </span>
                                    @if($activity->learned)
                                        <span class="activity-badge">
                                            <i class="bi bi-star me-1"></i>Выучено
                                        </span>
                                    @endif
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
                    <p>Начните изучать слова, чтобы увидеть здесь вашу активность</p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection