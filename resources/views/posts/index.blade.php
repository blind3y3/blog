@extends('layouts.layout')

@section('content')
    @if (isset($_GET['search']))
        @if (count($posts) > 0)
            <h2>Результаты поиска по запросу {{$_GET['search']}}:</h2>
            <p class="lead">Постов найдено: {{count($posts)}}</p>
        @else
            <h2>По запросу {{$_GET['search']}} ничего не найдено.</h2>
            <a class="btn btn-outline-dark" href="{{route('posts.index')}}">Отобразить все посты</a>
        @endif
    @endif

    <div class="row">
        @foreach($posts as $post)
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-header"><h2>{{$post->short_title}}</h2></div>

                    <div class="card-body">
                        <div class="card-img"
                             style="background-image: url({{$post->img ?? asset('img/default.jpg')}})">
                        </div>
                        <div class="card-author">Автор: {{$post->name}}</div>
                        <a href="{{route('posts.show', ['id' => $post->post_id])}}" class="btn btn-outline-dark">Посмотреть
                            пост</a>
                    </div>

                    @if (isset($_GET['search']) && count($posts) > 0)
                        <div class="card-body card-description">
                            <p>{{$post->description}}</p>
                        </div>
                        <script>
                            $('h2').not(':first').add('div.card-description').add('.card-author').highlight("{{$_GET['search']}}");
                        </script>
                    @endif

                </div>
            </div>
        @endforeach
    </div>

    @if (!isset($_GET['search']))
        {{$posts->links()}}
    @endif

@endsection