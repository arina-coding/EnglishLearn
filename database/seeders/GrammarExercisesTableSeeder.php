<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\GrammarTopic;

class GrammarExercisesTableSeeder extends Seeder
{
    public function run()
    {
        // все темы
        $topics = GrammarTopic::all();

        foreach ($topics as $topic) {
            $exercises = $this->getExercisesForTopic($topic->slug);

            foreach ($exercises as $exercise) {
                DB::table('grammar_exercises')->insert([
                    'grammar_topic_id' => $topic->id,
                    'question' => $exercise['question'],
                    'options' => isset($exercise['options']) ? json_encode($exercise['options']) : null,
                    'correct_answer' => $exercise['correct_answer'],
                    'type' => $exercise['type'],
                    'order' => $exercise['order'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }

    private function getExercisesForTopic($slug)
    {
        $exercises = [
            'present-simple' => [
                [
                    'question' => 'Выберите правильную форму: She _____ to school every day.',
                    'options' => ['go', 'goes', 'going', 'is go'],
                    'correct_answer' => 'goes',
                    'type' => 'choice',
                    'order' => 1
                ],
                [
                    'question' => 'Вставьте правильную форму: I _____ (to work) in an office.',
                    'correct_answer' => 'work',
                    'type' => 'fill',
                    'order' => 2
                ],
                [
                    'question' => 'Выберите правильное предложение:',
                    'options' => ['He play football', 'He plays football', 'He playing football', 'He is play football'],
                    'correct_answer' => 'He plays football',
                    'type' => 'choice',
                    'order' => 3
                ],
                [
                    'question' => 'Вставьте правильную форму: They _____ (to study) English on Mondays.',
                    'correct_answer' => 'study',
                    'type' => 'fill',
                    'order' => 4
                ],
                [
                    'question' => 'Выберите правильную отрицательную форму: She _____ coffee.',
                    'options' => ['not like', 'doesn\'t like', 'don\'t like', 'not likes'],
                    'correct_answer' => 'doesn\'t like',
                    'type' => 'choice',
                    'order' => 5
                ]
            ],

            'past-simple' => [
                [
                    'question' => 'Выберите правильную прошедшую форму: I _____ a great film yesterday.',
                    'options' => ['see', 'saw', 'seen', 'seeing'],
                    'correct_answer' => 'saw',
                    'type' => 'choice',
                    'order' => 1
                ],
                [
                    'question' => 'Вставьте правильную форму: They _____ (to visit) London last year.',
                    'correct_answer' => 'visited',
                    'type' => 'fill',
                    'order' => 2
                ],
                [
                    'question' => 'Выберите правильное предложение в Past Simple:',
                    'options' => ['She go to school yesterday', 'She went to school yesterday', 'She goes to school yesterday', 'She is going to school yesterday'],
                    'correct_answer' => 'She went to school yesterday',
                    'type' => 'choice',
                    'order' => 3
                ],
                [
                    'question' => 'Вставьте правильную форму: He _____ (not finish) his homework.',
                    'correct_answer' => 'didn\'t finish',
                    'type' => 'fill',
                    'order' => 4
                ],
                [
                    'question' => 'Выберите правильный вопрос: _____ you see the film?',
                    'options' => ['Do', 'Does', 'Did', 'Are'],
                    'correct_answer' => 'Did',
                    'type' => 'choice',
                    'order' => 5
                ]
            ],

            'future-simple' => [
                [
                    'question' => 'Выберите правильную форму: I think it _____ tomorrow.',
                    'options' => ['will rain', 'rains', 'raining', 'rain'],
                    'correct_answer' => 'will rain',
                    'type' => 'choice',
                    'order' => 1
                ],
                [
                    'question' => 'Вставьте правильную форму: I _____ (to call) you later.',
                    'correct_answer' => 'will call',
                    'type' => 'fill',
                    'order' => 2
                ],
                [
                    'question' => 'Выберите правильное отрицательное предложение:',
                    'options' => ['She will not come', 'She not will come', 'She doesn\'t will come', 'She won\'t comes'],
                    'correct_answer' => 'She will not come',
                    'type' => 'choice',
                    'order' => 3
                ],
                [
                    'question' => 'Вставьте правильную форму: _____ they help us?',
                    'correct_answer' => 'Will',
                    'type' => 'fill',
                    'order' => 4
                ],
                [
                    'question' => 'Выберите правильную форму: We _____ probably be late.',
                    'options' => ['will', 'are', 'going', 'to'],
                    'correct_answer' => 'will',
                    'type' => 'choice',
                    'order' => 5
                ]
            ],

            'articles' => [
                [
                    'question' => 'Выберите правильный артикль: I saw _____ interesting film.',
                    'options' => ['a', 'an', 'the', '-'],
                    'correct_answer' => 'an',
                    'type' => 'choice',
                    'order' => 1
                ],
                [
                    'question' => 'Вставьте правильный артикль: She is _____ doctor.',
                    'correct_answer' => 'a',
                    'type' => 'fill',
                    'order' => 2
                ],
                [
                    'question' => 'Выберите правильное предложение:',
                    'options' => ['I need an pen', 'I need a pen', 'I need the pen', 'I need pen'],
                    'correct_answer' => 'I need a pen',
                    'type' => 'choice',
                    'order' => 3
                ],
                [
                    'question' => 'Вставьте правильный артикль: _____ sun is shining.',
                    'correct_answer' => 'The',
                    'type' => 'fill',
                    'order' => 4
                ],
                [
                    'question' => 'Выберите правильный артикль: He plays _____ piano very well.',
                    'options' => ['a', 'an', 'the', '-'],
                    'correct_answer' => 'the',
                    'type' => 'choice',
                    'order' => 5
                ]
            ],

            'modal-verbs' => [
                [
                    'question' => 'Выберите правильный модальный глагол: You _____ see a doctor if you feel sick.',
                    'options' => ['can', 'must', 'should', 'might'],
                    'correct_answer' => 'should',
                    'type' => 'choice',
                    'order' => 1
                ],
                [
                    'question' => 'Вставьте правильный глагол: I _____ swim when I was five.',
                    'correct_answer' => 'could',
                    'type' => 'fill',
                    'order' => 2
                ],
                [
                    'question' => 'Выберите правильное предложение:',
                    'options' => ['You must to study', 'You must study', 'You must studying', 'You must studied'],
                    'correct_answer' => 'You must study',
                    'type' => 'choice',
                    'order' => 3
                ],
                [
                    'question' => 'Вставьте правильный глагол: _____ I help you?',
                    'correct_answer' => 'Can',
                    'type' => 'fill',
                    'order' => 4
                ],
                [
                    'question' => 'Выберите правильный глагол: It _____ rain today.',
                    'options' => ['can', 'must', 'should', 'might'],
                    'correct_answer' => 'might',
                    'type' => 'choice',
                    'order' => 5
                ]
            ],

            'conditionals' => [
                [
                    'question' => 'Выберите правильную форму: If I _____ you, I would study more.',
                    'options' => ['am', 'was', 'were', 'will be'],
                    'correct_answer' => 'were',
                    'type' => 'choice',
                    'order' => 1
                ],
                [
                    'question' => 'Вставьте правильную форму: If it rains, we _____ at home.',
                    'correct_answer' => 'will stay',
                    'type' => 'fill',
                    'order' => 2
                ],
                [
                    'question' => 'Выберите правильное предложение:',
                    'options' => ['If you will study, you pass', 'If you study, you will pass', 'If you studied, you will pass', 'If you study, you pass'],
                    'correct_answer' => 'If you study, you will pass',
                    'type' => 'choice',
                    'order' => 3
                ],
                [
                    'question' => 'Вставьте правильную форму: If I _____ money, I would buy a car.',
                    'correct_answer' => 'had',
                    'type' => 'fill',
                    'order' => 4
                ],
                [
                    'question' => 'Выберите правильный тип условного предложения: "If you heat ice, it melts."',
                    'options' => ['Zero Conditional', 'First Conditional', 'Second Conditional', 'Third Conditional'],
                    'correct_answer' => 'Zero Conditional',
                    'type' => 'choice',
                    'order' => 5
                ]
            ],

            'passive-voice' => [
                [
                    'question' => 'Выберите правильную форму: The new bridge _____ next year.',
                    'options' => ['is built', 'was built', 'will be built', 'builds'],
                    'correct_answer' => 'will be built',
                    'type' => 'choice',
                    'order' => 1
                ],
                [
                    'question' => 'Вставьте правильную форму: English _____ all over the world.',
                    'correct_answer' => 'is spoken',
                    'type' => 'fill',
                    'order' => 2
                ],
                [
                    'question' => 'Выберите правильное предложение в пассивном залоге:',
                    'options' => ['Students read the book', 'The book is read by students', 'The book read by students', 'Students are reading the book'],
                    'correct_answer' => 'The book is read by students',
                    'type' => 'choice',
                    'order' => 3
                ],
                [
                    'question' => 'Вставьте правильную форму: The letter _____ yesterday.',
                    'correct_answer' => 'was sent',
                    'type' => 'fill',
                    'order' => 4
                ],
                [
                    'question' => 'Выберите правильную форму: This house _____ in 1990.',
                    'options' => ['is built', 'was built', 'will be built', 'builded'],
                    'correct_answer' => 'was built',
                    'type' => 'choice',
                    'order' => 5
                ]
            ]
        ];

        return $exercises[$slug] ?? [];
    }
}