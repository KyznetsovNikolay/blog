@extends('layouts.default')

@section('title')Список статей@endsection

@section('content')

    <div style="margin:100px auto; width: 1000px;">
        <h2 style="text-align: center; margin-bottom: 70px;">Список статей</h2>
        <a style="margin-bottom: 30px;" href="{{ @route('article.create') }}" class="btn btn-success">Добавить</a>

        <div class="input-group input-group-sm mb-3">
            <label for="date"></label>
            <input class="form-control form-select-sm" type="date" id="date">

            <select class="form-select" onchange="categoryFilter(this)">
                <option selected>Выберите категорию</option>
                @if(count($categories) > 0)
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="input-group mb-3">
            <input id="search" type="text" class="form-control" placeholder="Введите заголовок" aria-label="Введите заголовок" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button id="find" class="btn btn-outline-secondary" type="button">Найти</button>
            </div>
        </div>
        <div>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Заголовок статьи</th>
                    <th scope="col">Автор</th>
                    <th scope="col">Категория</th>
                </tr>
                </thead>
                <tbody id="table">
                @if(count($articles) > 0)
                    @foreach($articles as $article)
                        <tr>
                            <td><a href="{{ route('article.view', ['id' => $article->id]) }}">{{ $article->title }}</a></td>
                            <td>{{ $article->author }}</td>
                            <td>{{ $article->category->name }}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function getArticlesView(articles) {
            let html = '';
            for (let article of articles) {
                html += `<tr>
                        <td><a href="/article/view/${article.id}">${article.title}</a></td>
                        <td>${article.author}</td>
                        <td>${article.category.name}</td>
                    </tr>`;
            }
            return html;
        }

        function categoryFilter(element) {
            let category = isNaN(element.value) ? '0' : element.value;

            let data = {
                category,
                "_token": "{{ csrf_token() }}"
            };
            ajax(data);
        }

        function buildArticles(data) {
            let articles = [];
            let categories = data.categories;

            data.articles.forEach(article => {
                for (let category of categories) {
                    if (category.id === article.category_id) {
                        article.category = category;
                        articles.push(article);
                    }
                }
            });
            return articles;
        }

        function ajax(data, isSearch = false) {
            $.ajax({
                url: '{{ route('articles') }}',
                type: 'POST',
                data: data,
                success: function (response) {
                    let articles = buildArticles(response);
                    $('#table').html(getArticlesView(articles));

                    if (isSearch) {
                        $('#search').val('');
                    }
                },
                error: function (response) {
                    alert(JSON.parse(response.responseText).message);
                }
            });
        }

        $('#date').on('change', function () {
            let data = {
                fromDate: this.value,
                "_token": "{{ csrf_token() }}"
            };
            ajax(data);
        });

        $('#find').on('click', function() {
            let search = $('#search').val();
            let data = {
                search,
                "_token": "{{ csrf_token() }}"
            }
            ajax(data, true);
        });

    </script>
@endsection
