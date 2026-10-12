function initializeTest() {
    updateProgress();

    const firstInput = document.querySelector(".test-input");
    if (firstInput) {
        setTimeout(() => {
            firstInput.focus();
            setActiveQuestion(firstInput.closest(".test-card"));
        }, 500);
    }

    animateTestCards();
}

function setupTestInteractions() {
    const inputs = document.querySelectorAll(".test-input");
    inputs.forEach((input, index) => {
        input.addEventListener("focus", function () {
            setActiveQuestion(this.closest(".test-card"));
        });

        input.addEventListener("keydown", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
                moveToNextInput(this);
            }
        });

        input.addEventListener("input", function () {
            updateProgress();
        });
    });

    // Радио-кнопки
    const radioInputs = document.querySelectorAll('input[type="radio"]');
    radioInputs.forEach((radio) => {
        radio.addEventListener("change", function () {
            updateProgress();
            highlightSelectedOption(this);
        });
    });

    // Отправка формы
    const form = document.getElementById("testForm");
    if (form) {
        form.addEventListener("submit", function (e) {
            const answered = getAnsweredCount();
            const total = getTotalQuestions();

            if (answered < total) {
                const confirmSubmit = confirm(
                    `Вы ответили на ${answered} из ${total} вопросов. Продолжить?`,
                );
                if (!confirmSubmit) {
                    e.preventDefault();
                    return;
                }
            }

            // Состояние загрузки
            const submitBtn = this.querySelector(".btn-test");
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<span class="submit-text">Проверяем ответы...</span>';
            }
        });
    }
}

function getTotalQuestions() {
    return document.querySelectorAll(".test-card").length;
}

function getAnsweredCount() {
    let answered = 0;

    const inputs = document.querySelectorAll(".test-input");
    inputs.forEach((input) => {
        if (input.value.trim() !== "") {
            answered++;
        }
    });

    const checkedRadios = document.querySelectorAll(
        'input[type="radio"]:checked',
    );
    answered += checkedRadios.length;

    return answered;
}

function updateProgress(currentQuestion = null) {
    const total = getTotalQuestions();
    let current = currentQuestion;

    if (currentQuestion === null) {
        current = getAnsweredCount();
    }

    if (current > total) current = total;
    if (current < 0) current = 0;

    const percentage = Math.min((current / total) * 100, 100);

    const progressBar = document.querySelector(".progress-bar");
    if (progressBar) {
        progressBar.style.width = percentage + "%";
        progressBar.setAttribute("aria-valuenow", percentage);
    }

    const progressText = document.querySelector(".progress-text");
    if (progressText) {
        progressText.textContent = `Вопрос ${current} из ${total}`;
    }

    const submitCount = document.querySelector(".submit-count");
    if (submitCount) {
        submitCount.textContent = `(${current} из ${total} отвечено)`;
    }
}

function highlightSelectedOption(radio) {
    const label = radio.nextElementSibling;
    if (label && label.classList.contains("grammar-option-label")) {
        const name = radio.getAttribute("name");
        document.querySelectorAll(`input[name="${name}"]`).forEach((r) => {
            const l = r.nextElementSibling;
            if (l) l.classList.remove("selected");
        });

        label.classList.add("selected");
    }
}

function setActiveQuestion(activeCard) {
    document.querySelectorAll(".test-card").forEach((card) => {
        card.classList.remove("active");
    });

    if (activeCard) {
        activeCard.classList.add("active");
    }
}

function moveToNextInput(currentInput) {
    const inputs = Array.from(document.querySelectorAll(".test-input"));
    const currentIndex = inputs.indexOf(currentInput);

    if (currentIndex < inputs.length - 1) {
        const nextInput = inputs[currentIndex + 1];
        nextInput.focus();
        setActiveQuestion(nextInput.closest(".test-card"));
    }
}

function animateTestCards() {
    const cards = document.querySelectorAll(".test-card");

    cards.forEach((card, index) => {
        card.style.opacity = "0";
        card.style.transform = "translateY(20px)";

        setTimeout(() => {
            card.style.transition = "all 0.5s ease";
            card.style.opacity = "1";
            card.style.transform = "translateY(0)";
        }, index * 150);
    });
}

document.addEventListener("DOMContentLoaded", function () {
    if (document.querySelector(".test-progress")) {
        initializeTest();
        setupTestInteractions();

        document
            .querySelectorAll('input[type="radio"]:checked')
            .forEach((radio) => {
                highlightSelectedOption(radio);
            });

        updateProgress();
    }
});

// Функции для личного кабинета
function initDashboard() {
    if (!document.querySelector(".dashboard-container")) return;

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("animate");
                    observer.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.1,
            rootMargin: "0px 0px -50px 0px",
        },
    );

    document.querySelectorAll(".stat-card").forEach((card) => {
        observer.observe(card);
    });

    document.querySelectorAll(".progress-card").forEach((card) => {
        observer.observe(card);
    });

    document.querySelectorAll(".activity-item").forEach((item) => {
        observer.observe(item);
    });

    const streakBadge = document.querySelector(".streak-badge");
    if (streakBadge) {
        const streakCount = parseInt(streakBadge.textContent);
        if (streakCount >= 3) {
            streakBadge.classList.add("highlight");
        }
    }

    highlightStats();
}

function highlightStats() {
    const statNumbers = document.querySelectorAll(".stat-number");

    statNumbers.forEach((stat) => {
        const value = parseInt(stat.textContent);
        const statCard = stat.closest(".stat-card");

        if (statCard) {
            if (value > 0) {
                statCard.classList.add("has-value");
            }

            if (value >= 90 && stat.textContent.includes("%")) {
                statCard.classList.add("high-value");
            }
        }
    });
}

// Анимация при наведении на карточки действий
function setupActionCards() {
    const actionCards = document.querySelectorAll(".action-card");

    actionCards.forEach((card) => {
        card.addEventListener("mouseenter", function () {
            const arrow = this.querySelector(".action-arrow");
            if (arrow) {
                arrow.style.transform = "translateX(5px)";
                arrow.style.color = "#1976d2";
            }
        });

        card.addEventListener("mouseleave", function () {
            const arrow = this.querySelector(".action-arrow");
            if (arrow) {
                arrow.style.transform = "translateX(0)";
                arrow.style.color = "#adb5bd";
            }
        });
    });
}

// Инициализация при загрузке страницы
document.addEventListener("DOMContentLoaded", function () {
    if (window.location.pathname.includes("/dashboard")) {
        initDashboard();
        setupActionCards();

        animateProgressBars();
    }
});

function animateProgressBars() {
    const progressBars = document.querySelectorAll(".progress-bar");

    progressBars.forEach((bar) => {
        const width = bar.style.width;
        bar.style.width = "0";

        setTimeout(() => {
            bar.style.transition = "width 1s ease-out";
            bar.style.width = width;
        }, 300);
    });
}
