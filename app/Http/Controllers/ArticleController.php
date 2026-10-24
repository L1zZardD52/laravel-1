<?php

// Пространство имён контроллеров приложения.
namespace App\Http\Controllers;

// Подключаем модель статьи для работы с таблицей статей в базе данных.
use App\Models\Article;

// Подключаем модель категории для получения категорий и связи с ними.
use App\Models\Category;

// Подключаем объект запроса: из него получаем отправленные данные и пользователя.
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Сообщения об ошибках, которые показываются при проверке формы статьи.
    private const MESSAGES = [
        'title.required' => 'Введите заголовок.',
        'title.max' => 'Заголовок не длиннее 255 символов.',
        'category_id.required' => 'Выберите категорию.',
        'category_id.exists' => 'Такой категории нет.',
        'content.required' => 'Введите текст статьи.',
        'content.min' => 'Текст статьи слишком короткий (минимум 10 символов).',
    ];

    // Правила проверки данных, которые пользователь отправляет из формы статьи.
    private function rules(): array
    {
        return [
            // Заголовок обязателен, должен быть текстом и не длиннее 255 символов.
            'title' => ['required', 'string', 'max:255'],

            // Категория обязательна и должна существовать в таблице categories.
            'category_id' => ['required', 'exists:categories,id'],

            // Текст статьи обязателен и должен содержать не менее 10 символов.
            'content' => ['required', 'string', 'min:10'],
        ];
    }

    // Показывает главную страницу со списком опубликованных статей.
    public function home()
    {
        // Выбираем статьи, у которых дата публикации уже наступила.
        $articles = Article::published()

            // Сразу загружаем категории и авторов, чтобы не делать запрос
            // к базе отдельно для каждой статьи при отображении карточек.
            ->with(['category', 'user'])

            // Сначала показываем самые новые статьи.
            ->latest('published_at')

            // Показываем по шесть статей на странице.
            ->paginate(6);

        // Передаём список статей в шаблон главной страницы.
        return view('home', ['articles' => $articles]);
    }

    // Перенаправляет /category на страницу первой категории.
    public function categoryDefault()
    {
        // Находим категорию с наименьшим ID.
        // Если в базе нет категорий, Laravel покажет ошибку 404.
        $category = Category::orderBy('id')->firstOrFail();

        // Перенаправляем посетителя на страницу выбранной категории.
        return redirect()->route('category.show', $category);
    }

    // Показывает статьи выбранной категории.
    // Laravel находит категорию по параметру маршрута и передаёт её сюда.
    public function category(Category $category)
    {
        // Получаем статьи, относящиеся к выбранной категории.
        $articles = $category->articles()

            // Оставляем только опубликованные статьи.
            ->published()

            // Загружаем связанные категории и данные авторов.
            ->with(['category', 'user'])

            // Сначала показываем самые новые статьи.
            ->latest('published_at')

            // Разбиваем список на страницы по шесть статей.
            ->paginate(6);

        // Передаём в шаблон текущую категорию, её статьи
        // и полный список категорий для навигации.
        return view('category', [
            'category' => $category,
            'articles' => $articles,
            'categories' => Category::orderBy('id')->get(),
        ]);
    }

    // Показывает страницу одной статьи.
    public function show(Article $article)
    {
        // Не показываем статью, если она заблокирована
        // или дата её публикации ещё не наступила.
        abort_unless(
            $article->published_at && $article->published_at->isPast(),
            404
        );

        // Загружаем категорию и автора статьи, затем открываем её шаблон.
        return view('article', [
            'article' => $article->load(['category', 'user']),
        ]);
    }

    // Показывает журналисту форму создания статьи
    // и список статей, которые принадлежат вошедшему пользователю.
    public function journalist(Request $request)
    {
        return view('journalist', [
            // Передаём категории, чтобы пользователь мог выбрать одну в форме.
            'categories' => Category::orderBy('id')->get(),

            // Берём статьи текущего пользователя,
            // сразу загружаем их категории и сортируем от новых к старым.
            'myArticles' => $request->user()
                ->articles()
                ->with('category')
                ->latest()
                ->get(),
        ]);
    }

    // Проверяет форму и сохраняет новую статью в базе данных.
    public function store(Request $request)
    {
        // Проверяем заголовок, категорию и текст по правилам выше.
        // Если данные неправильные, Laravel вернёт пользователя к форме с ошибками.
        $data = $request->validate($this->rules(), self::MESSAGES);

        // Создаём статью через связь текущего пользователя.
        // Благодаря этому user_id автоматически получает ID автора.
        // Дата публикации записывается текущим временем.
        $request->user()->articles()->create(
            $data + ['published_at' => now()]
        );

        // После сохранения возвращаем пользователя на главную
        // и показываем сообщение об успешной публикации.
        return redirect()
            ->route('home')
            ->with('status', 'Статья опубликована.');
    }

    // Показывает форму редактирования существующей статьи.
    public function edit(Request $request, Article $article)
    {
        // Редактировать статью может её автор или администратор.
        // Для всех остальных пользователей возвращаем ошибку 403.
        abort_unless(
            $request->user()->role?->name === 'admin'
                || $article->user_id === $request->user()->id,
            403
        );

        // Открываем форму редактирования и передаём ей статью и категории.
        return view('article-edit', [
            'article' => $article,
            'categories' => Category::orderBy('id')->get(),
        ]);
    }

    // Проверяет отправленную форму и сохраняет изменения статьи.
    public function update(Request $request, Article $article)
    {
        // Повторно проверяем права при сохранении.
        // Нельзя обойти проверку доступа, отправив запрос напрямую.
        // Сохранять изменения может автор статьи или администратор.
        abort_unless(
            $request->user()->role?->name === 'admin'
                || $article->user_id === $request->user()->id,
            403
        );

        // Проверяем данные формы и сохраняем их в базе.
        $article->update(
            $request->validate($this->rules(), self::MESSAGES)
        );

        // После сохранения открываем страницу статьи
        // и показываем сообщение об успешном обновлении.
        return redirect()
            ->route('articles.show', $article)
            ->with('status', 'Статья обновлена.');
    }
}