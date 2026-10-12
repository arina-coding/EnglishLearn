<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    protected $fillable = [
        'english',
        'russian',
        'topic',
        'image'
    ];

    // Путь к изображению
    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path('images/words/' . $this->image))) {
            return asset('images/words/' . $this->image);
        }

        // Если изображения нет- градиент. 
        //
        $gradients = [
             'Еда' => 'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)',
            'Животные' => 'linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%)',
            'Семья' => 'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)',
            'Цвета' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            'Числа' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
            'Дом' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)'
        ];

        return $gradients[$this->topic] ?? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
    }

    public function getHasRealImageAttribute()
    {
        return $this->image && file_exists(public_path('images/words/' . $this->image));
    }
}