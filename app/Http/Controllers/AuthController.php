<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // фасад используется для работы с аутентификацией получения текущего пользователя, проверки, авторизован ли он
use Illuminate\Support\Facades\Hash; // хеширование паролей
use App\Models\User; // модель для работы с таблицей Users

class AuthController extends Controller
{
    // Показ формы входа
    public function showLoginForm()
    {
        return view('auth.login');// функция view() возвращает шаблон auth\login.blade.php
    }

    // Обработка попытки входа
    public function login(Request $request)
    {
        // Валидация данных
        $credentials = $request->validate([
            'email' => ['required', 'email'], // обязательное поле должно быть  email
            'password' => ['required', 'min:8'],// обязательное поле должно быть не меньшу 8 символов
        ]);

        // Попытка аутентификации

        // Auth::attempt()- метод проверяет, соответствуют ли переданные данные пользователю в базе данных. Если да- регистрирует пользователя и сохраняет его сессию. Если нет метод возвращает false- аутентификация не удалась.
        // $request->remember- флаг "Запомнить меня", если true- создает долгосрочную сессию.
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate(); // regenerate()- метод сессии создает новый ID сессии взамен старого, защита от хакера

            // Проверяем, не преподаватель ли это
            if (Auth::user()->role === 'teacher') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Используйте форму входа для преподавателей.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            //redirect()- функция-помощник создает объект для перенаправления
            //intended()- метод редиректа	перенаправляет на URL
            return redirect()->intended('/dashboard'); // Перенаправление куда планировали

            return back()->withErrors([
                'email' => 'Неверный email или пароль.',
            ])->onlyInput('email');
        }

        // Если аутентификация не удалась
        // back() функция-помощник перенаправляет на предыдущую страницу (откуда пришел запрос)
        // withErrors()	Метод добавляет ошибки в сессию для отображения в форме
        // [...] Массив содержит ошибки: ['email' => 'текст ошибки']
        // onlyInput()	Метод сохраняет только указанные поля из старого запроса
        // 'email'	Строка имя поля, которое нужно сохранить
        return back()->withErrors([
            'email' => 'Неверный email или пароль.',
        ])->onlyInput('email');
    }

    // Выход из системы
    public function logout(Request $request)
    {
        Auth::logout();// logiut()- метод который удаляет авторизацию
        $request->session()->invalidate();// invalidate()- полностью уничтожает все данные сессии
        $request->session()->regenerateToken();// regenerateToken()- создает новый csrf
        return redirect('/');// перенаправление на главную страницу
    }
}
?>



