@extends('layouts.default')

@section('title')Создание статьи@endsection

@section('content')

    <div style="margin:100px auto; width: 1000px;">
        <h3 style="text-align: center;">Создание новой статьи</h3>

        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Название статьи</span>
            <input id="title" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="inputGroup-sizing-default">Автор</span>
            <input id="author" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
        </div>
        <div class="input-group mb-3">
            <label for="text" class="input-group-text">Текст статьи</label>
            <textarea class="form-control" id="text" rows="3"></textarea>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Категория</span>
            <select class="form-select form-select-sm" id="category" aria-label=".form-select-sm example">
                <option selected>Выберите категорию</option>
                @if(count($categories) > 0)
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <button id="create" class="btn btn-primary">Создать</button>
    </div>
@endsection

@section('scripts')
    <script>
        $('#create').on('click', function () {
            let category = $('#category').val();
            let title = $('#title').val();
            let author = $('#author').val();
            let text = $('#text').val();

            $.ajax({
                url: '{{ route('article.create') }}',
                type: 'POST',
                data: {
                    title,
                    author,
                    text,
                    category,
                    "_token": "{{ csrf_token() }}"
                },
                success: function () {
                    window.location = '{{ route('articles') }}';
                },
                error: function (data) {
                    alert(JSON.parse(data.responseText).message);
                }
            });
        });
    </script>
@endsection
