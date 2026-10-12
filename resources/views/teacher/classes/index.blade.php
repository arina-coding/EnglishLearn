@extends('layouts.app')

@section('title', 'Мои классы - Панель преподавателя')

@section('content')
<div class="dashboard-container">
    <div class="container">
        <div class="dashboard-header">
            <div class="welcome-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="welcome-title">
                            <i class="bi bi-people me-2"></i>Мои классы
                        </h1>
                        <p class="welcome-subtitle">
                            Управление классами и группами студентов
                        </p>
                    </div>
                    <a href="{{ route('teacher.classes.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Создать класс
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="dashboard-section">
    @if(count($classes) > 0)
        <div class="row">
            @foreach($classes as $class)
            <div class="col-md-4 mb-4">
                <div class="class-card">
                    <div class="class-header">
                        <h4>{{ $class->name }}</h4>
                        <span class="badge bg-primary badge-custom">{{ $class->students_count }} студентов</span>
                    </div>
                    <div class="class-body">
                        <p class="class-description">
                            {{ $class->description ?: 'Нет описания' }}
                        </p>
                    </div>
                    <div class="class-footer d-flex gap-2">
    <a href="{{ route('teacher.classes.show', $class->id) }}" class="btn-class-view flex-fill">
        <i class="bi bi-eye me-1"></i> Просмотр
    </a>
    <a href="{{ route('teacher.classes.edit', $class->id) }}" class="btn-class-edit flex-fill">
        <i class="bi bi-pencil me-1"></i> Редактировать
    </a>
    <form method="POST" action="{{ route('teacher.classes.destroy', $class->id) }}" class="flex-fill">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-class-delete w-100" >
            <i class="bi bi-trash me-1"></i> Удалить
        </button>
    </form>
</div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="empty-state text-center py-5">
            <div class="empty-icon">
                <i class="bi bi-people fs-1"></i>
            </div>
            <h4>У вас пока нет классов</h4>
            <p>Создайте первый класс, чтобы начать работу со студентами</p>
        </div>
    @endif
</div>

@endsection