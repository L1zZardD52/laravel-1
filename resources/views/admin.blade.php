<x-layout title="Админка — GameNews">
    <h1 class="page-title">Панель администратора</h1>

    <h2 class="section-title">Статьи</h2>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Заголовок</th>
                    <th>Категория</th>
                    <th>Автор</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($articles as $article)
                    <tr>
                        <td>{{ $article->id }}</td>
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->category->name }}</td>
                        <td>{{ $article->user->login }}</td>

                        <td>
                            {{ $article->published_at ? 'Опубликована' : 'Заблокирована' }}
                        </td>

                        <td class="actions">
                            {{-- Используем существующую форму редактирования статьи. --}}
                            <a href="{{ route('articles.edit', $article) }}" class="btn btn--sm">
                                Редактировать
                            </a>

                            {{-- Блокировка скрывает статью, но не удаляет её. --}}
                            <form action="{{ route('admin.articles.toggle', $article) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn--sm btn--warn">
                                    {{ $article->published_at ? 'Заблокировать' : 'Разблокировать' }}
                                </button>
                            </form>

                            {{-- Удаление необратимо, поэтому показываем подтверждение. --}}
                            <form
                                action="{{ route('admin.articles.destroy', $article) }}"
                                method="POST"
                                onsubmit="return confirm('Удалить эту статью?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn--sm btn--danger">
                                    Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h2 class="section-title">Роли пользователей</h2>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Логин</th>
                    <th>Роль</th>
                    <th>Изменить роль</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->login }}</td>
                        <td>{{ $user->role->name }}</td>

                        <td>
                            {{-- Для простоты у каждого пользователя своя форма сохранения. --}}
                            <form
                                action="{{ route('admin.users.role', $user) }}"
                                method="POST"
                                class="actions"
                            >
                                @csrf
                                @method('PATCH')

                                <select name="role_id">
                                    @foreach ($roles as $role)
                                        <option
                                            value="{{ $role->id }}"
                                            @selected($user->role_id === $role->id)
                                        >
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <button type="submit" class="btn btn--sm btn--primary">
                                    Сохранить
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>