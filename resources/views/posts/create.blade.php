@extends('layouts.layout')
@section('title')
    Создание поста
@endsection
@section('content')

    <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <h3>Создать пост</h3>
        @include('posts.parts.form')
        <input type="submit" class="btn btn-outline-success" value="Создать пост">
    </form>

@endsection