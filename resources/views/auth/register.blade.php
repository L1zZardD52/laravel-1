<x-layout title="Регистрация — GameNews">
    <h1 class="page-title">Регистрация</h1>
    <form class="form form--narrow" action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form__group">
            <label for="login">Логин</label>
            <input type="text" id="login" name="login" value="{{ old('login') }}" autocomplete="username">
            @error('login') <span class="form__error">{{ $message }}</span> @enderror
        </div>
        <div class="form__group">
            <label for="password">Пароль</label>
            <input type="password" id="password" name="password" autocomplete="new-password">
            @error('password') <span class="form__error">{{ $message }}</span> @enderror
        </div>
        <div class="form__group">
            <label for="password_confirmation">Подтверждение пароля</label>
            <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
        </div>
        <div class="form__actions">
            <button type="submit" class="btn btn--primary">Зарегистрироваться</button>
        </div>
        <p class="form__hint">Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a></p>
    </form>
</x-layout>