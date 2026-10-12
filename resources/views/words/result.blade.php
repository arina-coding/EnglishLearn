@extends('layouts.app')

@section('title', 'Результат теста - EnglishLearn')

@section('content')
<div class="vocabulary-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="result-card">
                    @php
                        $percentage = $total > 0 ? round(($score / $total) * 100) : 0;

                        if ($percentage >= 90) {
                            $color = 'result-excellent';
                            $message = 'Отличный результат!';
                        } elseif ($percentage >= 70) {
                            $color = 'result-good';
                            $message = 'Хороший результат!';
                        } elseif ($percentage >= 50) {
                            $color = 'result-average';
                            $message = 'Неплохой результат!';
                        } else {
                            $color = 'result-poor';
                            $message = 'Попробуйте еще раз!';
                        }
                    @endphp

                    <div class="result-header">
                        <h2>Результат теста</h2>
                        <p class="result-topic">Тема: {{ $topic }}</p>
                    </div>

                    <div class="result-main {{ $color }}">
                        <div class="result-percentage">
                            {{ $percentage }}%
                        </div>
                        <div class="result-score">
                            {{ $score }} из {{ $total }} правильных ответов
                        </div>
                    </div>

                    <div class="result-message">
                        {{ $message }}
                    </div>

                    <div class="result-details">
                        <div class="result-stat">
                            <span class="stat-label">Правильные ответы:</span>
                            <span class="stat-value">{{ $score }}</span>
                        </div>
                        <div class="result-stat">
                            <span class="stat-label">Всего вопросов:</span>
                            <span class="stat-value">{{ $total }}</span>
                        </div>
                        <div class="result-stat">
                            <span class="stat-label">Процент успеха:</span>
                            <span class="stat-value">{{ $percentage }}%</span>
                        </div>
                    </div>

                    <!-- Блок с ошибками -->
                    @if(count($mistakes) > 0)
                    <div class="mistakes-section">
                        <div class="mistakes-header">
                            <h4 class="mistakes-title">
                                <i class="bi bi-exclamation-triangle"></i>
                                Ошибки для повторения
                                <span class="mistakes-count">{{ count($mistakes) }}</span>
                            </h4>
                        </div>
                        <div class="mistakes-list">
                            @foreach($mistakes as $mistake)
                                <div class="mistake-item">
                                    <div class="mistake-icon">
                                        <i class="bi bi-x-circle"></i>
                                    </div>
                                    <div class="mistake-content">
                                        <div class="mistake-word">
                                            {{ $mistake['russian'] }}
                                        </div>
                                        <div class="mistake-comparison">
                                            <div class="answer-group">
                                                <span class="answer-label">Ваш ответ:</span>
                                                <span class="answer-text wrong">{{ $mistake['user_answer'] ?: '(не ответил)' }}</span>
                                            </div>
                                            <span class="answer-arrow">→</span>
                                            <div class="answer-group">
                                                <span class="answer-label">Правильно:</span>
                                                <span class="answer-text correct">{{ $mistake['correct_answer'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="perfect-result">
                        <div class="perfect-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <h4>Превосходно!</h4>
                        <p>Вы ответили правильно на все вопросы. Так держать!</p>
                    </div>
                @endif

                    <div class="result-actions">
                        <a href="{{ route('test', $topic) }}" class="btn btn-retry">
                            <i class="bi bi-arrow-repeat me-2"></i>Пройти тест заново
                        </a>
                        <a href="{{ route('vocabulary.topic', $topic) }}" class="btn btn-outline">
                            <i class="bi bi-book me-2"></i>Повторить слова
                        </a>
                        <a href="{{ route('vocabulary') }}" class="btn btn-outline">
                            <i class="bi bi-grid me-2"></i>Все категории
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection