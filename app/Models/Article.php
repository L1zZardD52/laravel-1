<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    // Поля, которые разрешено заполнять массово.
    protected $fillable = [
        'title',
        'content',
        'category_id',
        'user_id',
        'published_at',
    ];

    // Преобразуем дату публикации в объект даты и времени.
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    // Каждая статья принадлежит одной категории.
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Каждая статья принадлежит одному автору.
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Выбираем только опубликованные статьи,
    // дата публикации которых уже наступила.
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
// В таблице articles хранятся два внешних ключа:
// category_id ссылается на categories.id;
// user_id ссылается на users.id.
// Поэтому модель Article использует belongsTo() для обеих связей