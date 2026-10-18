<?php
// use - подключение класса
use App\Http\Controllers\PageController; // подключение класса PageController
use Illuminate\Support\Facades\Route; // подключение класса Route
// коменты оставляю чтобы самому не запутаться, т.к парралельно ищу информацию
Route::get('/', [PageController::class, 'home'])->name('home'); //маршрут для главной страницы, вызывается метод home и говоритт запомнить его под именем home
Route::get('/category', [PageController::class, 'category'])->name('category'); //маршрут для страницы категории
Route::get('/journalist', [PageController::class, 'journalist'])->name('journalist'); //маршрут для страницы журналиста
Route::get('/admin', [PageController::class, 'admin'])->name('admin'); //маршрут для страницы администратора

//фактически в этом файле мы создаем маршруты для нашего веб-приложения, связывая URL-адреса с методами контроллера PageController. у каждого маршрута есть имя, которое можно использовать для генерации URL-адресов в приложении.


