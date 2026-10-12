<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // фасад используется для работы с аутентификацией получения текущего пользователя, проверки, авторизован ли он
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\GrammarController;
use App\Http\Controllers\Teacher\AuthController as TeacherAuthController; // используется алиас- временно переименовать контроллер для избежания конфликта
use App\Http\Controllers\Teacher\RegisterController as TeacherRegisterController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Student\CurriculumController as StudentCurriculumController;

// Главная страница
Route::get('/', function () { // на HTTP-запрос типа GET по адресу / будет выполнено то, что идет вторым параметром
    return view('welcome');// функция view() возвращает шаблон welcome.blade.php
})->name('home'); // присваивает маршруту уникальное имя


// Маршруты аутентификации
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');// показ формы входа
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');// Обработка попытки входа
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // выход из системы


// Маршруты регистрации
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');// Показ формы регистрации
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit'); // Обработка регистрации


// Защищенные маршруты- для авторизованных пользователей
Route::middleware(['auth', 'update.streak'])->group(function () {// используем миделвееры

    // Личный кабинет студента
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // задания студента
    Route::get('/my-tasks', [StudentCurriculumController::class, 'index'])->name('student.tasks');


    // Маршруты для работы со словарем
    Route::get('/vocabulary', [WordController::class, 'index'])->name('vocabulary'); // списки всех тем
    Route::get('/vocabulary/{topic}', [WordController::class, 'showTopic'])->name('vocabulary.topic'); // слова конкретной темы
    Route::get('/vocabulary/test/{topic}', [WordController::class, 'test'])->name('test'); // тест
    Route::post('/vocabulary/check-test', [WordController::class, 'checkTest'])->name('check.test');// результат теста

    // Маршруты для грамматики
    Route::get('/grammar', [GrammarController::class, 'index'])->name('grammar');// все темы
    Route::get('/grammar/{slug}', [GrammarController::class, 'showTopic'])->name('grammar.topic'); // конкретная тема
    Route::get('/grammar/exercise/{slug}', [GrammarController::class, 'exercise'])->name('grammar.exercise'); // упражнения
    Route::post('/grammar/check-exercise', [GrammarController::class, 'checkExercise'])->name('grammar.check');// результат

});


// Маршруты для преподавателей
Route::prefix('teacher')->name('teacher.')->group(function () {

    // Аутентификация
    Route::get('/login', [TeacherAuthController::class, 'showLoginForm'])->name('login');// показ формы входа
    Route::post('/login', [TeacherAuthController::class, 'login']); // обработка формы
    Route::post('/logout', [TeacherAuthController::class, 'logout'])->name('logout');// выход

    // Регистрация
    Route::get('/register', [TeacherRegisterController::class, 'showRegistrationForm'])->name('register'); // показ формы регистрации
    Route::post('/register', [TeacherRegisterController::class, 'register']);// обработка формы
});


// Защищенные маршруты для преподавателей
Route::middleware(['auth', 'teacher'])->prefix('teacher')->name('teacher.')->group(function () { //auth- проверяет, что пользователь вообще залогинен, teacher- проверяет, что залогиненный пользователь именно учитель

    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');// Личный кабинет преподавателя

    Route::get('/students/{id}', [TeacherDashboardController::class, 'showStudent'])->name('student');// Управление студентами

    // Управление классами
    Route::resource('classes', \App\Http\Controllers\Teacher\ClassController::class);
    Route::post('/classes/{id}/add-student', [\App\Http\Controllers\Teacher\ClassController::class, 'addStudent'])->name('classes.add-student');
    Route::delete('/classes/{classId}/remove-student/{studentId}', [\App\Http\Controllers\Teacher\ClassController::class, 'removeStudent'])->name('classes.remove-student');

    Route::resource('curricula', \App\Http\Controllers\Teacher\CurriculumController::class);
});