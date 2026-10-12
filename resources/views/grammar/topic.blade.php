@extends('layouts.app')

@section('title', $topic->title . ' - Грамматика')

@section('content')
<div class="grammar-topic-container">
    <div class="container">
        <!-- Навигация -->
        <nav class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('grammar') }}">Грамматика</a></li>
                <li class="breadcrumb-item active">{{ $topic->title }}</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Заголовок темы -->
                <div class="grammar-topic-header">
                    <h1 class="grammar-topic-title">{{ $topic->title }}</h1>

                    <div class="grammar-topic-meta">
                        <span class="grammar-topic-level level-{{ $topic->level }}">
                            Уровень: {{ $topic->level == 'beginner' ? 'Начальный' : ($topic->level == 'intermediate' ? 'Средний' : 'Продвинутый') }}
                        </span>
                    </div>

                    <p class="grammar-topic-description">
                        Изучите теорию и выполните упражнения для закрепления материала
                    </p>
                </div>

                <div class="grammar-section">
                    <div class="section-title-wrapper">
                        <div class="section-icon">
                            <i class="bi bi-info-circle"></i>
                        </div>
                        <h2 class="section-title">О теме</h2>
                    </div>
                    <div class="section-content">
                        <p>{{ $topic->introduction ?? 'В этом разделе вы изучите основные правила и принципы данной грамматической темы.' }}</p>
                    </div>
                </div>


                <!-- Теоретическая часть -->
                <div class="grammar-section">
                    <div class="section-title-wrapper">
                        <div class="section-icon">
                            <i class="bi bi-journal-bookmark"></i>
                        </div>
                        <h2 class="section-title">Теоретическая часть</h2>
                    </div>
                    <div class="section-content theory-content">
                        {!! nl2br(e($topic->theory)) !!}
                    </div>
                </div>

                <!-- Примеры -->
                <div class="grammar-section">
                    <div class="section-title-wrapper">
                        <div class="section-icon">
                            <i class="bi bi-lightbulb"></i>
                        </div>
                        <h2 class="section-title">Примеры использования</h2>
                    </div>
                    <div class="section-content examples-content">
                        {!! nl2br(e($topic->examples)) !!}
                    </div>
                </div>

                <!-- Кнопка начала упражнений -->
                <div class="grammar-exercise-action">
                    <h3>Проверьте свои знания</h3>
                    <p>Выполните упражнения чтобы закрепить изученный материал</p>
                    <a href="{{ route('grammar.exercise', $topic->slug) }}" class="btn btn-grammar-start">
                        <i class="bi bi-play-circle me-2"></i>Начать упражнения
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection