<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Находим роль администратора, которую добавляет миграция ролей.
        $adminRole = Role::where('name', 'admin')->firstOrFail();

        // Создаём администратора, только если логин admin ещё не занят.
        User::firstOrCreate(
            ['login' => 'admin'],
            [
                // Модель User автоматически хеширует пароль перед сохранением.
                'password' => 'password',

                // Назначаем пользователю роль администратора.
                'role_id' => $adminRole->id,
            ]
        );
    }
}