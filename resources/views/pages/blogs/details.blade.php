@extends('layouts.app')
@section('css')
    <style>
        .content img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 15px auto;
            border-radius: 8px;
        }

        .content iframe,
        .content table {
            max-width: 100%;
            width: 100%;
        }

        .content table {
            display: block;
            overflow-x: auto;
            border-collapse: collapse;
        }
    </style>
@endsection
@section('content')
    <x-app.header />
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="fw-bold mb-3">{{ $blog->title }}</h1>
                <div class="text-muted mb-4">

                    Published on {{ optional($blog->published_at)->format('F d, Y') }}
                </div>

                @if ($blog->image)
                    <img src="{{ asset('storage/' . $blog->image) }}" class="img-fluid rounded mb-4" alt="{{ $blog->title }}">
                @endif

                <div class="content mb-5" style="line-height: 1.8; font-size: 1.05rem;">
                    {!! $blog->content !!}
                </div>
            </div>
        </div>

        @if ($relatedBlogs->count())
            <div class="mt-5">
                <h3 class="fw-semibold text-center mb-4">Related Blogs</h3>
                <div class="row g-4">
                    @foreach ($relatedBlogs as $related)
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                @if ($related->image)
                                    <a href="{{ route('blog.details', $related->slug) }}">
                                        <img src="{{ asset('storage/' . $related->image) }}"
                                            class="card-img-top rounded-top" style="height: 200px; object-fit: cover;"
                                            alt="{{ $related->title }}">
                                    </a>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title fw-semibold mb-2">
                                        <a href="{{ route('blog.details', $related->slug) }}"
                                            class="text-dark text-decoration-none">
                                            {{ Str::limit($related->title, 60) }}
                                        </a>
                                    </h6>
                                    <p class="text-secondary mb-3">{{ Str::limit($related->excerpt, 80) }}</p>
                                    <a href="{{ route('blog.details', $related->slug) }}"
                                        class="mt-auto text-primary text-decoration-none">
                                        Read More →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection
