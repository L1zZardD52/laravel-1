<?php
// use - подключение класса
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController; // контроллер статей: главная, категория, журналист
use App\Http\Controllers\AuthController; // контроллер входа, регистрации и выхода
use Illuminate\Support\Facades\Route; // подключение класса Route

// ----- Публичные страницы (доступны всем) -----
Route::get('/', [ArticleController::class, 'home'])->name('home'); // главная: все статьи из БД
Route::get('/category', [ArticleController::class, 'categoryDefault'])->name('category'); // /category перенаправляет на первую категорию
// {category:slug} - Laravel сам найдёт категорию в БД по полю slug (например /category/pc)
Route::get('/category/{category:slug}', [ArticleController::class, 'category'])->name('category.show');
// страница одной статьи; whereNumber - в адресе допустимы только цифры
Route::get('/articles/{article}', [ArticleController::class, 'show'])->whereNumber('article')->name('articles.show');

// ----- Только для гостей: вошедшего пользователя сюда не пустит -----
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// ----- Только для вошедших: гостя перенаправит на /login -----
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Журналистам доступны их статьи; администратор тоже проходит эту проверку.
    Route::middleware('role:journalist')->group(function () {
        Route::get('/journalist', [ArticleController::class, 'journalist'])
            ->name('journalist');

        Route::post('/journalist/articles', [ArticleController::class, 'store'])
            ->name('articles.store');

        Route::get('/journalist/articles/{article}/edit', [ArticleController::class, 'edit'])
            ->name('articles.edit');

        Route::put('/journalist/articles/{article}', [ArticleController::class, 'update'])
            ->name('articles.update');
    });

    // Все маршруты админки доступны только администратору.
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/', [AdminController::class, 'index'])
                ->name('index');

            Route::patch('/articles/{article}/toggle', [AdminController::class, 'toggleArticle'])
                ->name('articles.toggle');

            Route::delete('/articles/{article}', [AdminController::class, 'destroyArticle'])
                ->name('articles.destroy');

            Route::patch('/users/{user}/role', [AdminController::class, 'updateRole'])
                ->name('users.role');
        });
});