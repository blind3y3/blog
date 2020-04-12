<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostsRequest;
use App\Post;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index','show');
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        if ($request->search) {
            $posts = Post::join('users', 'author_id', '=', 'users.id')
                ->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')
                ->orWhere('name', 'like', '%' . $request->search . '%')
                ->orderBy('posts.created_at', 'desc')
                ->get();

            return view('posts.index', compact('posts'));
        }

        $posts = Post::join('users', 'author_id', '=', 'users.id')->orderBy('posts.created_at', 'desc')->paginate(4);//вывод по 4 поста

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param PostsRequest $request
     * @return RedirectResponse|Redirector
     */
    public function store(PostsRequest $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->short_title = Str::length($request->title) > 30 ? Str::limit($request->title, 30, '...') : $request->title; //да простят меня за несоблюдение PSR
        $post->description = $request->description;
        $post->author_id = \Auth::user()->id;
        if ($request->file('img')) {
            $path = Storage::putFile('public', $request->file('img'));
            $url = Storage::url($path);
            $post->img = $url;
        }

        $post->save();

        return redirect('posts')->with('success', 'Пост успешно создан.');
    }

    /**
     * Display the specified resource.
     * @param $id
     * @return Factory|View
     */
    public function show($id)
    {
        $post = Post::join('users', 'author_id', '=', 'users.id')->findOrFail($id);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if ($post->author_id != \Auth::user()->id) {
            return redirect('/')->withErrors('Вы не можете редактировать данный пост.');
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     * @param PostsRequest $request
     * @param $id
     * @return RedirectResponse|Redirector
     */
    public function update(PostsRequest $request, $id)
    {
        $post = Post::find($id);

        if ($post->author_id != \Auth::user()->id) {
            return redirect('/')->withErrors('Вы не можете редактировать данный пост.');
        }

        $post->title = $request->title;
        $post->short_title = Str::length($request->title) > 30 ? Str::limit($request->title, 30, '...') : $request->title;
        $post->description = $request->description;
        if ($request->file('img')) {
            $path = Storage::putFile('public', $request->file('img'));
            $url = Storage::url($path);
            $post->img = $url;
        }
        $post->update();

        $id = $post->post_id;
        return redirect()->route('posts.show', compact('id'))->with('success', 'Пост успешно отредактирован.');
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post->author_id != \Auth::user()->id) {
            return redirect('/')->withErrors('Вы не можете удалить данный пост.');
        }

        $post->delete();

        return redirect('posts')->with('success', 'Пост успешно удалён.');
    }
}
