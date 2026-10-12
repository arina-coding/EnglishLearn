<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - EnglishLearn</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">

    <style>
        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 400;
            src: local('Montserrat Regular'), local('Montserrat-Regular'),
                 url('{{ asset("fonts/montserrat-regular.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 500;
            src: local('Montserrat Medium'), local('Montserrat-Medium'),
                 url('{{ asset("fonts/montserrat-medium.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 600;
            src: local('Montserrat SemiBold'), local('Montserrat-SemiBold'),
                 url('{{ asset("fonts/montserrat-semibold.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 700;
            src: local('Montserrat Bold'), local('Montserrat-Bold'),
                 url('{{ asset("fonts/montserrat-bold.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: 800;
            src: local('Montserrat ExtraBold'), local('Montserrat-ExtraBold'),
                 url('{{ asset("fonts/montserrat-extrabold.ttf") }}') format('truetype');
        }


    </style>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translate3d(0, 40px, 0); }
            to { opacity: 1; transform: translate3d(0, 0, 0); }
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translate3d(0, -40px, 0); }
            to { opacity: 1; transform: translate3d(0, 0, 0); }
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translate3d(40px, 0, 0); }
            to { opacity: 1; transform: translate3d(0, 0, 0); }
        }
        @keyframes slideInLeft {
            from { transform: translate3d(-100%, 0, 0); visibility: visible; }
            to { transform: translate3d(0, 0, 0); }
        }
        .animate__animated { animation-duration: 1s; animation-fill-mode: both; }
        .animate__fadeInUp { animation-name: fadeInUp; }
        .animate__fadeInDown { animation-name: fadeInDown; }
        .animate__fadeInRight { animation-name: fadeInRight; }
        .animate__slideInLeft { animation-name: slideInLeft; }
        .animate__delay-1s { animation-delay: 0.3s; }
        .animate__delay-2s { animation-delay: 0.6s; }
    </style>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vocabulary.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-translate me-2"></i>EnglishLearn
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        @if(Auth::user()->isTeacher())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('teacher.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-1"></i>Панель преподавателя
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('teacher.classes.index') }}">
                                    <i class="bi bi-people me-1"></i>Мои классы
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('teacher.curricula.index') }}">
                                    <i class="bi bi-calendar-week me-1"></i>Учебные планы
                                </a>
                            </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('vocabulary') }}">
                                        <i class="bi bi-book me-1"></i>Словарь
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('grammar') }}">
                                        <i class="bi bi-journal-text me-1"></i>Грамматика
                                    </a>
                                </li>
                            <li class="nav-item d-lg-none">
                                <form method="POST" action="{{ route('teacher.logout') }}">
                                    @csrf
                                    <button type="submit" class="nav-link bg-transparent border-0 w-100 text-start" style="color: #dc3545;">
                                        <i class="bi bi-box-arrow-right me-1"></i>Выйти
                                    </button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">
                                    <i class="bi bi-person-circle me-1"></i>Личный кабинет
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('student.tasks') }}">
                                    <i class="bi bi-calendar-check me-1"></i>Мои задания
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('vocabulary') }}">
                                    <i class="bi bi-book me-1"></i>Словарь
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('grammar') }}">
                                    <i class="bi bi-journal-text me-1"></i>Грамматика
                                </a>
                            </li>
                            <li class="nav-item d-lg-none">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="nav-link bg-transparent border-0 w-100 text-start" style="color: #dc3545;">
                                        <i class="bi bi-box-arrow-right me-1"></i>Выйти
                                    </button>
                                </form>
                            </li>
                        @endif
                    @else
                        <li class="nav-item d-lg-none">
                            <div class="nav-link text-muted fw-bold border-bottom pb-2 mb-2">Вход</div>
                        </li>
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-person me-2"></i>Вход как студент
                            </a>
                        </li>
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" href="{{ route('teacher.login') }}">
                                <i class="bi bi-person-badge me-2"></i>Вход как преподаватель
                            </a>
                        </li>
                        <li class="nav-item d-lg-none">
                            <div class="nav-link text-muted fw-bold border-bottom pb-2 mb-2 mt-2">Регистрация</div>
                        </li>
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="bi bi-person me-2"></i>Регистрация студента
                            </a>
                        </li>
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" href="{{ route('teacher.register') }}">
                                <i class="bi bi-person-badge me-2"></i>Регистрация преподавателя
                            </a>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link" href="#features">Возможности</a>
                        </li>
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link" href="#methodology">Методика</a>
                        </li>
                    @endauth
                </ul>

                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown d-none d-lg-block">
                            <a class="nav-link " href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ Auth::user()->isTeacher() ? route('teacher.logout') : route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-2"></i>Выйти
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item dropdown d-none d-lg-block">
                            <a class="nav-link " href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Войти
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('login') }}">
                                        <i class="bi bi-person me-2"></i>Как студент
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('teacher.login') }}">
                                        <i class="bi bi-person-badge me-2"></i>Как преподаватель
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown d-none d-lg-block">
                            <a class="nav-link " href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-plus me-1"></i>Регистрация
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('register') }}">
                                        <i class="bi bi-person me-2"></i>Как студент
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('teacher.register') }}">
                                        <i class="bi bi-person-badge me-2"></i>Как преподаватель
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-4 mb-4">
                    <h5><i class="bi bi-translate me-2"></i>EnglishLearn</h5>
                    <p>Интерактивная платформа для изучения английского языка</p>
                </div>
                <div class="col-md-2 mb-4">
                    <h6>Для студентов</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('vocabulary') }}">Словарь</a></li>
                        <li><a href="{{ route('grammar') }}">Грамматика</a></li>
                        <li><a href="{{ route('dashboard') }}">Личный кабинет</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h6>О проекте</h6>
                    <p><i class="bi bi-envelope me-2"></i> support@englishlearn.ru</p>
                </div>
            </div>
            <div class="footer-bottom text-center">
                <p>&copy; {{ date('Y') }} EnglishLearn. Все права защищены.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/vocabulary.js') }}"></script>
</body>
</html>