<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Создаём справочник ролей пользователей.
        Schema::create('roles', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор роли.
            $table->string('name')->unique(); // Название роли.
            $table->timestamps(); // Дата создания и изменения.
        });

        // Добавляем базовые роли.
        // Фиксированные ID нужны, чтобы новые пользователи
        // и тестовые данные получили предсказуемые роли.
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'journalist',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'reader',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Добавляем пользователям внешний ключ на таблицу roles.
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')
                ->default(2)
                ->constrained('roles')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        // Сначала убираем внешний ключ из users,
        // затем удаляем справочник ролей.
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });

        Schema::dropIfExists('roles');
    }
};