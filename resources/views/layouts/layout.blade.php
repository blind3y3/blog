<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Posts')</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="{{asset('js/jquery.highlight.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="container collapse navbar-collapse" id="collapsedNavbar">
        <ul class="col-6 navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/">Главная <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active offset-lg-3">
                <a class="nav-link" href="{{route('posts.create')}}">Создать пост <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="{{route('posts.index')}}">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Найти пост"
                   aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
        </form>
    </div>
</nav>

<div class="container">
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{$error}}
            </div>
        @endforeach
    @endif
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{session('success')}}
        </div>
    @endif
    @yield('content')
</div>

</body>
<script src="{{asset('js/app.js')}}"></script>

</html>