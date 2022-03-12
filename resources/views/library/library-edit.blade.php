@extends('layout')

@section('title')Книга {{ $id }}@endsection


@section('main__content')
    @extends('header')
    <div class="container">
        <div class="profile">
            <h1 class="profile__name">Редактировать книгу</h1>
            <div class="profile__notes">
                <form class="profile__form" action="{{ route('book-edit', ['id' => Auth::user()->id, 'book_id' => $id]) }}" method="POST">
                    @csrf
                    <input type="text" name="title" value="{{ $book->title }}">
                    <textarea name="text" name="text" cols="30" rows="10">{{ $book->text }}</textarea>
                    <button type="submit" class="profile__form-btn">Отправить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
