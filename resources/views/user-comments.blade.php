@extends('layout')

@section('title')Мои комментарии@endsection


@section('main__content')
    @extends('header')
    <div class="container">
        <div class="profile">
            <h1 class="profile__name">Мои комментарии</h1>
            <div class="profile__notes">
                @foreach($notes as $note)
                    <div class="profile__note">
                        <div class="profile__title">{{ $note->title }}</div>
                        <div class="profile__text">{{ $note->description }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
