@extends('layouts.app')

@section('title', 'Учебные планы')

@section('content')
<div class="dashboard-container">
    <div class="container">
        <div class="dashboard-header">
            <div class="welcome-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="welcome-title">
                            <i class="bi bi-calendar-week me-2"></i>Учебные планы
                        </h1>
                        <p class="welcome-subtitle">
                            Управление планами обучения для классов
                        </p>
                    </div>
                        <a href="{{ route('teacher.curricula.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Создать план
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
            @if(count($curricula) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Класс</th>
                                <th>Период</th>
                                <th>Уроков</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($curricula as $curriculum)
                            <tr>
                                <td>{{ $curriculum->title }}</td>
                                <td>{{ $curriculum->class->name }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($curriculum->start_date)->format('d.m.Y') }}
                                    @if($curriculum->end_date)
                                        - {{ \Carbon\Carbon::parse($curriculum->end_date)->format('d.m.Y') }}
                                    @endif
                                </td>
                                <td>{{ $curriculum->lessons->count() }}</td>
                                <td>
                                    <span class="badge bg-{{ $curriculum->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ $curriculum->status == 'active' ? 'Активен' : 'Завершен' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('teacher.curricula.show', $curriculum->id) }}" class="btn-curricula-view">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('teacher.curricula.edit', $curriculum->id) }}" class="btn-curricula-edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('teacher.curricula.destroy', $curriculum->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-curricula-delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state text-center py-5">
                    <div class="empty-icon">
                        <i class="bi bi-calendar-plus fs-1"></i>
                    </div>
                    <h4>У вас пока нет учебных планов</h4>
                    <p>Создайте план, чтобы назначить темы для студентов</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection