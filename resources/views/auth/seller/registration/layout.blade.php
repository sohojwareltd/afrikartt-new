@extends('layouts.app')

@section('content')
    <x-app.header />
    <section class="ec-page-content section-space-p" style="background: #f4fbfd; min-height: 100vh; padding: 48px 0;">
        <div class="container">


            <div class="d-flex flex-column align-items-center step-indicator">
                @php
                    $steps = ['Basic Info', 'Email Verification', 'Terms & Conditions', 'Vendor Verification', 'Shop Info'];
                @endphp
                <div class="d-flex align-items-center justify-content-center " style="gap: 24px;">

                    @foreach ($steps as $step)
                        @include('auth.seller.registration.includes.step', [
                            'index' => $loop->iteration,
                            'step' => $step,
                            'current_step' => $current_step,
                        ])
                    @endforeach


                </div>


            </div>
            @yield('registration-content')





        </div>

    </section>
@endsection
