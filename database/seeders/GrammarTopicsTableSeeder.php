<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GrammarTopicsTableSeeder extends Seeder
{
   public function run()
{
    $topics = [
        // Present Simple
        [
            'title' => 'Present Simple',
            'slug' => 'present-simple',
            'level' => 'beginner',
            'theory' => 'Present Simple (настоящее простое время) используется для описания:
• Постоянных действий и привычек
• Фактов и общеизвестных истин
• Расписаний и программ

Образование:
 Утверждение: I/You/We/They work | He/She/It works
 Отрицание: do/does + not + инфинитив
 Вопрос: Do/Does + подлежащее + инфинитив',
            'introduction' => 'Present Simple - одно из самых важных времен в английском языке. Оно используется для описания регулярных действий, привычек и общих фактов. Понимание этого времени - фундамент для изучения английской грамматики.',
            'examples' => " I work every day.
 She doesn't like coffee.
 Do you speak English?
 The sun rises in the east.
 We usually have dinner at 7 PM.",
            'exercise_question' => 'Выберите правильную форму: She _____ to school every day.',
            'exercise_options' => json_encode(['go', 'goes', 'going', 'is go']),
            'correct_answer' => 'goes',
            'order' => 1,
            'is_active' => true
        ],

        // Past Simple
        [
            'title' => 'Past Simple',
            'slug' => 'past-simple',
            'level' => 'beginner',
            'theory' => 'Past Simple (прошедшее простое время) используется для описания:
• Завершенных действий в прошлом
• Последовательных действий в прошлом
• Привычек в прошлом

Образование:
 Правильные глаголы: work → worked
 Неправильные глаголы: go → went, see → saw
 Отрицание: did + not + инфинитив
 Вопрос: Did + подлежащее + инфинитив',
            'introduction' => 'Past Simple позволяет говорить о событиях, которые произошли и завершились в прошлом. Это время необходимо для рассказов о вчерашнем дне, отпуске или любых завершенных действиях.',
            'examples' => " I visited London last year.
 She didn't go to school yesterday.
 Did you see the film?
 When I was a child, I played football.
 They arrived at 8 o'clock.",
            'exercise_question' => 'Выберите правильную прошедшую форму: I _____ a great film yesterday.',
            'exercise_options' => json_encode(['see', 'saw', 'seen', 'seeing']),
            'correct_answer' => 'saw',
            'order' => 2,
            'is_active' => true
        ],

        // Future Simple
        [
            'title' => 'Future Simple',
            'slug' => 'future-simple',
            'level' => 'beginner',
            'theory' => 'Future Simple (будущее простое время) используется для:
• Спонтанных решений
• Предсказаний и прогнозов
• Обещаний и предложений

Образование:
 Утверждение: will + инфинитив
 Отрицание: will + not + инфинитив
 Вопрос: Will + подлежащее + инфинитив',
            'introduction' => 'Future Simple помогает выражать действия, которые произойдут в будущем. Это время используется для планов, прогнозов и спонтанных решений.',
            'examples' => " I will call you tomorrow.
 She won't be late.
 Will they come to the party?
 It will rain later.
 We will help you with your homework.",
            'exercise_question' => 'Выберите правильную форму: I think it _____ tomorrow.',
            'exercise_options' => json_encode(['will rain', 'rains', 'raining', 'rain']),
            'correct_answer' => 'will rain',
            'order' => 3,
            'is_active' => true
        ],

        // Артикли
        [
            'title' => 'Артикли a/an/the',
            'slug' => 'articles',
            'level' => 'beginner',
            'theory' => 'Артикли в английском языке:

 A/AN - неопределенный артикль
• Используется с исчисляемыми существительными в единственном числе
• "A" перед согласными: a book, a university
• "AN" перед гласными: an apple, an hour

 THE - определенный артикль
• Используется с конкретными предметами
• С уникальными объектами: the sun, the moon
• Когда предмет упоминался ранее',
            'introduction' => 'Артикли - маленькие слова с большой важностью. Они помогают понять, говорим ли мы о конкретном предмете или о любом представителе класса. Правильное использование артиклей делает речь грамотной и естественной.',
            'examples' => " I need a pen. (любая ручка)
 She is an engineer. (профессия)
 The book on the table is mine. (конкретная книга)
 We went to the cinema. (конкретное место)
 The Earth revolves around the Sun.",
            'exercise_question' => 'Выберите правильный артикль: I saw _____ interesting film.',
            'exercise_options' => json_encode(['a', 'an', 'the', '-']),
            'correct_answer' => 'an',
            'order' => 4,
            'is_active' => true
        ],

        // Модальные глаголы
        [
            'title' => 'Модальные глаголы',
            'slug' => 'modal-verbs',
            'level' => 'intermediate',
            'theory' => 'Модальные глаголы выражают отношение к действию:

 CAN - возможность, умение
 COULD - прошлая возможность, вежливая просьба
 MUST - обязанность, необходимость
 SHOULD - совет, рекомендация
 MAY/MIGHT - вероятность, разрешение

Особенности:
• Не изменяются по лицам
• За ними следует инфинитив без "to"
• Не имеют форм будущего времени',
            'introduction' => 'Модальные глаголы добавляют оттенки значения к основному действию: возможность, необходимость, разрешение или совет. Они делают речь более выразительной и точной.',
            'examples' => " I can swim very well.
 Could you help me, please?
 You must finish your homework.
 She should see a doctor.
 It might rain today.",
            'exercise_question' => 'Выберите правильный модальный глагол: You _____ see a doctor if you feel sick.',
            'exercise_options' => json_encode(['can', 'must', 'should', 'might']),
            'correct_answer' => 'should',
            'order' => 5,
            'is_active' => true
        ],

        // Условные предложения
        [
            'title' => 'Условные предложения',
            'slug' => 'conditionals',
            'level' => 'intermediate',
            'theory' => 'Условные предложения выражают условие и результат:

Zero Conditional - факты, научные истины
If + Present Simple, Present Simple

First Conditional - реальные будущие ситуации
If + Present Simple, will + инфинитив

Second Conditional - нереальные настоящие ситуации
If + Past Simple, would + инфинитив',
            'introduction' => 'Условные предложения позволяют говорить о возможных, реальных или нереальных ситуациях и их последствиях. Они помогают выражать гипотезы, условия и предположения.',
            'examples' => " If you heat ice, it melts. (Zero)
 If it rains, we will stay home. (First)
 If I had money, I would buy a car. (Second)
 If you study hard, you will pass the exam.
 If I were you, I would apologize.",
            'exercise_question' => 'Выберите правильную форму: If I _____ you, I would study more.',
            'exercise_options' => json_encode(['am', 'was', 'were', 'will be']),
            'correct_answer' => 'were',
            'order' => 6,
            'is_active' => true
        ],

        // Пассивный залог
        [
            'title' => 'Пассивный залог',
            'slug' => 'passive-voice',
            'level' => 'intermediate',
            'theory' => 'Пассивный залог используется когда:
• Исполнитель действия неизвестен или неважен
• Акцент на действии, а не на исполнителе

Образование:
be + Past Participle (3 форма глагола)

Времена в пассиве:
• Present Simple: am/is/are + V3
• Past Simple: was/were + V3
• Future Simple: will be + V3',
            'introduction' => 'Пассивный залог переводит внимание с того, кто совершает действие, на само действие или его объект. Это особенно полезно в научных, технических и официальных текстах.',
            'examples' => " The book is read by students.
 The house was built in 1990.
 The letter will be sent tomorrow.
 English is spoken all over the world.
 The window was broken yesterday.",
            'exercise_question' => 'Выберите правильную форму: The new bridge _____ next year.',
            'exercise_options' => json_encode(['is built', 'was built', 'will be built', 'builds']),
            'correct_answer' => 'will be built',
            'order' => 7,
            'is_active' => true
        ]
    ];

    DB::table('grammar_topics')->delete();
    DB::statement('ALTER TABLE grammar_topics AUTO_INCREMENT = 1');
    DB::table('grammar_topics')->insert($topics);
}
}