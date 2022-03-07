@extends('layout')

@section('title')Библиотека {{ $id }}@endsection


@section('main__content')
    @extends('header')
    <div class="container">
        <div class="profile library">
            <a href="{{ route('book-add', ['id' => Auth::user()->id]) }}" class="library_a">Добавить книгу</a>
            <h1 class="profile__name">Библиотека</h1>
            <div class="profile__notes">
                @foreach($books as $book)
                    <div class="profile__note">
                        <div class="profile__title"><a class="profile__book-a" href=" {{route('book-read', ['book_id' =>$book->id])}} ">{{ $book->title }}</a></div>
                        <div class="profile__text">{{ $book->getShortContent() }}</div>
                        <a href="{{route('book-delete',['book_id' => $book->id, 'id' => Auth::user()->id])}}">Удалить</a>
                        <a href="{{ route('book-edit', ['book_id' => $book->id]) }}">Редактировать</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
