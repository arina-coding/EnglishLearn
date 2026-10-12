@extends('layouts.app')

@section('title', 'Словарь - Категории')

@section('content')
<div class="vocabulary-container">
    <div class="container">

        <div class="vocabulary-header">
            <h1 class="vocabulary-title">Словарь</h1>
            <p class="vocabulary-subtitle">
                Изучайте английские слова по темам. Выберите категорию для начала обучения.
            </p>
        </div>

        <div class="categories-grid">
            @php
                $allCategories = [
                    [
                        'name' => 'Еда',
                        'description' => 'Продукты, блюда и напитки',
                        'image' => 'food.jpg',
                        'class' => 'category-food'
                    ],
                    [
                        'name' => 'Животные',
                        'description' => 'Домашние и дикие животные',
                        'image' => 'animals.jpg',
                        'class' => 'category-animals'
                    ],
                    [
                        'name' => 'Семья',
                        'description' => 'Члены семьи и родственники',
                        'image' => 'family.jpg',
                        'class' => 'category-family'
                    ],
                    [
                        'name' => 'Цвета',
                        'description' => 'Все цвета радуги и оттенки',
                        'image' => 'colors.jpg',
                        'class' => 'category-colors'
                    ],
                    [
                        'name' => 'Числа',
                        'description' => 'Цифры и числительные',
                        'image' => 'numbers.jpg',
                        'class' => 'category-numbers'
                    ],
                    [
                        'name' => 'Дом',
                        'description' => 'Комнаты и предметы интерьера',
                        'image' => 'house.jpg',
                        'class' => 'category-house'
                    ]
                ];
            @endphp

            @foreach($allCategories as $category)
                @php
                    $wordCount = \App\Models\Word::where('topic', $category['name'])->count();
                    $hasWords = $wordCount > 0;
                @endphp

                <a href="{{ $hasWords ? route('vocabulary.topic', $category['name']) : '#' }}"
                   class="category-card category-card-with-image {{ $category['class'] }} {{ !$hasWords ? 'category-empty' : '' }}"
                   @if(!$hasWords) onclick="event.preventDefault(); alert('В этой категории пока нет слов'); return false;" @endif>

                    <div class="category-content">
                        <div class="category-name">{{ $category['name'] }}</div>
                        <div class="category-count">
                            {{ $wordCount }} {{ trans_choice('слово|слова|слов', $wordCount) }}
                        </div>
                        <div class="category-description">{{ $category['description'] }}</div>

                        @if(!$hasWords)
                            <div class="category-empty-message">
                                Скоро добавим!
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
<script src="{{ asset('js/vocabulary.js') }}"></script>
@endsection