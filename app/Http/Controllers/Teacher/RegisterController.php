<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;// метод для работы с http запросами
use Illuminate\Support\Facades\Hash;// фасад для работы с хешом паролей
use Illuminate\Support\Facades\Auth;// фасад для работы с аутентификацией
use App\Models\User;

class RegisterController extends Controller
{
    // Показ формы регистрации для учителей
    public function showRegistrationForm()
    {
        return view('teacher.auth.register');
    }

    // Обработка регистрации
    public function register(Request $request)
    {
        // Валидация данных
        $validatedData = $request->validate([
            'last_name' => ['required', 'string', 'max:255', 'regex:/^[\p{Cyrillic}a-zA-Z\s\-]+$/u'],
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[\p{Cyrillic}a-zA-Z\s\-]+$/u'],
            'middle_name' => ['nullable', 'string', 'max:255', 'regex:/^[\p{Cyrillic}a-zA-Z\s\-]+$/u'],// не обязательное поле
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],// должно быть уникальным в таблице users
            'password' => ['required', 'string', 'min:8', 'confirmed'],// должно совпадать с полем password_confirmation
            'city' => ['required', 'string', 'max:255'],
            'school' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
        ], [
            'last_name.regex' => 'Фамилия может содержать только буквы, пробелы и дефисы.',
            'first_name.regex' => 'Имя может содержать только буквы, пробелы и дефисы.',
            'middle_name.regex' => 'Отчество может содержать только буквы, пробелы и дефисы.',
        ]);

        // Создание пользователя-учителя
        $user = User::create([ // статический метод модели users для создания новой записи
            //trim удаляет пробелы в начале и в конце строки(собираем фио, отчество или пустая строка) "Васильев Вася Васечкин"
            'name' => trim($validatedData['last_name'] . ' ' . $validatedData['first_name'] . ' ' . ($validatedData['middle_name'] ?? '')),
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),//хеширование паролей
            'role' => 'teacher',
            'city' => $validatedData['city'],
            'school' => $validatedData['school'],
            'description' => $validatedData['description'],
        ]);

        // Авторизация
        Auth::login($user);// принимает пользователя, создает сессию, делает авторизированным

        // Перенаправление в личный кабинет учителя
        return redirect()->route('teacher.dashboard')
        ->with('success', 'Регистрация прошла успешно! Добро пожаловать в систему для преподавателей.');// флеш-сообщение ('ключ', 'текст сообщения')
    }
}