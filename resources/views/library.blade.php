@extends('layout')

@section('title')Библиотека {{ $id }}@endsection


@section('main__content')
    @extends('header')
    <div class="container">
        <div class="profile">
            <h1 class="profile__name">Библиотека</h1>
            <div class="profile__notes">
                @foreach($books as $book)
                    <div class="profile__note">
                        <div class="profile__title">{{ $book->title }}</div>
                        <div class="profile__text">{{ $book->text }}</div>
                        <a href="{{route('book-delete',['book_id' => $book->id, 'id' => Auth::user()->id])}}">Удалить</a>
                        <a href="{{ route('book-edit', ['book_id' => $book->id]) }}">Редактировать</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
