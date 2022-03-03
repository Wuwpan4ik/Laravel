@extends('layout')

@section('title')Страница пользователя {{$id}}@endsection


@section('main__content')
    @extends('header')
    <div class="container">
        <div class="profile">
            <h1 class="profile__name">Комментарии на странице пользователя {{ $name }}</h1>
            <div class="profile__notes">
                @foreach($notes as $note)
                    <div class="profile__note">
                        <div class="profile__title">{{ $note->title }}</div>
                        <div class="profile__text">{{ $note->description }}</div>
                        @if ( $note->id_user == Auth::user()->id)
                            <form action="{{ route('comment-delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="to_user" value="{{ $note->to_user }}">
                                <input type="hidden" name="id_note" value="{{ $note->id }}">
                                <button type="button" class="btn btn-danger">Удалить</button>
                            </form>
                        @elseif ($id == Auth::user()->id)
                            <form action="{{ route('comment-delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="to_user" value="{{ $note->to_user }}">
                                <input type="hidden" name="id_note" value="{{ $note->id }}">
                                <button type="button" class="btn btn-danger">Удалить</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (Auth::check())
        @if(($id != Auth::user()->id))
        <div class="form">
            <h2 class="form__title">Оставить комментарий</h2>
            <form action="{{ route('comment-checker') }}" method="POST" class="profile__form">
                @csrf
                <input type="text" name="title" class="profile__input" placeholder="Заголовок">
                <textarea name="comment" id="comment"></textarea>
                <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                <input type="hidden" name="to_user" value="{{ $id }}">
                <button type="submit" class="profile__form-btn">Отправить</button>
            </form>
        </div>
        @endif
        @endif
    </div>
@endsection
