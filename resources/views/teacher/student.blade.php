@extends('layouts.app')

@section('title', 'Профиль студента - ' . $student->name)

@section('content')
<div class="dashboard-container">
    <div class="container">
        <!-- Заголовок -->
        <div class="dashboard-header">
            <div class="welcome-card">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="welcome-title">
                            <i class="bi bi-person me-2"></i>Профиль студента
                        </h1>
                        <p class="welcome-subtitle">
                            {{ $student->name }} | {{ $student->email }}
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-primary btn-edit-header">
                            <i class="bi bi-arrow-left me-1"></i>Назад к списку
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Статистика студента -->
        <div class="dashboard-section">
            <h2 class="section-title">
                <i class="bi bi-graph-up me-2"></i>Статистика студента
            </h2>

            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="stat-card text-center">
                        <div class="stat-number">{{ $progress['learned_words'] }}</div>
                        <div class="stat-label">Выучено слов</div>
                        <div class="stat-detail">из {{ $progress['total_words'] }}</div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-card text-center">
                        <div class="stat-number">{{ $progress['accuracy'] }}%</div>
                        <div class="stat-label">Точность ответов</div>
                        <div class="stat-detail">по всем тестам</div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-card text-center">
                        <div class="stat-number">{{ $progress['login_streak'] }}</div>
                        <div class="stat-label">Дней подряд</div>
                        <div class="stat-detail">активности</div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="stat-card text-center">
                        <div class="stat-number">{{ $progress['percentage'] }}%</div>
                        <div class="stat-label">Прогресс</div>
                        <div class="stat-detail">общий</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Последняя активность -->
        <div class="dashboard-section">
            <div class="students-header">
                <h2 class="section-title">
                    <i class="bi bi-clock-history me-2"></i>Последняя активность
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
                    <p>У студента пока нет активности</p>
                    <p class="small">Студент еще не начал изучение слов</p>
                </div>
            @endif
        </div>
    </div>
</div>


@endsection