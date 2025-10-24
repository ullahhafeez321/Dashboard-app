@extends('layouts.public')

@section('title', $post->title)
@section('header', $post->title)
@section('subheader', $post->sub_title ?? 'Blog Post')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10 col-xl-8">

        <!-- 🖼 Cover Image -->
        @php
            use Illuminate\Support\Str;

            $imagePath = null;
            if (!empty($post->cover_photo_path)) {
                if (Str::startsWith($post->cover_photo_path, ['http://', 'https://'])) {
                    $imagePath = $post->cover_photo_path;
                } else {
                    $imagePath = asset('storage/' . ltrim($post->cover_photo_path, '/'));
                }
            }
        @endphp

        @if($imagePath)
            <img src="{{ $imagePath }}" 
                 alt="{{ $post->photo_alt_text ?? $post->title }}" 
                 class="img-fluid rounded mb-4 shadow-sm w-100" 
                 style="max-height: 450px; object-fit: cover;">
        @endif

        <!-- 📝 Blog Post Content -->
        <article class="bg-white rounded shadow-sm p-4 p-md-5 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <small class="text-muted">
                    <i class="bi bi-calendar-event me-1"></i>
                    {{ $post->published_at?->format('F d, Y') ?? $post->created_at->format('F d, Y') }}
                </small>

                @if($post->author ?? false)
                    <small class="text-muted">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ $post->author->name ?? 'Unknown Author' }}
                    </small>
                @endif
            </div>

            <h1 class="fw-bold mb-3">{{ $post->title }}</h1>

            @if($post->sub_title)
                <h5 class="text-secondary mb-4">{{ $post->sub_title }}</h5>
            @endif

            <!-- 🖋 Blog Body (with inline image fixes) -->
           <div class="post-body mb-4">
            @php
                $body = $post->body;

                // 1️⃣ Replace Filament-style editor images (alt + data-id)
                $body = preg_replace_callback(
                    '/alt="([^"]*)"\s+data-id="([^">]+)"/i',
                    function ($matches) {
                        $alt = trim($matches[1]);
                        $file = trim($matches[2]);
                        $src = asset('storage/' . ltrim($file, '/'));
                        return '<img src="' . e($src) . '" alt="' . e($alt) . '" class="img-fluid rounded shadow-sm my-4 w-100">';
                    },
                    $body
                );

                // 2️⃣ Replace normal <img src="..."> tags
                $body = preg_replace_callback(
                    '/<img[^>]+src="([^">]+)"/i',
                    function ($matches) {
                        $src = trim($matches[1]);
                        if (!\Illuminate\Support\Str::startsWith($src, ['http://', 'https://', 'data:'])) {
                            $src = asset('storage/' . ltrim(preg_replace('/^(public\/)?storage\//', '', $src), '/'));
                        }
                        return '<img src="' . e($src) . '" class="img-fluid rounded shadow-sm my-4 w-100">';
                    },
                    $body
                );

                // 3️⃣ Remove leftover junk like > class="..." and extra >
                $body = preg_replace([
                    '/\s*alt="[^"]*"/i',
                    '/\s*data-id="[^"]*"/i',
                    '/>\s*class="[^"]*"\s*>?/',
                    '/>{2,}/',
                    '/\s+>$/m'
                ], '>', $body);

            @endphp

            {!! $body !!}
        </div>


            <!-- 🏷 Categories -->
            @if($post->categories && $post->categories->count())
                <div class="mb-3">
                    <strong class="text-dark me-2">Categories:</strong>
                    @foreach($post->categories as $category)
                        <a href="{{ url('/blog?category='.$category->slug) }}" 
                           class="badge bg-primary text-decoration-none me-1">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            <!-- 🔖 Tags -->
            @if($post->tags && $post->tags->count())
                <div class="mb-3">
                    <strong class="text-dark me-2">Tags:</strong>
                    @foreach($post->tags as $tag)
                        <span class="badge bg-light text-dark border me-1">#{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif
        </article>

        <!-- 🔄 Previous & Next Navigation -->
        <div class="d-flex justify-content-between align-items-center my-4">
            @isset($previous)
                <a href="{{ route('blog.show', $previous->slug) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> {{ Str::limit($previous->title, 40) }}
                </a>
            @else
                <div></div>
            @endisset

            @isset($next)
                <a href="{{ route('blog.show', $next->slug) }}" class="btn btn-outline-primary">
                    {{ Str::limit($next->title, 40) }} <i class="bi bi-arrow-right"></i>
                </a>
            @endisset
        </div>

        <!-- 💬 Comments (placeholder) -->
        <div class="bg-light p-4 rounded shadow-sm mt-5">
            <h4 class="fw-semibold mb-3">Comments</h4>
            <p class="text-muted mb-0">Comment functionality coming soon...</p>
        </div>

    </div>
</div>
@endsection
