<?php

use Illuminate\Support\Facades\Route;
use Firefly\FilamentBlog\Models\Post;
use Firefly\FilamentBlog\Models\Category;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});



// ✅ Blog List Page
Route::get('/blog', function () {
    $posts = Post::where('status', 'published')
        ->where(function ($query) {
            $query->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
        })
        ->latest()
        ->paginate(6);

    $categories = Category::all();

    return view('blog.index', compact('posts', 'categories'));
})->name('blog.index');

// ✅ Single Blog Post Page
Route::get('/blog/{slug}', function ($slug) {
    $post = Post::where('slug', $slug)
        ->where('status', 'published')
        ->where(function ($query) {
            $query->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
        })
        ->firstOrFail();

    $categories = Category::all();

    // 👇 Fetch previous and next posts by ID
    $previous = Post::where('id', '<', $post->id)
        ->where('status', 'published')
        ->orderBy('id', 'desc')
        ->first();

    $next = Post::where('id', '>', $post->id)
        ->where('status', 'published')
        ->orderBy('id', 'asc')
        ->first();

    return view('blog.show', compact('post', 'categories', 'previous', 'next'));
})->name('blog.show');