@extends('layout')
@section('title')Страница пользователя {{$id}}@endsection


@section('main__content')
    @extends('header')
    <div class="container">
        <div class="profile">
            <h1 class="profile__name">Комментарии на странице пользователя {{ $name }}</h1>
            @if(Auth::user()::isRights($id) and Auth::user()->id != $id)
                <a href="{{ route('give-right', ['id' => $id, 'secure' => 'False']) }}">Дать доступ к библиотеке</a>
            @elseif(!Auth::user()::isRights($id) and Auth::user()->id != $id)
                <a href="{{ route('give-right', ['id' => $id, 'secure' => 'True']) }}">Отключить доступ к библиотеке</a>
                <a href="{{ route('library', ['id' => $id]) }}">Библиотека</a>
            @elseif(Auth::user()->id == $id)
            @endif
            <div class="profile__notes">
                @if ($notes)
                    @foreach($notes as $note => $category)
                        <div class="profile__note">
                            <div class="profile__note-container">
                                <div class="profile__title">{{ $category->title }}</div>
                                <div class="profile__text">{{ $category->description }}</div>
                                <button class="profile__form-btn" id="answer" title="Ответить {{$name}}">Ответить</button>
                                <form class="profile__form profile__form-block" id="form" action="{{ route('comment-add') }}" method="POST">
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
            @if(($id != Auth::user()->id))
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
            @endif
        @endif
        <button id="sev">Догрузить</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on("click",'#answer',function () {
                $(this).parent().find('#form').toggleClass('active');
            });

            $('#sev').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "GET",
                    url: '?success=True',
                    data: $(this).serialize(),
                    success: function(data)
                    {
                        $('html').html(data);
                    }
                });
            });
        });
    </script>

{{--  Если с paginate  --}}
{{--{{ $notes->appends(['sort' => 'votes'])->links() }}--}}
@endsection
