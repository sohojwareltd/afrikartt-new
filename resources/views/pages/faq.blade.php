@extends('layouts.app')

@section('title', 'Frequently Asked Questions')

@section('content')
    <x-app.header />
    <div class="container py-5">
        <h1 class="mb-4 text-center" style="color: #5D6532">Frequently Asked Questions</h1>

        <div class="accordion" id="faqAccordion">
            @foreach ($faqs as $index => $faq)
                <div class="accordion-item mb-3 border rounded">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}"
                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                            aria-controls="collapse{{ $index }}">
                            {{ $faq->question }}
                        </button>
                    </h2>
                    <div id="collapse{{ $index }}"
                        class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                        aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            {!! nl2br(e($faq->answer)) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
