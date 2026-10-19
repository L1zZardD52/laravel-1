<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    // Поля, которые можно заполнять массово.
    protected $fillable = ['name', 'slug'];

    // Одна категория содержит много статей.
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}