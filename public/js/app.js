document.addEventListener("DOMContentLoaded", function () {
    initPage();
});

function initPage() {
    const path = window.location.pathname;

    if (path === "/" || path === "/home") {
        initHomePage();
    } else if (path.includes("/vocabulary")) {
        initVocabularyPage();
    } else if (path.includes("/words")) {
        initWordsPage();
    } else if (path.includes("/test")) {
        initTestPage();
    }

    initCommonAnimations();
    initSmoothScroll();
    initNavbarScroll();
    initBurgerMenu();
}

function initHomePage() {
    animateStats();
    initFloatingCards();
    initFeatureCards();
    initBenefitsAnimation();
}

function initVocabularyPage() {
    animateCategories();
}

function initWordsPage() {
    animateWordCards();
}

function initTestPage() {
    animateTestCards();
    focusFirstInput();
}

// Анимации
function initCommonAnimations() {
    const animatedElements = document.querySelectorAll(
        ".feature-card, .stat-card, .category-card, .word-card, .step, .benefit-item",
    );

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add(
                        "animate__animated",
                        "animate__fadeInUp",
                    );
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1 },
    );

    animatedElements.forEach((el) => observer.observe(el));
}

// Анимация домашней страницы
function animateStats() {
    const statNumbers = document.querySelectorAll(".stat-number[data-count]");

    statNumbers.forEach((stat) => {
        const target = parseInt(stat.getAttribute("data-count"));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;

        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            stat.textContent = Math.floor(current);
        }, 16);
    });
}

function initFloatingCards() {
    const cards = document.querySelectorAll(".floating-card");
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.3}s`;
    });
}

function initFeatureCards() {
    const features = document.querySelectorAll(".feature-card");
    features.forEach((feature, index) => {
        feature.style.animationDelay = `${index * 0.2}s`;
    });
}

function initBenefitsAnimation() {
    const benefits = document.querySelectorAll(".benefit-item");
    benefits.forEach((benefit, index) => {
        benefit.style.animationDelay = `${index * 0.1}s`;
    });
}

// Анимация словаря
function animateCategories() {
    const categories = document.querySelectorAll(".category-card");

    categories.forEach((category, index) => {
        category.style.opacity = "0";
        category.style.transform = "translateY(40px) scale(0.95)";

        setTimeout(() => {
            category.style.transition =
                "all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)";
            category.style.opacity = "1";
            category.style.transform = "translateY(0) scale(1)";
        }, index * 150);
    });

    // Эффекты наведения курсора
    categories.forEach((category) => {
        if (category.classList.contains("category-empty")) return;

        category.addEventListener("mouseenter", function () {
            this.style.transform = "translateY(-5px) scale(1.02)";
        });

        category.addEventListener("mouseleave", function () {
            this.style.transform = "translateY(0) scale(1)";
        });
    });
}

// Анимация слов
function animateWordCards() {
    const cards = document.querySelectorAll(".word-card");

    cards.forEach((card, index) => {
        card.style.opacity = "0";
        card.style.transform = "scale(0.9) translateY(20px)";

        setTimeout(() => {
            card.style.transition = "all 0.5s ease";
            card.style.opacity = "1";
            card.style.transform = "scale(1) translateY(0)";
        }, index * 100);
    });
}

// Тестовые анимации
function animateTestCards() {
    const cards = document.querySelectorAll(".test-card");

    cards.forEach((card, index) => {
        card.style.opacity = "0";
        card.style.transform = "translateY(20px)";

        setTimeout(() => {
            card.style.transition = "all 0.4s ease";
            card.style.opacity = "1";
            card.style.transform = "translateY(0)";
        }, index * 150);
    });
}

function focusFirstInput() {
    const firstInput = document.querySelector('input[type="text"]');
    if (firstInput) {
        setTimeout(() => firstInput.focus(), 500);
    }
}

// Бургер меню
function initBurgerMenu() {
    const navbarToggler = document.querySelector(".navbar-toggler");
    const navbarCollapse = document.querySelector(".navbar-collapse");

    if (navbarToggler && navbarCollapse) {
        navbarToggler.addEventListener("click", function () {
            navbarCollapse.classList.toggle("show");
        });

        const navLinks = document.querySelectorAll(".nav-link");
        navLinks.forEach((link) => {
            link.addEventListener("click", () => {
                if (navbarCollapse.classList.contains("show")) {
                    navbarCollapse.classList.remove("show");
                }
            });
        });

        document.addEventListener("click", function (event) {
            const isClickInsideNavbar = document
                .querySelector(".navbar")
                .contains(event.target);
            if (
                !isClickInsideNavbar &&
                navbarCollapse.classList.contains("show")
            ) {
                navbarCollapse.classList.remove("show");
            }
        });
    }
}

function flipCard(card) {
    card.classList.toggle("flipped");
}

function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            }
        });
    });
}

function initNavbarScroll() {
    const navbar = document.querySelector(".navbar");
    if (!navbar) return;

    window.addEventListener("scroll", function () {
        if (window.scrollY > 50) {
            navbar.style.background = "rgba(255, 255, 255, 0.98)";
            navbar.style.boxShadow = "0 5px 20px rgba(0, 0, 0, 0.1)";
            navbar.style.padding = "8px 0";
        } else {
            navbar.style.background = "rgba(255, 255, 255, 0.95)";
            navbar.style.boxShadow = "0 2px 20px rgba(0, 0, 0, 0.1)";
            navbar.style.padding = "12px 0";
        }
    });
}

window.flipCard = flipCard;
window.initVocabularyPage = initVocabularyPage;
window.initWordsPage = initWordsPage;
window.initTestPage = initTestPage;

// Анимация страниц авторизации
function initAuthPage() {
    const inputs = document.querySelectorAll(".form-control");
    inputs.forEach((input) => {
        input.addEventListener("focus", function () {
            this.parentElement.classList.add("focused");
        });

        input.addEventListener("blur", function () {
            if (!this.value) {
                this.parentElement.classList.remove("focused");
            }
        });
    });

    // Индикатор надёжности пароля (регистрации)
    const passwordInput = document.getElementById("password");
    if (passwordInput) {
        passwordInput.addEventListener("input", function () {
            const strength = calculatePasswordStrength(this.value);
            updatePasswordStrength(strength);
        });
    }
}

function calculatePasswordStrength(password) {
    let strength = 0;

    if (password.length >= 8) strength += 1;
    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 1;
    if (password.match(/\d/)) strength += 1;
    if (password.match(/[^a-zA-Z\d]/)) strength += 1;

    return strength;
}

function updatePasswordStrength(strength) {
    console.log("Password strength:", strength);
}

function initPage() {
    const path = window.location.pathname;

    if (path === "/" || path === "/home") {
        initHomePage();
    } else if (path.includes("/vocabulary")) {
        initVocabularyPage();
    } else if (path.includes("/words")) {
        initWordsPage();
    } else if (path.includes("/test")) {
        initTestPage();
    } else if (path.includes("/login") || path.includes("/register")) {
        initAuthPage();
    }

    initCommonAnimations();
    initSmoothScroll();
    initNavbarScroll();
    initBurgerMenu();
}
