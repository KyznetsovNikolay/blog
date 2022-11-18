@extends('layouts.default')

@section('title')Просмотр статьи@endsection

@section('content')
    <h2 style="text-align: center; margin: 70px;">{{ ucfirst($article->title) }}</h2>

    <a style="margin-bottom: 30px;" href="{{ @route('articles') }}" class="btn btn-success">Список статей</a>

    <div  style="border: 1px solid black; padding: 15px;">
        <b>Автор: {{ $article->author }}</b>
        <p>Дата публикации: <i>{{ $article->created_at }}</i></p>
        <p style="padding: 15px; margin: 20px;">{{ $article->text }}</p>
        <input type="hidden" id="articleId" value="{{ $article->id }}">
    </div>

    <h4 style="margin: 40px;">Комментарии:</h4>

    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-sm">Автор</span>
        </div>
        <input id="author" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
    </div>

    <div class="input-group input-group-sm mb-3">
        <textarea id="text" class="form-control" placeholder="Комментарий" aria-label="Small" aria-describedby="inputGroup-sizing-sm"></textarea>
    </div>

    <div class="input-group-append">
        <button id="add" class="btn btn-outline-secondary" type="button">Добавить</button>
    </div>

    <div id="commentView">
        @if(count($comments) > 0)
            @foreach($comments as $comment)
                <div style="padding: 15px; margin: 20px;">
                    <b>{{ $comment->author }}:</b>
                    <i>{{ $comment->text }}</i>
                </div>
            @endforeach
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        function getCommentsView(comments) {
            let html = '';
            for (let comment of comments) {
                html += `<div style="padding: 15px; margin: 20px;">
                        <b>${comment.author}:</b>
                        <i>${comment.text}</i>
                    </div>`;
            }
            return html;
        }

        $('#add').on('click', function () {
            let author = $('#author').val();
            let text = $('#text').val();
            let id = $('#articleId').val();

            $.ajax({
                url: `/comment/${id}`,
                type: 'POST',
                data: {
                    author,
                    text,
                    "_token": "{{ csrf_token() }}"
                },
                success: function (comments) {
                    let html = getCommentsView(comments);
                    if (comments.length > 0) {
                        $('#commentView').html(html);
                    }
                },
                error: function (response) {
                    alert(JSON.parse(response.responseText).message);
                }
            });
        });
    </script>
@endsection
