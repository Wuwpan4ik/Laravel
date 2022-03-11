@extends('layout')

@section('title')Пользователи@endsection


@section('main__content')
    @extends('header')
    <div class="container">
        <div class="profile">
            <h1 class="profile__name">Пользователи</h1>
            <div class="profile__notes">
                @foreach($notes as $note)
                    <div class="profile__note profile__notes-all">
                        <a class="profile__a" href="{{ route('user', ['id' => $note->id]) }}">
                            <div class="profile__title">{{ $note->id }} - </div>
                            <div class="profile__text" style="margin:0px">{{ $note->email }}</div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
