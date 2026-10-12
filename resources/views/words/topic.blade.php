@extends('layouts.app')

@section('title', 'Словарь - ' . $topic)

@section('content')
<div class="vocabulary-container">
    <div class="container">
        <nav class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('vocabulary') }}">Словарь</a></li>
                <li class="breadcrumb-item active">{{ $topic }}</li>
            </ol>
        </nav>

        <div class="vocabulary-header">
            <h1 class="vocabulary-title">{{ $topic }}</h1>
            <p class="vocabulary-subtitle">
                Изучайте слова с помощью карточек. Нажмите на карточку чтобы увидеть перевод.
            </p>
        </div>

        @if($words->count() > 0)
            <div class="words-grid">
                @foreach($words as $word)
                    @php
                        $imagePath = 'images/words/' . $word->image;
                        $hasImage = $word->image && file_exists(public_path($imagePath));

                        if ($hasImage) {
                            $backgroundStyle = "background-image: url('/images/words/{$word->image}')";
                        } else {
                            $gradients = [
                                'Еда' => 'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)',
                                'Животные' => 'linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%)',
                                'Семья' => 'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)',
                                'Цвета' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                                'Числа' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                                'Дом' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)'
                            ];
                            $backgroundStyle = "background: " . ($gradients[$word->topic] ?? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)');
                        }
                    @endphp

                    <div class="word-card" onclick="flipCard(this)">
                        <div class="word-card-inner">
                            <div class="word-card-front" style="{{ $backgroundStyle }};">
                                @if($hasImage)
                                    <div class="card-background-image" style="background-image: url('/images/words/{{ $word->image }}')"></div>
                                @endif
                                <span class="word-topic">{{ $topic }}</span>
                                <div class="word-content">
                                    <div class="word-text">{{ $word->russian }}</div>
                                    <div class="word-hint">Нажмите для перевода</div>
                                </div>
                            </div>

                            <div class="word-card-back" style="{{ $backgroundStyle }};">
                                @if($hasImage)
                                    <div class="card-background-image" style="background-image: url('/images/words/{{ $word->image }}')"></div>
                                @endif
                                <span class="word-topic">{{ $topic }}</span>
                                <div class="word-content">
                                    <div class="word-text">{{ $word->english }}</div>
                                    <div class="word-translation">{{ $word->russian }}</div>
                                    <div class="word-hint">Нажмите чтобы вернуться</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="test-button">
                <h3>Проверьте свои знания</h3>
                <p class="text-muted mb-3">Пройдите тест чтобы закрепить выученные слова</p>
                <a href="{{ route('test', $topic) }}" class="btn btn-test">
                    Начать тест
                </a>
            </div>
        @else
            <div class="empty-state">
                <h3>В этой категории пока нет слов</h3>
                <p>Попробуйте выбрать другую категорию</p>
                <a href="{{ route('vocabulary') }}" class="btn btn-back mt-3">
                    Вернуться к категориям
                </a>
            </div>
        @endif
    </div>
</div>


<script>
function flipCard(card) {
    card.classList.toggle('flipped');

    const hints = card.querySelectorAll('.word-hint');
    hints.forEach(hint => {
        if (card.classList.contains('flipped')) {
            hint.textContent = 'Нажмите чтобы вернуться';
        } else {
            hint.textContent = 'Нажмите для перевода';
        }
    });
}
</script>
@endsection