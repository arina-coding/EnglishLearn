<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EnglishLearn - Интерактивная платформа для изучения английского языка</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-translate me-2"></i>EnglishLearn
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Переключить навигацию">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Возможности</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#methodology">Методика</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#stats">Результаты</a>
                    </li>
                </ul>

                <div class="d-flex navbar-actions">
                    @auth
                        @if(Auth::user()->isTeacher())
                            <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-primary me-2">
                                <i class="bi bi-speedometer2 me-1"></i>Панель преподавателя
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary me-2">
                                <i class="bi bi-person-circle me-1"></i>Кабинет
                            </a>
                        @endif
                        <form method="POST" action="{{ Auth::user()->isTeacher() ? route('teacher.logout') : route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="bi bi-box-arrow-right me-1"></i>Выйти
                            </button>
                        </form>
                    @else
                        <div class="dropdown me-2">
    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
        <i class="bi bi-box-arrow-in-right me-1"></i>Войти
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{ route('login') }}"><i class="bi bi-person me-2"></i>Как студент</a></li>
        <li><a class="dropdown-item" href="{{ route('teacher.login') }}"><i class="bi bi-person-badge me-2"></i>Как преподаватель</a></li>
    </ul>
</div>
<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
        <i class="bi bi-person-plus me-1"></i>Регистрация
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{ route('register') }}"><i class="bi bi-person me-2"></i>Как студент</a></li>
        <li><a class="dropdown-item" href="{{ route('teacher.register') }}"><i class="bi bi-person-badge me-2"></i>Как преподаватель</a></li>
    </ul>
</div>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="animated-background">
            <span></span><span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span><span></span>
        </div>

        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-badge animate__animated animate__fadeInDown">
                        <i class="bi bi-star-fill me-2"></i>Эффективное изучение английского
                    </div>
                    <h1 class="hero-title animate__animated animate__fadeInUp">
                        Английский язык<br>
                        <span class="hero-accent">станет проще</span>
                    </h1>
                    <p class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">
                        Интерактивные уроки, карточки и персональная статистика
                        для эффективного изучения языка в удобном темпе
                    </p>
                    <div class="hero-stats animate__animated animate__fadeInUp animate__delay-1s">
                        <div class="stat-item">
                            <div class="stat-number">15 мин</div>
                            <div class="stat-label">в день</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">90%</div>
                            <div class="stat-label">эффективность</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">2000+</div>
                            <div class="stat-label">слов</div>
                        </div>
                    </div>
                    <div class="hero-actions animate__animated animate__fadeInUp animate__delay-2s">
                    <a href="{{ route('register') }}" class="btn btn-hero btn-primary-hero me-3">
                        <i class="bi bi-rocket-takeoff me-2"></i>Начать бесплатно
                    </a>
                    <a href="#features" class="btn btn-hero btn-outline-hero">
                        <i class="bi bi-eye me-2"></i>Посмотреть возможности
                    </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-visual animate__animated animate__fadeInRight">
                        <div class="floating-card card-1">
                            <i class="bi bi-book"></i>
                            <span>Словарь</span>
                        </div>
                        <div class="floating-card card-2">
                            <i class="bi bi-journal-text"></i>
                            <span>Грамматика</span>
                        </div>
                        <div class="floating-card card-3">
                            <i class="bi bi-graph-up"></i>
                            <span>Прогресс</span>
                        </div>
                        <div class="main-visual">
                            <div class="visual-content">
                                <i class="bi bi-laptop"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="benefits-section">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-10">
                    <h3 class="benefits-title">Почему выбирают EnglishLearn?</h3>
                    <div class="benefits-grid">
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="bi bi-clock"></i>
                            </div>
                            <h5>Учитесь в любое время</h5>
                            <p>Доступ к платформе 24/7 с любого устройства</p>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <h5>Быстрый прогресс</h5>
                            <p>Эффективная методика для заметных результатов</p>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="bi bi-book"></i>
                            </div>
                            <h5>Структурированное обучение</h5>
                            <p>Четкая программа от простого к сложному</p>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <h5>Интерактивные упражнения</h5>
                            <p>Тесты, карточки и игры для лучшего запоминания материала</p>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="bi bi-award"></i>
                            </div>
                            <h5>Мотивирующая система</h5>
                            <p>Достижения и отслеживание прогресса</p>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="bi bi-gift"></i>
                            </div>
                            <h5>Бесплатный доступ</h5>
                            <p>Все основные функции доступны без ограничений и оплаты</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="features-section">
        <div class="container">
            <div class="section-header text-center">
                <h2>Все необходимое для успешного изучения</h2>
                <p class="section-subtitle">Комплексный подход к изучению английского языка</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon bg-primary">
                            <i class="bi bi-book"></i>
                        </div>
                        <h4>Интерактивный словарь</h4>
                        <p>Изучайте слова с помощью умных карточек, тестов и ассоциаций</p>
                        <ul class="feature-list">
                            <li><i class="bi bi-check"></i> 2000+ слов с озвучкой</li>
                            <li><i class="bi bi-check"></i> Тематические подборки</li>
                            <li><i class="bi bi-check"></i> Адаптивное повторение</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon bg-success">
                            <i class="bi bi-journal-text"></i>
                        </div>
                        <h4>Грамматика</h4>
                        <p>Понятные объяснения и практические упражнения для всех уровней</p>
                        <ul class="feature-list">
                            <li><i class="bi bi-check"></i> 50+ грамматических тем</li>
                            <li><i class="bi bi-check"></i> Интерактивные упражнения</li>
                            <li><i class="bi bi-check"></i> Пошаговое обучение</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon bg-warning">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <h4>Персональная статистика</h4>
                        <p>Отслеживайте прогресс и получайте персонализированные рекомендации</p>
                        <ul class="feature-list">
                            <li><i class="bi bi-check"></i> Детальная аналитика</li>
                            <li><i class="bi bi-check"></i> Цели и достижения</li>
                            <li><i class="bi bi-check"></i> Индивидуальные советы</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="methodology" class="methodology-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="section-header">
                        <h2>Научный подход к обучению</h2>
                        <p>Основано на принципах интервального повторения и когнитивной науки</p>
                    </div>

                    <div class="methodology-steps">
                        <div class="step">
                            <div class="step-number">01</div>
                            <div class="step-content">
                                <h5>Интервальное повторение</h5>
                                <p>Автоматический подбор времени повторения для лучшего запоминания материала</p>
                            </div>
                        </div>
                        <div class="step">
                            <div class="step-number">02</div>
                            <div class="step-content">
                                <h5>Активное вспоминание</h5>
                                <p>Тесты и упражнения укрепляют нейронные связи и улучшают память</p>
                            </div>
                        </div>
                        <div class="step">
                            <div class="step-number">03</div>
                            <div class="step-content">
                                <h5>Адаптивное обучение</h5>
                                <p>Сложность заданий автоматически подстраивается под ваш прогресс</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="methodology-visual">
                        <div class="science-animation">
                            <div class="animation-item brain">
                                <i class="bi bi-cpu"></i>
                            </div>
                            <div class="animation-item memory">
                                <i class="bi bi-lightning"></i>
                            </div>
                            <div class="animation-item progress">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <div class="animation-center">
                                <div class="center-content">
                                    <i class="bi bi-mortarboard"></i>
                                    <span>85%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="stats" class="stats-section">
        <div class="container">
            <div class="section-header text-center">
                <h2>Наши результаты</h2>
                <p class="section-subtitle">Тысячи студентов уже улучшили свой английский с нами</p>
            </div>
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-book"></i>
                        </div>
                        <div class="stat-number" data-count="2000">0</div>
                        <p class="stat-label">Слов в словаре</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-journal-text"></i>
                        </div>
                        <div class="stat-number" data-count="50">0</div>
                        <p class="stat-label">Тем грамматики</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <div class="stat-number" data-count="1000">0</div>
                        <p class="stat-label">Активных студентов</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-award"></i>
                        </div>
                        <div class="stat-number" data-count="98">0</div>
                        <p class="stat-label">% удовлетворения</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <div class="cta-card">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h2>Готовы начать изучение английского?</h2>
                        <p class="cta-text">Присоединяйтесь к тысячам студентов, которые уже добились успеха с EnglishLearn</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                            <i class="bi bi-rocket-takeoff me-2"></i>Начать сейчас
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5><i class="bi bi-translate me-2"></i>EnglishLearn</h5>
                    <p>Инновационная платформа для эффективного изучения английского языка</p>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h6>Разделы</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('vocabulary') }}">Словарь</a></li>
                        <li><a href="{{ route('grammar') }}">Грамматика</a></li>
                        <li><a href="{{ route('dashboard') }}">Статистика</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h6>О проекте</h6>
                    <ul class="list-unstyled">
                        <li><a href="#features">Возможности</a></li>
                        <li><a href="#methodology">Методика</a></li>
                        <li><a href="#stats">Результаты</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4 mb-4">
                    <h6>Контакты</h6>
                    <p><i class="bi bi-envelope me-2"></i> support@englishlearn.ru</p>
                </div>
            </div>
            <div class="footer-bottom text-center">
                <p>&copy; 2026 EnglishLearn. Все права защищены.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>