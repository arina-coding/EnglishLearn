@extends('layouts.app')

@section('title', 'Вход для преподавателей - EnglishLearn')

@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="auth-card">
                    <div class="auth-header text-center">
                        <h1 class="auth-title">Вход для преподавателей</h1>
                        <p class="auth-subtitle">Войдите в преподавательский аккаунт</p>
                    </div>

                    <div class="auth-body">
                        @if($errors->any())
                            <div class="alert alert-danger auth-alert">
                                <i class="bi bi-exclamation-circle me-2"></i>
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('teacher.login') }}" class="auth-form" novalidate>
                            @csrf

                            <div class="form-group">
                                <label for="email" class="form-label">Email адрес</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email') }}" required
                                           placeholder="teacher@school.edu">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">Пароль</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           id="password" name="password" required
                                           placeholder="Введите ваш пароль">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-options">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">Запомнить меня</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-auth btn-primary w-100">
                                Войти как преподаватель
                            </button>
                        </form>

                        <div class="auth-footer text-center">
                            <p class="mb-2">
                                Нет преподавательского аккаунта?
                                <a href="{{ route('teacher.register') }}" class="auth-link">Зарегистрироваться</a>
                            </p>
                            <p class="mb-0">
                                Вы студент?
                                <a href="{{ route('login') }}" class="auth-link">Войти в студенческий аккаунт</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection