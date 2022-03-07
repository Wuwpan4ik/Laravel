@extends('layout')

@section('title'){{ $book->title }}@endsection


@section('main__content')
    @extends('header')
    <div class="container">
        <div class="profile library">
            <a href="{{ route('book-add', ['id' => Auth::user()->id]) }}" class="library_a">Добавить книгу</a>
            <h1 class="profile__name">{{ $book->title }}</h1>
            <div class="profile__notes">
                {{ $book->text }}
            </div>
        </div>
    </div>
@endsection
