@extends('layouts.app')

@section('title', 'Мои задания')

@section('content')

<div class="dashboard-container">
    <svg width="0" height="0" style="position: absolute;">
        <defs>
            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" style="stop-color: #4e54c8" />
                <stop offset="100%" style="stop-color: #8f94fb" />
            </linearGradient>
        </defs>
    </svg>
    <div class="container">
        <div class="dashboard-header">
            <div class="welcome-card">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="welcome-title">
                            <i class="bi bi-calendar-check me-2 text-primary"></i>Мои задания
                        </h1>
                        <p class="welcome-subtitle">
                            {{ Auth::user()->name }}, вот что вам нужно выполнить
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="progress-stats">
                            <div class="progress-circle">
                                <svg class="progress-svg" viewBox="0 0 100 100" width="110" height="110">
                                    <defs>
                                        <linearGradient id="circleGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" style="stop-color: #4e54c8" />
                                            <stop offset="100%" style="stop-color: #8f94fb" />
                                        </linearGradient>
                                    </defs>
                                    <circle class="progress-bg" cx="50" cy="50" r="45" fill="none" stroke="#e9ecef" stroke-width="8"></circle>
                                    <circle class="progress-fill" cx="50" cy="50" r="45" fill="none" stroke="url(#circleGradient)" stroke-width="8" stroke-linecap="round"
                                            style="stroke-dasharray: 283; stroke-dashoffset: {{ 283 - ($stats['completion_percentage'] / 100) * 283 }}; transition: stroke-dashoffset 0.5s ease;">
                                    </circle>
                                </svg>
                                <div class="progress-circle-inner">
                                    <span class="progress-percent">{{ $stats['completion_percentage'] }}%</span>
                                    <small>выполнено</small>
                                </div>
                            </div>
                        </div>
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

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(count($overdueLessons) > 0)
        <div class="dashboard-section">
            <div class="section-header-wrapper">
                <div class="section-header-left">
                    <h3 class="section-title text-danger">
                        <i class="bi bi-exclamation-octagon me-2"></i>Просроченные задания
                    </h3>
                    <p class="section-subtitle">Эти задания следовало выполнить раньше</p>
                </div>
                <div class="section-badge-count danger">
                    {{ count($overdueLessons) }}
                </div>
            </div>
            <div class="row">
                @foreach($overdueLessons as $lesson)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="task-card overdue">
                        <div class="task-type overdue">
                            @if($lesson['type'] == 'vocabulary')
                                <i class="bi bi-book me-1"></i> Словарь
                            @elseif($lesson['type'] == 'grammar')
                                <i class="bi bi-journal-text me-1"></i> Грамматика
                            @else
                                <i class="bi bi-pencil-square me-1"></i> Тест
                            @endif
                        </div>
                        <h5 class="task-title">{{ $lesson['title'] }}</h5>
                        <p class="task-description">{{ $lesson['info']['description'] }}</p>
                        <div class="task-meta">
                            <span class="meta-date overdue">
                                <i class="bi bi-calendar-x me-1"></i> Должно было быть: {{ \Carbon\Carbon::parse($lesson['due_date'])->format('d.m.Y') }}
                            </span>
                        </div>
                        <div class="task-actions">
                            <a href="{{ $lesson['info']['route'] ?? $lesson['info']['test_route'] }}" class="btn-task btn-task-warning">
                                <i class="bi bi-play-fill me-1"></i> Выполнить сейчас
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="dashboard-section">
            <div class="section-header-wrapper">
                <div class="section-header-left">
                    <h3 class="section-title text-primary">
                        <i class="bi bi-star-fill me-2"></i>На сегодня
                    </h3>
                    <p class="section-subtitle">Приоритетные задания на сегодня</p>
                </div>
                <div class="section-badge-count primary">
                    {{ count($todaysLessons) }}
                </div>
            </div>

            @if(count($todaysLessons) > 0)
                <div class="row">
                    @foreach($todaysLessons as $lesson)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="task-card today">
                            <div class="task-type {{ $lesson['type'] }}">
                                @if($lesson['type'] == 'vocabulary')
                                    <i class="bi bi-book me-1"></i> Словарь
                                @elseif($lesson['type'] == 'grammar')
                                    <i class="bi bi-journal-text me-1"></i> Грамматика
                                @else
                                    <i class="bi bi-pencil-square me-1"></i> Тест
                                @endif
                            </div>
                            <h5 class="task-title">{{ $lesson['title'] }}</h5>
                            <p class="task-description">{{ $lesson['info']['description'] }}</p>
                            <div class="task-meta">
                                <span class="meta-date">
                                    <i class="bi bi-calendar-check me-1"></i> Срок: сегодня
                                </span>
                            </div>
                            <div class="task-actions">
                                <a href="{{ $lesson['info']['route'] ?? $lesson['info']['test_route'] }}" class="btn-task">
                                    <i class="bi bi-play-fill me-1"></i> Пройти тест
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state-small">
                    <i class="bi bi-check-circle fs-1"></i>
                    <h5>Отлично!</h5>
                    <p>На сегодня нет заданий. Можете повторить пройденное или отдохнуть.</p>
                </div>
            @endif
        </div>

        @if(count($weeklyLessons) > 0)
        <div class="dashboard-section">
            <div class="section-header-wrapper">
                <div class="section-header-left">
                    <h3 class="section-title text-info">
                        <i class="bi bi-calendar-week me-2"></i>На эту неделю
                    </h3>
                    <p class="section-subtitle">Запланированные задания на ближайшие дни</p>
                </div>
                <div class="section-badge-count info">
                    {{ count($weeklyLessons) }}
                </div>
            </div>
            <div class="row">
                @foreach($weeklyLessons as $lesson)
                <div class="col-md-4 col-lg-3 mb-3">
                    <div class="task-card week">
                        <div class="task-type small {{ $lesson['type'] }}">
                            @if($lesson['type'] == 'vocabulary')
                                <i class="bi bi-book"></i>
                            @elseif($lesson['type'] == 'grammar')
                                <i class="bi bi-journal-text"></i>
                            @else
                                <i class="bi bi-pencil-square"></i>
                            @endif
                        </div>
                        <h6 class="task-title">{{ $lesson['title'] }}</h6>
                        <div class="task-meta">
                            <span class="meta-date">
                                <i class="bi bi-calendar me-1"></i> {{ \Carbon\Carbon::parse($lesson['due_date'])->format('d.m.Y') }}
                            </span>
                        </div>
                        <div class="task-actions">
                            <a href="{{ $lesson['info']['route'] ?? $lesson['info']['test_route'] }}" class="btn-task btn-task-info">
                                <i class="bi bi-book me-1"></i> Подготовиться
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

@endsection