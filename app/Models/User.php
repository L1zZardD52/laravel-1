<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Связь "многие к одному" с моделью Role, belongsTo(Role::class) означает, что у одного пользователя может быть только одна роль.
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable(['login', 'password', 'role_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory;

    // Laravel автоматически хеширует пароль перед сохранением.
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Каждый пользователь принадлежит одной роли.
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // У одного пользователя может быть много статей.
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class); // Связь "один ко многим" с моделью Article, hasMany(Article::class) означает, что у одного пользователя может быть несколько статей.
    }
}
// belongsTo(Role::class) означает, что внешний ключ role_id находится в таблице users, а идентификатор родительской записи — в roles
// hasMany(Article::class) означает, что внешний ключ user_id находится в таблице articles, а идентификатор родительской записи — в users
// Зачем нужна модель? В Laravel модель представляет таблицу базы данных. Благодаря User можно получать пользователей и связанные с ними роли и статьи без написания SQL-запросов вручную.