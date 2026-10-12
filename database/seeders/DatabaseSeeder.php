<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            WordsTableSeeder::class,
            GrammarTopicsTableSeeder::class,
            GrammarExercisesTableSeeder::class,
        ]);
    }
}