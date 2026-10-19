<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    // Разрешаем массовое заполнение названия роли.
    protected $fillable = ['name'];

    // Одна роль может принадлежать многим пользователям.
    public function users(): HasMany
    {
        return $this->hasMany(User::class); // Связь "один ко многим" с моделью User, hasMany(User::class) означает, что у одной роли может быть несколько пользователей.
    }
}
// Зачем нужна модель? В Laravel модель представляет таблицу базы данных. Благодаря Role можно получать роли и связанные с ними учётные записи без написания SQL-запросов вручную.