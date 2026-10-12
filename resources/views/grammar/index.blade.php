@extends('layouts.app')

@section('title', 'Грамматика английского языка')

@section('content')
<div class="grammar-container">
    <div class="container">
        <!-- Заголовок -->
        <div class="grammar-header">
            <h1 class="grammar-title">Грамматика английского языка</h1>
            <p class="grammar-subtitle">
                Изучайте грамматические правила с понятными объяснениями и практическими упражнениями
            </p>
        </div>

        <!-- Сетка тем -->
        <div class="grammar-grid">
            @foreach($topics as $topic)
                <a href="{{ route('grammar.topic', $topic->slug) }}" class="grammar-card">
                    <div class="grammar-card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="grammar-level level-{{ $topic->level }}">
                                {{ $topic->level == 'beginner' ? 'Начальный' : ($topic->level == 'intermediate' ? 'Средний' : 'Продвинутый') }}
                            </span>
                            <span class="grammar-order">#{{ $topic->order }}</span>
                        </div>
                        <h3 class="grammar-card-title">{{ $topic->title }}</h3>
                    </div>

                    <div class="grammar-card-body">
                        <p class="grammar-card-description">
                            {{ Str::limit(strip_tags($topic->theory), 150) }}
                        </p>

                        <div class="grammar-stats">
                            <span class="stat-item">
                                <i class="bi bi-journal-text"></i>
                                <span>Теория</span>
                            </span>
                            <span class="stat-item">
                                <i class="bi bi-pencil-square"></i>
                                <span>Упражнения</span>
                            </span>
                            <span class="stat-item">
                                <i class="bi bi-clock"></i>
                                <span>15-20 мин</span>
                            </span>
                        </div>
                    </div>

                    <div class="grammar-card-footer">
                        <span class="btn-grammar">
                            <i class="bi bi-book me-2"></i>Изучить тему
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection