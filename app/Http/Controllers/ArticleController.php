<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    private const MESSAGES = [
        'title.required' => 'Введите заголовок.',
        'title.max' => 'Заголовок не длиннее 255 символов.',
        'category_id.required' => 'Выберите категорию.',
        'category_id.exists' => 'Такой категории нет.',
        'content.required' => 'Введите текст статьи.',
        'content.min' => 'Текст статьи слишком короткий (минимум 10 символов).',
    ];

    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'content' => ['required', 'string', 'min:10'],
        ];
    }

    public function home()
    {
        $articles = Article::published()
            ->with(['category', 'user'])
            ->latest('published_at')
            ->paginate(6);

        return view('home', ['articles' => $articles]);
    }

    public function categoryDefault()
    {
        $category = Category::orderBy('id')->firstOrFail();
        return redirect()->route('category.show', $category);
    }

    public function category(Category $category)
    {
        $articles = $category->articles()
            ->published()
            ->with(['category', 'user'])
            ->latest('published_at')
            ->paginate(6);

        return view('category', [
            'category' => $category,
            'articles' => $articles,
            'categories' => Category::orderBy('id')->get(),
        ]);
    }

    public function show(Article $article)
    {
        abort_unless($article->published_at && $article->published_at->isPast(), 404);
        return view('article', ['article' => $article->load(['category', 'user'])]);
    }

    public function journalist(Request $request)
    {
        return view('journalist', [
            'categories' => Category::orderBy('id')->get(),
            'myArticles' => $request->user()->articles()->with('category')->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), self::MESSAGES);

        $request->user()->articles()->create($data + ['published_at' => now()]);

        return redirect()->route('home')->with('status', 'Статья опубликована.');
    }

    public function edit(Request $request, Article $article)
    {
        abort_unless($article->user_id === $request->user()->id, 403);
        return view('article-edit', ['article' => $article, 'categories' => Category::orderBy('id')->get()]);
    }

    public function update(Request $request, Article $article)
    {
        abort_unless($article->user_id === $request->user()->id, 403);
        $article->update($request->validate($this->rules(), self::MESSAGES));

        return redirect()->route('articles.show', $article)->with('status', 'Статья обновлена.');
    }
}