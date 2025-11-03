@extends('layouts.app')

@section('content')
    <x-app.header />

    <div class="container py-5">
        <h1 class="text-center mb-5 fw-bold">Latest Blogs</h1>

        @if ($blogs->count())
            <div class="row g-4">
                @foreach ($blogs as $blog)
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            @if ($blog->image)
                                <a href="{{ route('blog.details', $blog->slug) }}">
                                    <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top rounded-top"
                                        style="height: 230px; object-fit: cover;" alt="{{ $blog->title }}">
                                </a>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <div class="small text-muted mb-2">
                                    {{ optional($blog->published_at)->format('F d, Y') }}
                                </div>
                                <h5 class="card-title fw-semibold">
                                    <a href="{{ route('blog.details', $blog->slug) }}"
                                        class="text-dark text-decoration-none">
                                        {{ $blog->title }}
                                    </a>
                                </h5>
                                <p class="text-secondary mb-4">{{ Str::limit($blog->excerpt, 120) }}</p>
                                <a href="{{ route('blog.details', $blog->slug) }}"
                                    class="mt-auto btn btn-outline-primary">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-5">
                {{ $blogs->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076508.png" alt="No blogs"
                    style="width: 150px; opacity: 0.8;">
                <h4 class="mt-4 fw-semibold">No Blogs Available Yet</h4>
                <p class="text-muted">Check back soon for the latest updates and stories.</p>
                <a href="{{ url('/') }}" class="btn btn-primary mt-3 px-4">
                    Back to Home
                </a>
            </div>
        @endif
    </div>
@endsection
