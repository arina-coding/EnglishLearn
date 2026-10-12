@extends('layouts.app')

@section('title', 'Упражнения - ' . $topic->title)

@section('content')
<div class="vocabulary-container">
    <div class="container">
        <!-- Навигация -->
        <nav class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('grammar') }}">Грамматика</a></li>
                <li class="breadcrumb-item"><a href="{{ route('grammar.topic', $topic->slug) }}">{{ $topic->title }}</a></li>
                <li class="breadcrumb-item active">Упражнения</li>
            </ol>
        </nav>

        <!-- Заголовок -->
        <div class="vocabulary-header">
            <h1 class="vocabulary-title">Упражнения: {{ $topic->title }}</h1>
            <p class="vocabulary-subtitle">
                Проверьте свои знания грамматики. Ответьте на все вопросы.
            </p>

            <!-- Прогресс -->
            <div class="test-progress">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                </div>
                <div class="progress-text">Вопрос 1 из {{ $topic->exercises->count() }}</div>
            </div>
        </div>

        <!-- Форма упражнений -->
        <form action="{{ route('grammar.check') }}" method="POST" id="grammarTestForm">
            @csrf
            <input type="hidden" name="topic_id" value="{{ $topic->id }}">

            <div class="test-grid">
                @foreach($topic->exercises as $index => $exercise)
                <div class="test-card" data-question="{{ $index + 1 }}">
                    <div class="test-card-header">
                        <span class="question-number">Вопрос {{ $index + 1 }}</span>
                        <span class="question-topic">{{ $topic->title }}</span>
                    </div>

                    <div class="test-question">
                        <div class="question-text">{{ $exercise->question }}</div>
                    </div>

                   @if($exercise->type === 'choice' && $exercise->options)
                        <div class="grammar-options-container">
                            @foreach($exercise->options as $option)
                                <div class="grammar-option-item">
                                    <input type="radio"
                                        name="answers[{{ $exercise->id }}]"
                                        value="{{ $option }}"
                                        id="option_{{ $exercise->id }}_{{ $loop->index }}"
                                        class="grammar-option-input"
                                        onchange="updateProgress()">
                                    <label for="option_{{ $exercise->id }}_{{ $loop->index }}" class="grammar-option-label">
                                        <span class="grammar-option-text">{{ $option }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="test-answer">
                            <input type="text"
                                class="form-control test-input grammar-input"
                                name="answers[{{ $exercise->id }}]"
                                required
                                placeholder="Введите ваш ответ..."
                                data-question-id="{{ $index }}"
                                oninput="updateProgress()">
                        </div>
                    @endif
                </div>
                @endforeach
            </div>

            <!-- Кнопка отправки -->
            <div class="test-submit-section">
                <button type="submit" class="btn btn-test btn-lg">
                    <span class="submit-text">Проверить ответы</span>
                    <span class="submit-count ms-2">(0 из {{ $topic->exercises->count() }} отвечено)</span>
                </button>
            </div>
        </form>
    </div>
</div>


<script src="{{ asset('js/vocabulary.js') }}"></script>

@endsection