<?php
// use - подключение класса
use App\Http\Controllers\PageController; // подключение класса PageController
use Illuminate\Support\Facades\Route; // подключение класса Route
// коменты оставляю чтобы самому не запутаться, т.к парралельно ищу информацию
Route::get('/', [PageController::class, 'home'])->name('home'); //маршрут для главной страницы, вызывается метод home и говоритт запомнить его под именем home
Route::get('/category', [PageController::class, 'category'])->name('category'); //маршрут для страницы категории
Route::get('/journalist', [PageController::class, 'journalist'])->name('journalist'); //маршрут для страницы журналиста
Route::get('/admin', [PageController::class, 'admin'])->name('admin'); //маршрут для страницы администратора

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/journalist', [ArticleController::class, 'journalist'])->name('journalist');
    Route::post('/journalist/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/journalist/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/journalist/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
});
//фактически в этом файле мы создаем маршруты для нашего веб-приложения, связывая URL-адреса с методами контроллера PageController. у каждого маршрута есть имя, которое можно использовать для генерации URL-адресов в приложении.


