<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WordsTableSeeder extends Seeder
{
    public function run()
    {
        $words = [
            // Еда
            ['english' => 'apple', 'russian' => 'яблоко', 'topic' => 'Еда', 'image' => 'apple.jpg'],
            ['english' => 'bread', 'russian' => 'хлеб', 'topic' => 'Еда', 'image' => 'bread.jpg'],
            ['english' => 'cheese', 'russian' => 'сыр', 'topic' => 'Еда', 'image' => 'cheese.jpg'],
            ['english' => 'milk', 'russian' => 'молоко', 'topic' => 'Еда', 'image' => 'milk.jpg'],
            ['english' => 'meat', 'russian' => 'мясо', 'topic' => 'Еда', 'image' => 'meat.jpg'],
            ['english' => 'fish', 'russian' => 'рыба', 'topic' => 'Еда', 'image' => 'fish.jpg'],
            ['english' => 'egg', 'russian' => 'яйцо', 'topic' => 'Еда', 'image' => 'egg.jpg'],
            ['english' => 'water', 'russian' => 'вода', 'topic' => 'Еда', 'image' => 'water.jpg'],

            // Животные
            ['english' => 'cat', 'russian' => 'кот', 'topic' => 'Животные', 'image' => 'cat.jpg'],
            ['english' => 'dog', 'russian' => 'собака', 'topic' => 'Животные', 'image' => 'dog.jpg'],
            ['english' => 'bird', 'russian' => 'птица', 'topic' => 'Животные', 'image' => 'bird.jpg'],
            ['english' => 'horse', 'russian' => 'лошадь', 'topic' => 'Животные', 'image' => 'horse.jpg'],
            ['english' => 'cow', 'russian' => 'корова', 'topic' => 'Животные', 'image' => 'cow.jpg'],
            ['english' => 'lion', 'russian' => 'лев', 'topic' => 'Животные', 'image' => 'lion.jpg'],

            // Семья
            ['english' => 'mother', 'russian' => 'мать', 'topic' => 'Семья', 'image' => 'mother.jpg'],
            ['english' => 'father', 'russian' => 'отец', 'topic' => 'Семья', 'image' => 'father.jpg'],
            ['english' => 'sister', 'russian' => 'сестра', 'topic' => 'Семья', 'image' => 'sister.jpg'],
            ['english' => 'brother', 'russian' => 'брат', 'topic' => 'Семья', 'image' => 'brother.jpg'],
            ['english' => 'family', 'russian' => 'семья', 'topic' => 'Семья', 'image' => 'family.jpg'],

            // Цвета
            ['english' => 'red', 'russian' => 'красный', 'topic' => 'Цвета', 'image' => 'red.jpg'],
            ['english' => 'blue', 'russian' => 'синий', 'topic' => 'Цвета', 'image' => 'blue.jpg'],
            ['english' => 'green', 'russian' => 'зеленый', 'topic' => 'Цвета', 'image' => 'green.jpg'],
            ['english' => 'yellow', 'russian' => 'желтый', 'topic' => 'Цвета', 'image' => 'yellow.jpg'],
            ['english' => 'black', 'russian' => 'черный', 'topic' => 'Цвета', 'image' => 'black.jpg'],

            // Числа
            ['english' => 'one', 'russian' => 'один', 'topic' => 'Числа', 'image' => 'one.jpg'],
            ['english' => 'two', 'russian' => 'два', 'topic' => 'Числа', 'image' => 'two.jpg'],
            ['english' => 'three', 'russian' => 'три', 'topic' => 'Числа', 'image' => 'three.jpg'],
            ['english' => 'four', 'russian' => 'четыре', 'topic' => 'Числа', 'image' => 'four.jpg'],
            ['english' => 'five', 'russian' => 'пять', 'topic' => 'Числа', 'image' => 'five.jpg'],

            // Дом
            ['english' => 'house', 'russian' => 'дом', 'topic' => 'Дом', 'image' => 'house.jpg'],
            ['english' => 'room', 'russian' => 'комната', 'topic' => 'Дом', 'image' => 'room.jpg'],
            ['english' => 'kitchen', 'russian' => 'кухня', 'topic' => 'Дом', 'image' => 'kitchen.jpg'],
            ['english' => 'bathroom', 'russian' => 'ванная', 'topic' => 'Дом', 'image' => 'bathroom.jpg'],
            ['english' => 'bedroom', 'russian' => 'спальня', 'topic' => 'Дом', 'image' => 'bedroom.jpg'],
            ['english' => 'table', 'russian' => 'стол', 'topic' => 'Дом', 'image' => 'table.jpg'],
            ['english' => 'chair', 'russian' => 'стул', 'topic' => 'Дом', 'image' => 'chair.jpg'],
            ['english' => 'window', 'russian' => 'окно', 'topic' => 'Дом', 'image' => 'window.jpg'],
        ];

        DB::table('words')->delete();

        DB::statement('ALTER TABLE words AUTO_INCREMENT = 1');

        DB::table('words')->insert($words);

    }
}