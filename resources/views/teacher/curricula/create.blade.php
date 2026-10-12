@extends('layouts.app')

@section('title', 'Создание учебного плана')

@section('content')
<div class="dashboard-container">
    <div class="container">
        <div class="dashboard-header">
            <div class="welcome-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="welcome-title">
                            Создание учебного плана
                        </h1>
                        <p class="welcome-subtitle text-muted">
                            Выберите тесты, которые должны пройти студенты
                        </p>
                    </div>
                    <a href="{{ route('teacher.curricula.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Назад
                    </a>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('teacher.curricula.store') }}" id="curriculumForm">
            @csrf

            <div class="dashboard-section">
                <h3 class="section-title">Основная информация</h3>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">Название плана</label>
                            <input type="text" class="form-control" id="title" name="title" required
                                   placeholder="Например: План на сентябрь 2024">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="class_id" class="form-label fw-semibold">Класс</label>
                            <select name="class_id" id="class_id" class="form-select" required>
                                <option value="">-- Выберите класс --</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="start_date" class="form-label fw-semibold">Дата начала</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="end_date" class="form-label fw-semibold">Дата окончания</label>
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Описание плана</label>
                    <textarea class="form-control" id="description" name="description" rows="2"
                              placeholder="Краткое описание целей и задач"></textarea>
                </div>
            </div>

            <div class="dashboard-section">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="section-title mb-0">Тесты</h3>
                    <button type="button" class="btn btn-primary" onclick="addTest()">
                        <i class="bi bi-plus-circle me-1"></i>Добавить тест
                    </button>
                </div>

                <div id="tests-container"></div>

                <div class="alert alert-light text-center py-4 border rounded" id="emptyTestsAlert">
                    <i class="bi bi-info-circle fs-4 text-muted d-block mb-2"></i>
                    <p class="text-muted mb-0">Нажмите на кнопку выше, чтобы добавить тесты в учебный план</p>
                </div>
            </div>

            <div class="dashboard-section border-0 bg-transparent">
                <div class="d-flex justify-content-between gap-2">
                    <a href="{{ route('teacher.curricula.index') }}" class="btn btn-outline-secondary px-4">
                        Отмена
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-2"></i>Сохранить учебный план
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
const vocabularyTopics = @json($vocabularyTopics->pluck('topic'));
const grammarTopics = @json($grammarTopics->map(function($item) {
    return ['title' => $item->title, 'slug' => $item->slug];
}));

let testIndex = 0;

function addTest() {
    const container = document.getElementById('tests-container');

    let vocabularyOptions = '';
    vocabularyTopics.forEach(topic => {
        vocabularyOptions += `<option value="${topic}">${topic}</option>`;
    });

    let grammarOptions = '';
    grammarTopics.forEach(topic => {
        grammarOptions += `<option value="${topic.title}">${topic.title}</option>`;
    });

    const html = `
        <div class="test-item card border mb-3" data-index="${testIndex}">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <strong class="text-primary">Тест</strong>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeTest(this)">
                    <i class="bi bi-trash me-1"></i>Удалить
                </button>
            </div>
            <div class="card-body">
                <input type="hidden" name="lessons[${testIndex}][type]" value="test">
                <div class="row">
                    <div class="col-md-7">
                        <label class="form-label small text-muted">Выберите тему для теста</label>
                        <select class="form-select" name="lessons[${testIndex}][topic]" required onchange="updatePreview(this)">
                            <option value="">-- Выберите тему --</option>
                            <optgroup label="Словарь">
                                ${vocabularyOptions}
                            </optgroup>
                            <optgroup label="Грамматика">
                                ${grammarOptions}
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Дата выполнения</label>
                        <input type="date" class="form-control date-input" name="lessons[${testIndex}][due_date]" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small text-muted">Порядок</label>
                        <input type="number" class="form-control order-input" name="lessons[${testIndex}][order]" value="${testIndex + 1}" required>
                    </div>
                </div>
                <div class="preview-info mt-2 small text-muted"></div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
    testIndex++;
    document.getElementById('emptyTestsAlert').style.display = 'none';
}

function removeTest(button) {
    button.closest('.test-item').remove();
    updateOrderNumbers();
    if (document.querySelectorAll('.test-item').length === 0) {
        document.getElementById('emptyTestsAlert').style.display = 'block';
    }
}

function updateOrderNumbers() {
    const tests = document.querySelectorAll('.test-item');
    tests.forEach((test, index) => {
        const orderInput = test.querySelector('.order-input');
        if (orderInput) {
            orderInput.value = index + 1;
        }
    });
}

function updatePreview(select) {
    const selectedOption = select.options[select.selectedIndex];
    const previewDiv = select.closest('.test-item').querySelector('.preview-info');
    if (selectedOption.value) {
        previewDiv.innerHTML = `<i class="bi bi-check-circle text-success me-1"></i>Выбрано: ${selectedOption.text}`;
    } else {
        previewDiv.innerHTML = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    updateOrderNumbers();

    document.querySelectorAll('.test-item select').forEach(select => {
        if (select.value) {
            updatePreview(select);
        }
    });
});
</script>

<style>
.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #e9ecef;
    margin-bottom: 1.5rem;
}

.test-item {
    transition: all 0.2s ease;
}

.test-item:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.form-control:focus, .date-input:focus, .form-select:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 0 2px rgba(1, 33, 104, 0.1);
}
</style>
@endsection