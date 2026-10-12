@extends('layouts.app')

@section('title', 'Тест - ' . $topic)

@section('content')
<div class="vocabulary-container">
    <div class="container">
        <nav class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('vocabulary') }}">Словарь</a></li>
                <li class="breadcrumb-item"><a href="{{ route('vocabulary.topic', $topic) }}">{{ $topic }}</a></li>
                <li class="breadcrumb-item active">Тест</li>
            </ol>
        </nav>

        <div class="vocabulary-header">
            <h1 class="vocabulary-title">Тест: {{ $topic }}</h1>
            <p class="vocabulary-subtitle">
                Проверьте свои знания. Напишите перевод слов на английском языке.
            </p>
            <div class="test-progress">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                </div>
                <div class="progress-text">Вопрос 1 из {{ $words->count() }}</div>
            </div>
        </div>

        <form action="{{ route('check.test') }}" method="POST" id="testForm">
            @csrf
            <input type="hidden" name="topic" value="{{ $topic }}">

            <div class="test-grid">
                @foreach($words as $index => $word)
                    <div class="test-card" data-question="{{ $index + 1 }}">
                        <div class="test-card-header">
                            <span class="question-number">Вопрос {{ $index + 1 }}</span>
                            <span class="question-topic">{{ $topic }}</span>
                        </div>

                        <div class="test-question">
                            <div class="question-text">"{{ $word->russian }}"</div>
                        </div>

                        <div class="test-answer">
                            <input type="text"
                                   class="form-control test-input"
                                   name="answers[{{ $word->id }}]"
                                   required
                                   placeholder="Напишите перевод..."
                                   data-word-id="{{ $word->id }}">
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="test-submit-section">
                <button type="submit" class="btn btn-test btn-lg">
                    <span class="submit-text">Проверить ответы</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection