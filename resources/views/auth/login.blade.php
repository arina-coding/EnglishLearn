@extends('layouts.app')

@section('title', 'Вход в систему - EnglishLearn')

@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="auth-card">
                    <!-- Заголовок -->
                    <div class="auth-header text-center">
                        <h1 class="auth-title">Вход в систему</h1>
                        <p class="auth-subtitle">Войдите в свой аккаунт</p>
                    </div>

                    <!-- Форма -->
                    <div class="auth-body">
                        @if($errors->any())
                            <div class="alert alert-danger auth-alert">
                                <i class="bi bi-exclamation-circle me-2"></i>
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        @if(session('status'))
                            <div class="alert alert-success auth-alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="auth-form" novalidate>
                            @csrf

                            <div class="form-group">
                                <label for="email" class="form-label">Email адрес</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email') }}" required
                                           placeholder="your@email.com">
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
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="forgot-password">Забыли пароль?</a>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-auth btn-primary w-100">
                                Войти в аккаунт
                            </button>
                        </form>

                        <div class="auth-footer text-center">
                            <p class="mb-0">
                                Еще нет аккаунта?
                                <a href="{{ route('register') }}" class="auth-link">Зарегистрируйтесь</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection