@props(['action', 'categories', 'article' => null, 'method' => 'POST', 'button' => 'Опубликовать'])

<form class="form" action="{{ $action }}" method="POST">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <div class="form__group">
        <label for="title">Заголовок</label>
        <input type="text" id="title" name="title" value="{{ old('title', $article?->title) }}" placeholder="Введите заголовок статьи">
        @error('title') <span class="form__error">{{ $message }}</span> @enderror
    </div>

    <div class="form__group">
        <label for="category_id">Категория</label>
        <select id="category_id" name="category_id">
            <option value="">Выберите категорию</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) old('category_id', $article?->category_id) === (string) $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id') <span class="form__error">{{ $message }}</span> @enderror
    </div>

    <div class="form__group">
        <label for="content">Полный текст статьи</label>
        <textarea id="content" name="content" rows="12" placeholder="Напишите статью...">{{ old('content', $article?->content) }}</textarea>
        @error('content') <span class="form__error">{{ $message }}</span> @enderror
    </div>

    <div class="form__actions">
        <button type="submit" class="btn btn--primary">{{ $button }}</button>
    </div>
</form>