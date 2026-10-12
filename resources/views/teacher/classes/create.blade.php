@extends('layouts.app')

@section('title', 'Создание класса - Панель преподавателя')

@section('content')
<div class="dashboard-container">
    <div class="container">
        <div class="dashboard-header">
            <div class="welcome-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="welcome-title">
                            <i class="bi bi-plus-circle me-2"></i>Создание нового класса
                        </h1>
                        <p class="welcome-subtitle">
                            Создайте группу или класс для ваших студентов
                        </p>
                    </div>
                    <a href="{{ route('teacher.classes.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Назад к списку
                    </a>
                </div>
            </div>
        </div>

        <div class="dashboard-section">
            <form method="POST" action="{{ route('teacher.classes.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="name" class="form-label">Название класса/группы *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required
                                   placeholder="Например: ИС-3-22">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Описание</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4"
                                      placeholder="Краткое описание класса">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Как добавить студентов?</strong><br>
                            После создания класса вы сможете добавлять студентов по их email адресу.
                            Студент должен быть предварительно зарегистрирован на платформе.
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="student_emails" class="form-label">Email студентов</label>
                    <textarea class="form-control" id="student_emails" name="student_emails" rows="2" placeholder="student1@example.com, student2@example.com"></textarea>

                </div>

                <div class="border-top pt-4 mt-4">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('teacher.classes.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>Отмена
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Создать класс
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection