<!-- форма для журналиста, чтобы он мог добавить новую статью. Внутри формы есть поля для заголовка, категории, краткого описания, текста статьи и изображения. Форма отправляется методом POST на текущий URL. -->
<x-layout title="Журналист — GameNews">
    <h1 class="page-title">Новая статья</h1> <!-- Заголовок страницы -->
    <!-- Форма. action="#" - пока некуда отправлять, method="POST" - способ отправки,
        enctype нужен, чтобы можно было загрузить файл -->
    <form class="form" action="#" method="POST" enctype="multipart/form-data">
        @csrf
        <!--action="#" значит, что отправлять пока некуда. По заданию нужна только верстка.
        method="POST" это способ отправки данных формы.
        enctype="multipart/form-data" нужен, чтобы через форму можно было загружать файлы (поле с изображением).
        @csrf Blade превращает в скрытое поле с защитным токеном. Laravel требует его в каждой POST-форме, иначе при отправке будет ошибка 419. Он защищает от подделки запросов с других сайтов. -->

        <!-- label: подпись над полем. for="title" указывает, к какому полю она относится
        (значение for должно совпадать с id поля). Клик по подписи ставит курсор в поле -->    

        <!-- Заголовок статьи -->
        <div class="form__group">
            <!-- Подпись к полю. for совпадает с id поля -->
            <label for="title">Заголовок</label>
            <!-- Однострочное поле. name - имя, под которым данные придут на сервер -->
            <input type="text" id="title" name="title" placeholder="Введите заголовок статьи">
        </div>
        <!-- Категория -->
        <div class="form__group">
            <label for="category">Категория</label>
            <!-- Выпадающий список -->
            <select id="category" name="category">
                <!-- Пустой пункт-подсказка -->
                <option value="">Выберите категорию</option>
                <!-- Пункты списка -->
                <option>PC</option>
                <option>Консоли</option>
                <option>Киберспорт</option>
            </select>
        </div>
        
        <!-- Краткое описание -->
        <div class="form__group">
            <label for="short">Краткое описание</label>
            <!-- Многострочное поле, rows - высота в строках -->
            <textarea id="short" name="short" rows="3" placeholder="Коротко о главном"></textarea>
        </div>
            <!-- Текст статьи -->
        <div class="form__group">
            <label for="content">Текст статьи</label>
            <textarea id="content" name="content" rows="12" placeholder="Напишите статью..."></textarea>
        </div>
        <!-- Изображение -->
        <div class="form__group">
            <!-- Выбор файла, accept оставляет только картинки -->
            <label for="image">Изображение</label>
            <input type="file" id="image" name="image" accept="image/*">
        </div>
            <!--кнопки-->
        <div class="form__actions">
            <!-- type="submit": отправляет форму ведёт в никуда, т.к. action="#" -->
            <button type="submit" class="btn btn--primary">Опубликовать</button>
            <!-- type="button": обычная кнопка, форму не отправляет, существует для вида -->
            <button type="button" class="btn">Сохранить черновик</button>
        </div>
    </form>
</x-layout>
