@extends('layouts.app')

@section('title', 'Моя статистика')

@section('content')
<div class="container">
    <h1>Моя статистика</h1>

    <!-- Основная статистика -->
    <div class="row mt-4">
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body text-center">
                    <h5 class="card-title">Выучено слов</h5>
                    <p class="card-text display-4">{{ $stats['learned_words'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body text-center">
                    <h5 class="card-title">Точность</h5>
                    <p class="card-text display-4">{{ $stats['accuracy'] }}%</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-white bg-warning">
                <div class="card-body text-center">
                    <h5 class="card-title">Всего попыток</h5>
                    <p class="card-text display-4">{{ $stats['total_attempts'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-white bg-info">
                <div class="card-body text-center">
                    <h5 class="card-title">Дней подряд</h5>
                    <p class="card-text display-4">{{ $stats['login_streak'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Прогресс по темам -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Прогресс по темам</h3>
                </div>
                <div class="card-body">
                    @foreach($topicProgress as $topic => $progress)
                        <div class="mb-3">
                            <h5>{{ $topic }}</h5>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar" role="progressbar"
                                     style="width: {{ $progress['percentage'] }}%;"
                                     aria-valuenow="{{ $progress['percentage'] }}"
                                     aria-valuemin="0" aria-valuemax="100">
                                    {{ $progress['learned'] }}/{{ $progress['total'] }} ({{ $progress['percentage'] }}%)
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Недавняя активность -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Недавняя активность</h3>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($recentActivity as $activity)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1">{{ $activity->word->english }} - {{ $activity->word->russian }}</h6>
                                    <small>{{ $activity->last_practiced_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1">
                                    Правильных ответов: {{ $activity->correct_answers }}/{{ $activity->total_attempts }}
                                    @if($activity->learned)
                                        <span class="badge bg-success ms-2">Выучено</span>
                                    @endif
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection