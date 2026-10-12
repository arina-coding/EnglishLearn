<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grammar_topics', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Название темы
            $table->string('slug')->unique(); // Уникальный URL
            $table->text('theory'); // Теоретическая часть
            $table->text('examples'); // Примеры использования
            $table->text('exercise_question')->nullable(); // Вопрос для упражнения
            $table->text('exercise_options')->nullable(); // Варианты ответов
            $table->string('correct_answer')->nullable(); // Правильный ответ
            $table->string('level')->default('beginner'); // Уровень сложности
            $table->integer('order')->default(0); // Порядок отображения тем
            $table->boolean('is_active')->default(true); // Активна ли тема
            $table->timestamps(); // created_at и updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grammar_topics');
    }
};