<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;//класс для работы с http запросами
use Illuminate\Support\Facades\Auth;//фасад для работы с аутентификацией
use Illuminate\Support\Facades\Hash; // хеширование паролей
use App\Models\User; 

class AuthController extends Controller
{
    // Показ формы входа для учителей
    public function showLoginForm()
    {
        return view('teacher.auth.login');// метод view показывает страницу
    }

    // Обработка попытки входа
    public function login(Request $request)
    {
        $credentials = $request->validate([// из объекта запроса request проверяем данные
            'email' => ['required', 'email'], // обязательное, email
            'password' => ['required','min:8'],// обязательное, мин 8
        ]);

        // Является ли пользователь учителем
        $user = User::where('email', $credentials['email'])->first();//в переменную кладем из модели user проверку, где email = email который ввел польз. и берем первого найденного польз.
        // SELECT * FROM users WHERE email = 'vasia@mail.ru' LIMIT 1

        if (!$user || !Hash::check($credentials['password'], $user->password)) { // если пользователь не найден или пароль не совпадает(проверка через хеш)
            return back()->withErrors([// возвращает на предыдущую страницу с методом додбавляющим ошибки 
                'email' => 'Неверный email или пароль.',
            ])->onlyInput('email');// сохраняет поле при ошибке
        }

        if ($user->role !== 'teacher') { // проверка на роль преподавателя
            return back()->withErrors([
                'email' => 'Доступ разрешен только для преподавателей.',
            ])->onlyInput('email');
        }

        // Входв систему
        Auth::login($user, $request->remember);// принудительно входит пользователем без проверки пароля(пользоват. от имени которого входим, если true создает долгосрочную сессию)
        $request->session()->regenerate();// regenerate() создает новый ID сессии,старый уничтожает, защита от хакеры

        return redirect()->route('teacher.dashboard');// перенаправление на главную страницу
    }

    // Выход из системы
    public function logout(Request $request)
    {
        Auth::logout();// удаление авторизации (информацию о польз. из сессии, даные аутентификации)
        $request->session()->invalidate();// уничтожает всю сессию(корзину, сообщения, ошибки)
        $request->session()->regenerateToken();// создает новый csrf токен

        return redirect()->route('teacher.login');// перенапрвление на страницу входа
    }
}