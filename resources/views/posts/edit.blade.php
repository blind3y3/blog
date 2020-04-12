@extends('layouts.layout')
@section('title')
    Редактирование поста
@endsection
@section('content')

    <form action="{{route('posts.update', ['id' => $post->post_id])}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <h3>Редактировать пост</h3>
        @include('posts.parts.form')
        <input type="submit" class="btn btn-outline-success" value="Обновить пост">
        <a class="btn btn-outline-dark" href="{{URL::previous()}}">Назад</a>
    </form>

@endsection