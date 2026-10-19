<x-layout title="Вход — GameNews">
    <h1 class="page-title">Вход</h1>
    <form class="form form--narrow" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form__group">
            <label for="login">Логин</label>
            <input type="text" id="login" name="login" value="{{ old('login') }}" autocomplete="username">
            @error('login') <span class="form__error">{{ $message }}</span> @enderror
        </div>
        <div class="form__group">
            <label for="password">Пароль</label>
            <input type="password" id="password" name="password" autocomplete="current-password">
            @error('password') <span class="form__error">{{ $message }}</span> @enderror
        </div>
        <div class="form__actions">
            <button type="submit" class="btn btn--primary">Войти</button>
        </div>
        <p class="form__hint">Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a></p>
    </form>
</x-layout>
