<nav class="py-2 bg-light border-bottom">
    <div class="container d-flex flex-wrap">
        <ul class="nav me-auto">
            @if (Auth::user())
            <li class="nav-item"><a href="{{ url('user/'.Auth::user()->id)}}" class="nav-link link-dark px-2 active" aria-current="page">Моя страница</a></li>
            <li class="nav-item"><a href="{{ route('users-list') }}" class="nav-link link-dark px-2">Пользователи</a></li>
            <li class="nav-item"><a href="{{ url('user-comments/'.Auth::user()->id) }}" class="nav-link link-dark px-2">Мои комментарии</a></li>
                <li class="nav-item"><a href="{{ route('library.library',['id' => Auth::user()->id]) }}" class="nav-link link-dark px-2">Моя библиотека</a></li>

            @else
                <li class="nav-item"><a href="{{ url('users-list') }}" class="nav-link link-dark px-2">Пользователи</a></li>
            @endif
        </ul>
        <ul class="nav">
            @if (Auth::user())
                <li class="nav-item">Вы пользователь: {{ Auth::user()->id }}</li>
            @else
                <li class="nav-item"><a href="{{ route('register')}}" class="nav-link link-dark px-2">Login</a></li>
                <li class="nav-item"><a href="{{ route('login')}}" class="nav-link link-dark px-2">Sign up</a></li>
            @endif
        </ul>
        <p>

        </p>
    </div>
</nav>
