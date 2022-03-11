@if ($comments)
    @foreach($comments as $note => $category)
        @if (!$category->parent_id)
            <div class="profile__note">
                <div class="profile__note-container">
                    <div class="profile__title">{{ $category->title }}</div>
                    <div class="profile__text">{{ $category->description }}</div>
                    <button class="profile__form-btn" id="answer" title="Ответить">Ответить</button>
                    <form class="profile__form profile__form-block" id="form" action="{{ route('comment-add', ['user_to' => $id, 'user_id' => Auth::user()->id, 'parent' => $category->id ]) }}" method="POST">
                        @csrf
                        <input type="text" name="title" class="profile__input" placeholder="Заголовок">
                        <textarea name="comment" id="comment"></textarea>
                        <button type="submit" class="profile__form-btn">Отправить</button>
                    </form>
                    @foreach($category->children as $item)
                        <div class="profile__note">
                            <div class="profile__title">{{ $item->title }}</div>
                            <div class="profile__text">'{{ $category->description }}' - {{ $item->description }}</div>
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
                    @endforeach

                    {{--Удаление комментария--}}
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
                    {{--                                Удаление комментария--}}
                </div>
            </div>
        @endif
    @endforeach
@endif
