@extends('layouts.layout')
@include('layouts.title')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h2>{{$post->title}}</h2></div>
                <div class="card-body">
                    <div class="card-img card-img_max"
                         style="background-image: url({{$post->img ?? asset('img/default.jpg')}})">
                    </div>
                    <div class="card-author">Автор: {{$post->name}}</div>
                    <div class="card-date">Пост создан: {{$post->created_at->diffForHumans()}}</div>
                    <div class="card-description jumbotron">{{$post->description}}</div>
                    <div class="card-btn">
                        <a href="{{URL::previous()}}" class="btn btn-outline-primary">Назад</a>
                        <a href="{{route('posts.edit' , ['id' => $post->post_id])}}" class="btn btn-outline-secondary">Редактировать</a>
                        <form action="{{route('posts.destroy', ['id' => $post->post_id])}}" method="post" onsubmit="return confirm('Вы уверены, что хотите удалить пост?');">
                            @csrf
                            @method('delete')
                            <input type="submit" class="btn btn-outline-danger" value="Удалить">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
