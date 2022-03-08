@extends('layout')

@section('title'){{ $book->title }}@endsection


@section('main__content')
    @extends('header')
    <div class="container">
        <div class="profile library">
            <h1 class="profile__name">{{ $book->title }}</h1>
            <div class="profile__notes">
                {{ $book->text }}
            </div>
        </div>
    </div>
@endsection
