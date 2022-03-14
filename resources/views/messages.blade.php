@if ($comments)
    @foreach($comments as $note => $category)
        @if (!$category->parent_id)
            <ul class="media-list">
                <!-- Комментарий (уровень 1) -->
                <li class="media media-top mb-1">
                    <div class="media-body">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <img class="media-left-img media-object img-rounded" src="{{ url('image/i.jpg') }}" alt="...">
                                <div class="author">{{ $category->title }}</div>
                                <div class="metadata">
                                    <span class="date">{{ $category->user_id }}</span>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="media-text text-justify">{{ $category->description }}</div>
                            </div>
                            <div class="panel-footer">
                                <button id="answer" class="btn btn-dark" href="#">Ответить</button>
                                <form class="profile__form profile__form-block" id="form" action="{{ route('comment-add', ['user_to' => $id, 'user_id' => Auth::user()->id, 'parent' => $category->id ]) }}" method="POST">
                                    @csrf
                                    <input type="text" name="title" class="profile__input" placeholder="Заголовок">
                                    <textarea name="comment" id="comment"></textarea>
                                    <button type="submit" class="profile__form-btn">Отправить</button>
                                </form>
                            </div>
                        </div>
                        @if ( $category->user_id == Auth::user()->id)
                            <form class="form__delete" action="{{ route('comment-delete', ['note_id' => $category->id, 'user_to' => $category->user_to]) }}" method="POST">
                                @csrf
                                <button title="Удалить комментарий" class="form__delete-btn"><i class="fa fa-times"></i></button>
                            </form>
                        @elseif ($id == Auth::user()->id)
                            <form class="form__delete" action="{{ route('comment-delete', ['note_id' => $category->id, 'user_to' => $category->user_to]) }}" method="POST">
                                @csrf
                                <button title="Удалить комментарий" class="form__delete-btn"><i class="fa fa-times"></i></button>
                            </form>
                        @endif
                        <!-- Ещё один вложенный медиа-компонент (уровень 2) -->
                        @foreach($category->children as $item)
                        <div class="media mb-2 mt-4 ml-4">
                            <div class="media-body">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <img class="media-left-img media-object img-rounded" src="{{ url('image/i.jpg') }}" alt="...">
                                        <div class="author">{{ $item->title }}</div>
                                        <div class="metadata">
                                            <span class="date">{{ $category->user_id }}</span>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="media-text text-justify">{{ $category->description }}</div>
                                    </div>
                                </div>
                                @if ( $item->user_id == Auth::user()->id)
                                    <form class="form__delete" action="{{ route('comment-delete', ['note_id' => $category->id, 'user_to' => $category->user_to]) }}" method="POST">
                                        @csrf
                                        <button title="Удалить комментарий" class="form__delete-btn"><i class="fa fa-times"></i></button>
                                    </form>
                                @elseif ($id == Auth::user()->id)
                                    <form class="form__delete" action="{{ route('comment-delete', ['note_id' => $category->id, 'user_to' => $category->user_to]) }}" method="POST">
                                        @csrf
                                        <button title="Удалить комментарий" class="form__delete-btn"><i class="fa fa-times"></i></button>
                                    </form>
                                @endif

                            </div>
                        </div>
                        @endforeach
{{--                        <!-- Конец ещё одного вложенного комментария (уровень 2) -->--}}
                    </div>
                </li>
                <!-- Конец комментария (уровень 1) -->
            </ul>
        @endif
    @endforeach
@endif
