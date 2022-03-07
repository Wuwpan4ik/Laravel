@extends('layout')

@section('title')Добавить книгу@endsection


@section('main__content')
    @extends('header')
    <div class="container">
        <div class="profile">
            <h1 class="profile__name">Добавить книгу</h1>
            <div class="profile__notes">
                <form class="profile__form" action="{{ route('book-add-bs', ['id' => $id]) }}" method="POST">
                    @csrf
                   <input type="text" name="title" placeholder="Введите название">
                   <textarea style="width: 100%; height: 50vh;" name="text" cols="30" rows="10" placeholder="Введите текст "></textarea>
                    <div class="d-flex w-100 justify-content-center">
                        <label for="access_all">Доступно всем:</label>
                        <select name="access_all" id="access_all">
                            <option value="0">Нет</option>
                            <option value="1">Да</option>
                        </select>
                    </div>
                    <button type="submit" class="profile__form-btn">Отправить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
