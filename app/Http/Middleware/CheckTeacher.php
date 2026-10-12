<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckTeacher
{
    public function handle(Request $request, Closure $next)
    //Closure- анонимная функция, которая может захватывать переменные из той области видимости, где она была создана, даже после выхода из нее.для захвата исп. кл. слово use
    {
        // если не авторизован
        if (!Auth::check()) {// Auth::check()- проверка на авторизацию
            return redirect()->route('teacher.login');
        }

        // Получаем пользователя
        $user = Auth::user();

        // Является ли пользователь учителем
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Доступ запрещен. Только для преподавателей.');
        }

        return $next($request);
    }
}