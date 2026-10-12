<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; //  импортирует класс request для работы с http запросами
use Illuminate\Support\Facades\Auth;// фасад для работы с аутентификацией
use Illuminate\Support\Facades\Hash; // хеширование паролей
use App\Models\User; // импортируем модель юзер

class RegisterController extends Controller
{
    // Показ формы регистрации
    public function showRegistrationForm() 
    {
        return view('auth.register');
    }

    // Обработка регистрации
    public function register(Request $request)
    {
        // Валидация данных
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[\p{Cyrillic}a-zA-Z\s\-]+$/u'],// обязательно, строка, макс длина 255, регулярное выражение
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],// обязательно, строка, email, макс дл 255, не должен сущ в таблице users
            'password' => ['required', 'string', 'min:8', 'confirmed'],// обязательно, строка, мин дл 8, должно совпадать с password_confirmation
        ], [
            'name.regex' => 'Имя может содержать только буквы, пробелы и дефисы.',// кастомное сообщение для регулярного выражения
        ]);

        // Создание пользователя
        $user = User::create([ // статический метод модели юзер для создания новой записи
            'name' => $validatedData['name'], // берем из валидации
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // хешируем. в бд будет храниться не сам пароль а его хеш
        ]);

        // Авторизация
        Auth::login($user); // принимает пользователя $user, создает  сессию, делает авторизированным

        // Перенаправление в личный кабинет
        return redirect('/dashboard')
        ->with('success', 'Добро пожаловать! Регистрация прошла успешно.');// ('ключ', 'текст сообщения')
    }
}