<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('site.blog.index', [
            'posts' => BlogPost::query()->where('is_published', true)->latest('published_at')->paginate(9),
        ]);
    }

    public function show(BlogPost $post): View
    {
        abort_unless($post->is_published, 404);

        return view('site.blog.show', compact('post'));
    }
}
