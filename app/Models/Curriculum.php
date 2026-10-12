<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'class_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    // Отношения
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('due_date')->orderBy('order');
    }

    // Получить уроки на сегодня
    public function getTodaysLessons()
    {
        return $this->lessons()->where('due_date', today())->get();
    }

    // Получить уроки на неделю
    public function getWeeklyLessons()
    {
        return $this->lessons()
            ->whereBetween('due_date', [today(), today()->addDays(7)])
            ->get();
    }
}