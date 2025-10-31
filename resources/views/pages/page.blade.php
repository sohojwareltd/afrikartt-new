@extends('layouts.app')
@section('content')
    <x-app.header />

    <section class="py-5 bg-light border-bottom">
        <div class="container text-center">
            <h1 class="fw-bold mb-3">{{ $page->title }}</h1>
            @if ($page->excerpt)
                <p class="text-muted lead mb-0">{{ $page->excerpt }}</p>
            @endif
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            @if ($page->layout_type === 'accordion' && !empty($page->accordions))
                <div class="accordion accordion-flush" id="pageAccordion">
                    @foreach ($page->accordions as $index => $item)
                        <div class="accordion-item mb-3 border rounded">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button collapsed fw-semibold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}"
                                    aria-expanded="false" aria-controls="collapse{{ $index }}">
                                    {{ $item['title'] }}
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse"
                                aria-labelledby="heading{{ $index }}" data-bs-parent="#pageAccordion">
                                <div class="accordion-body">
                                    {!! $item['content'] !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <article class="fs-5">
                    {!! $page->body !!}
                </article>
            @endif
        </div>
    </section>
@endsection
