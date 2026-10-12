@extends('layouts.app')

@section('title', 'Изучение слов - ' . $topic)

@section('content')
<div class="container">
    <h1>Изучение слов: {{ $topic }}</h1>

    <div class="row" id="flashcards">
        @foreach($words as $word)
            <div class="col-md-3 mb-4">
                <div class="flashcard" onclick="this.classList.toggle('flipped')">
                    <div class="flashcard-front card">
                        <div class="card-body text-center">
                            <h3>{{ $word->english }}</h3>
                        </div>
                    </div>
                    <div class="flashcard-back card bg-light">
                        <div class="card-body text-center">
                            <h3>{{ $word->russian }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('test', $topic) }}" class="btn btn-primary btn-lg">Пройти тест</a>
    </div>
</div>


@endsection