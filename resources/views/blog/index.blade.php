@extends('layouts.public')

@section('title', 'Blog')
@section('header', 'Our Blog')
@section('subheader', 'Latest stories, insights, and tutorials.')

@section('content')
<div class="row">

    <!-- Left Column: Blog Posts -->
    <div class="col-lg-8">
        <div class="row g-4">
            @forelse($posts as $post)
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        @php
                            $imagePath = null;
                            $path = $post->cover_photo_path ?? '';

                            if (!empty($path)) {
                                if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                                    $imagePath = $path;
                                } elseif (str_starts_with($path, 'storage/') || str_starts_with($path, 'public/')) {
                                    $imagePath = asset($path);
                                } else {
                                    $imagePath = asset('storage/' . ltrim($path, '/'));
                                }
                            }

                            // Clean and shorten the body
                            $cleanBody = strip_tags(html_entity_decode($post->body ?? ''));
                            $cleanBody = trim(preg_replace('/\s+/', ' ', $cleanBody));
                            $previewText = mb_strlen($cleanBody) > 120 
                                ? mb_substr($cleanBody, 0, 120) . '...' 
                                : $cleanBody;
                        @endphp

                        @if($imagePath)
                            <img src="{{ $imagePath }}" 
                                 alt="{{ $post->photo_alt_text ?? $post->title }}" 
                                 class="card-img-top" style="height: 220px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 220px;">
                                <span class="text-muted small fst-italic">No Image Available</span>
                            </div>
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('blog.show', $post->slug) }}" 
                                   class="text-decoration-none text-dark fw-semibold">
                                    {{ $post->title }}
                                </a>
                            </h5>
                            <p class="text-muted small mb-2">
                                {{ $post->published_at?->format('M d, Y') ?? $post->created_at->format('M d, Y') }}
                            </p>
                            <p class="card-text text-secondary small">
                                {{ $previewText }}
                            </p>
                            <a href="{{ route('blog.show', $post->slug) }}" 
                               class="btn btn-sm btn-outline-primary mt-2">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No blog posts available yet.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Right Column: Sidebar -->
    <div class="col-lg-4 mt-4 mt-lg-0">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title mb-3 fw-semibold">Categories</h5>
                @if($categories->count())
                    <ul class="list-unstyled mb-0">
                        @foreach($categories as $category)
                            <li class="mb-2">
                                <a href="{{ url('/blog?category='.$category->slug) }}" 
                                   class="text-decoration-none text-secondary d-flex align-items-center justify-content-between">
                                    <span><i class="bi bi-folder me-2 text-primary"></i>{{ $category->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted small">No categories available.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
