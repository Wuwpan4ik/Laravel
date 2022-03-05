@extends('layout')

@section('title')Страница пользователя {{$id}}@endsection


@section('main__content')
    @extends('header')
    <div class="container">
        <div class="profile">
            <h1 class="profile__name">Комментарии на странице пользователя {{ $name }}</h1>
            <div class="profile__notes">
                @if ($notes)
                    @foreach($notes as $note => $category)
                        <div class="profile__note">
                            <div class="profile__note-container">
                                <div class="profile__title">{{ $category->title }}</div>
                                <div class="profile__text">{{ $category->description }}</div>
                                <button class="profile__form-btn" title="Ответить {{$name}}">Ответить</button>
                                <form class="profile__form" action="{{ route('comment-add') }}" method="POST">
                                    @csrf
                                    <input type="text" name="title" class="profile__input" placeholder="Заголовок">
                                    <textarea name="comment" id="comment"></textarea>
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="user_to" value="{{ $id }}">
                                    <input type="hidden" name="parent" value="{{ $category->id }}">
                                    <button type="submit" class="profile__form-btn">Отправить</button>
                                </form>
                                @foreach($category->children as $item)
                                    <div class="profile__note">
                                        <div class=""></div>
                                        <div class="profile__title">{{ $item->title }}</div>
                                        <div class="profile__text">'{{ $category->description }}' - {{ $item->description }}</div>
                                        @if ( $item->user_id == Auth::user()->id)
                                            <form class="form__delete" action="{{ route('comment-delete') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="user_to" value="{{ $item->user_to }}">
                                                <input type="hidden" name="id_note" value="{{ $item->id }}">
                                                <button title="Удалить комментарий" class="form__delete-btn"><i class="fa fa-times"></i></button>
                                            </form>
                                        @elseif ($id == Auth::user()->id)
                                            <form class="form__delete" action="{{ route('comment-delete') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="user_to" value="{{ $item->user_to }}">
                                                <input type="hidden" name="id_note" value="{{ $item->id }}">
                                                <button title="Удалить комментарий" class="form__delete-btn"><i class="fa fa-times"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                                {{--Удаление комментария--}}
                                @if ( $category->user_id == Auth::user()->id)
                                    <form class="form__delete" action="{{ route('comment-delete') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="user_to" value="{{ $category->user_to }}">
                                        <input type="hidden" name="id_note" value="{{ $category->id }}">
                                        <button title="Удалить комментарий" class="form__delete-btn"><i class="fa fa-times"></i></button>
                                    </form>
                                @elseif ($id == Auth::user()->id)
                                    <form class="form__delete" action="{{ route('comment-delete') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="user_to" value="{{ $category->user_to }}">
                                        <input type="hidden" name="id_note" value="{{ $category->id }}">
                                        <button title="Удалить комментарий" class="form__delete-btn"><i class="fa fa-times"></i></button>
                                    </form>
                                @endif
{{--                                Удаление комментария--}}
                            </div>
                        </div>
                    @endforeach
                @endif
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
{{--        @if(($id != Auth::user()->id))--}}
        <div class="form">
            <h2 class="form__title">Оставить комментарий</h2>
            <form action="{{ route('comment-add') }}" method="POST" class="profile__form">
                @csrf
                <input type="text" name="title" class="profile__input" placeholder="Заголовок">
                <textarea name="comment" id="comment"></textarea>
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="user_to" value="{{ $id }}">
                <button type="submit" class="profile__form-btn">Отправить</button>
            </form>
        </div>
{{--        @endif--}}
        @endif

    </div>


{{--  Если с paginate  --}}
{{--    {{ $notes->appends(['sort' => 'votes'])->links() }}--}}
@endsection
