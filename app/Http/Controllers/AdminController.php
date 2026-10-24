<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Показывает настоящие статьи, пользователей и роли из базы данных.
    public function index()
    {
        return view('admin', [
            'articles' => Article::with(['category', 'user'])
                ->latest()
                ->get(),

            'users' => User::with('role')
                ->orderBy('id')
                ->get(),

            'roles' => Role::orderBy('id')->get(),
        ]);
    }

    // Блокировка скрывает статью с сайта, но оставляет её в базе.
    // Повторное нажатие публикует её обратно.
    public function toggleArticle(Article $article)
    {
        if ($article->published_at) {
            $article->update(['published_at' => null]);
            $message = 'Статья заблокирована.';
        } else {
            $article->update(['published_at' => now()]);
            $message = 'Статья снова опубликована.';
        }

        return back()->with('status', $message);
    }

    // Удаляет статью из базы данных окончательно.
    public function destroyArticle(Article $article)
    {
        $article->delete();

        return back()->with('status', 'Статья удалена.');
    }

    // Меняет роль выбранного пользователя.
    public function updateRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role_id' => ['required', 'integer', 'exists:roles,id'],
        ]);

        // Не даём случайно снять роль у самого себя и потерять доступ к админке.
        if ($request->user()->is($user) && $user->role_id != $data['role_id']) {
            return back()->with('status', 'Нельзя изменить собственную роль.');
        }

        $user->update(['role_id' => $data['role_id']]);

        return back()->with('status', 'Роль пользователя изменена.');
    }
}