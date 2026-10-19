<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Создаём категории новостей.
        $pc = Category::create([
            'name' => 'PC',
            'slug' => 'pc',
        ]);

        $consoles = Category::create([
            'name' => 'Консоли',
            'slug' => 'consoles',
        ]);

        $esports = Category::create([
            'name' => 'Киберспорт',
            'slug' => 'esports',
        ]);

        // Получаем роль журналиста из справочника ролей.
        $journalistRole = Role::where('name', 'journalist')->firstOrFail();

        // Создаём пользователя и назначаем ему роль.
        $user = User::create([
            'login' => 'journalist',
            'password' => 'password',
            'role_id' => $journalistRole->id,
        ]);

        // Подготавливаем тестовые статьи.
        $articles = [
            [
                $pc,
                'Анонсирован сиквел популярной приключенческой RPG',
                'Разработчики показали первый трейлер и рассказали о новой боевой системе.',
            ],
            [
                $consoles,
                'Новая консоль получит эксклюзивный шутер на старте продаж',
                'Студия подтвердила, что игра выйдет одновременно с запуском платформы.',
            ],
            [
                $esports,
                'Российская команда выиграла международный турнир по CS',
                'Финал завершился со счётом 2:1 и собрал рекордную аудиторию зрителей.',
            ],
            [
                $pc,
                'Большое обновление добавило в игру новый режим и карты',
                'Патч также исправил десятки ошибок и улучшил производительность.',
            ],
            [
                $esports,
                'Мобильная стратегия набрала 10 миллионов загрузок за неделю',
                'Игра возглавила рейтинги магазинов приложений в нескольких странах.',
            ],
            [
                $pc,
                'Инди-платформер получил высокие оценки критиков',
                'Проект небольшой студии удивил оригинальной механикой и атмосферой.',
            ],
        ];

        // Создаём статьи, привязывая их к категории и автору.
        foreach ($articles as $i => [$category, $title, $content]) {
            Article::create([
                'title' => $title,
                'content' => $content,
                'category_id' => $category->id,
                'user_id' => $user->id,
                'published_at' => now()->subDays($i),
            ]);
        }
    }
}
//Импортирована модель Role.
//Получена существующая роль journalist.
//При создании пользователя заполнено поле role_id.
//Каждая статья получает category_id от существующей категории.
//Каждая статья получает user_id от созданного пользователя.