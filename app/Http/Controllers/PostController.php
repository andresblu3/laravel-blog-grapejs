<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->get(['id', 'title', 'slug', 'excerpt', 'published_at']);

        return Inertia::render('Welcome', [
            'posts' => $posts,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    public function show(Post $post)
    {
        if (!$post->is_published) {
            abort(404);
        }

        return Inertia::render('Posts/Show', [
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'published_at' => $post->published_at,
            ],
            'auth' => [
                'user' => Auth::user(),
            ],
        ]);
    }
} 