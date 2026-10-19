<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            // Заголовок статьи.
            $table->string('title');

            // Основной текст статьи.
            $table->text('content');

            // Внешний ключ на категорию.
            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();

            // Внешний ключ на автора.
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Дата публикации может отсутствовать.
            $table->timestamp('published_at')->nullable();

            // Дата создания и обновления.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};