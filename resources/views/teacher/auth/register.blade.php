@extends('layouts.app')

@section('title', 'Регистрация преподавателя - EnglishLearn')

@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="auth-card">
                    <div class="auth-header text-center">
                        <h1 class="auth-title">Регистрация преподавателя</h1>
                        <p class="auth-subtitle">Создайте преподавательский аккаунт</p>
                    </div>

                    <div class="auth-body">
                        <form method="POST" action="{{ route('teacher.register') }}" class="auth-form" novalidate>
                            @csrf

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="last_name" class="form-label">Фамилия *</label>
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                               id="last_name" name="last_name" value="{{ old('last_name') }}" required
                                               placeholder="Васильев">
                                        @error('last_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="first_name" class="form-label">Имя *</label>
                                        <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                               id="first_name" name="first_name" value="{{ old('first_name') }}" required
                                               placeholder="Василий">
                                        @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="middle_name" class="form-label">Отчество</label>
                                        <input type="text" class="form-control @error('middle_name') is-invalid @enderror"
                                               id="middle_name" name="middle_name" value="{{ old('middle_name') }}"
                                               placeholder="Васильевич">
                                        @error('middle_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email адрес *</label>
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
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city" class="form-label">Город *</label>
                                        <select class="form-control @error('city') is-invalid @enderror"
                                                id="city" name="city" required>
                                            <option value="">Выберите город</option>
                                            <option value="Москва" {{ old('city') == 'Москва' ? 'selected' : '' }}>Москва</option>
                                            <option value="Санкт-Петербург" {{ old('city') == 'Санкт-Петербург' ? 'selected' : '' }}>Санкт-Петербург</option>
                                            <option value="Чебоксары" {{ old('city') == 'Чебоксары' ? 'selected' : '' }}>Чебоксары</option>
                                            <option value="Екатеринбург" {{ old('city') == 'Екатеринбург' ? 'selected' : '' }}>Екатеринбург</option>
                                            <option value="Казань" {{ old('city') == 'Казань' ? 'selected' : '' }}>Казань</option>
                                            <option value="Нижний Новгород" {{ old('city') == 'Нижний Новгород' ? 'selected' : '' }}>Нижний Новгород</option>
                                        </select>
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="school" class="form-label">Учебное заведение *</label>
                                        <input type="text" class="form-control @error('school') is-invalid @enderror"
                                               id="school" name="school" value="{{ old('school') }}" required
                                               placeholder="Например: ЧПК">
                                        @error('school')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description" class="form-label">Дополнительная информация</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  id="description" name="description" rows="1"
                                                  placeholder="Краткая информация о себе">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="form-label">Пароль *</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-lock"></i>
                                            </span>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                   id="password" name="password" required
                                                   placeholder="Минимум 8 символов">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation" class="form-label">Подтверждение пароля *</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-lock-fill"></i>
                                            </span>
                                            <input type="password" class="form-control"
                                                   id="password_confirmation" name="password_confirmation" required
                                                   placeholder="Повторите пароль">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror"
                                       id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    Я соглашаюсь с <a href="#" class="auth-link">условиями использования</a>
                                </label>
                                @error('terms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-auth btn-primary w-100">
                                Зарегистрироваться
                            </button>
                        </form>

                        <div class="auth-footer text-center">
                            <p class="mb-2">
                                Уже есть преподавательский аккаунт?
                                <a href="{{ route('teacher.login') }}" class="auth-link">Войти</a>
                            </p>
                            <p class="mb-0">
                                Вы студент?
                                <a href="{{ route('register') }}" class="auth-link">Зарегистрироваться как студент</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection