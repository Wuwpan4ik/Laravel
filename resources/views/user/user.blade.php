@extends('layout')
@section('title')Страница пользователя {{$id}}@endsection


@section('main__content')
    @extends('header')
    <div class="container">
        <div class="profile">
            <h1 class="mb-5" >Страница {{ $name }}</h1>
            <h2 class="profile__name">Комментарии на странице пользователя {{ $name }}</h2>
            @if(Auth::user()::isRights($id) and Auth::user()->id != $id)
                <a href="{{ route('give-right', ['id' => $id, 'secure' => 'False']) }}">Дать доступ к библиотеке</a>
            @elseif(!Auth::user()::isRights($id) and Auth::user()->id != $id)
                <a href="{{ route('give-right', ['id' => $id, 'secure' => 'True']) }}">Отключить доступ к библиотеке</a>
            @elseif(Auth::user()->id == $id)

            @endif
            <a href="{{ route('library', ['id' => $id]) }}">Библиотека</a>
            <div class="profile__notes">
                @include('messages')
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
        });
        $('#sev').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: '/getJsonForQuestions/{{$id}}',
                type: 'GET',
                dataType: 'json',
                success: function(data)
                {
                    console.log(data)
                }
            });

            $.ajax({
                url: '/getComments/{{$id}}',
                type: 'GET',
                cache: false,
                dataType: 'html',
                success: function(data)
                {
                    $('.profile__notes').html(data);
                }
            });
        });
    </script>

{{--  Если с paginate  --}}
{{--{{ $notes->appends(['sort' => 'votes'])->links() }}--}}
@endsection
