@extends('layouts.app')

@section('content')
    <x-app.header />
    <div class="container py-2">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <div class="bg-warning p-4 rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width: 100px; height: 100px;">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#856404"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                        </div>

                        <h1 class="h2 mb-3 text-danger">419 - Session Expired</h1>

                        <p class="text-muted mb-4">
                            Your session has expired. Click the button to start again.
                        </p>

                        <div class="d-grid gap-2 d-md-block">
                            <button id="refreshBtn" class="btn btn-success btn-lg">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" class="me-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Start Again
                            </button>
                        </div>

                        <div class="mt-4">
                            <p class="small text-muted">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" class="me-1">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                If you were working on something, your progress may not have been saved.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('refreshBtn').addEventListener('click', function() {
            // Clear browser cache and storage
            if ('caches' in window) {
                caches.keys().then(function(names) {
                    for (let name of names) {
                        caches.delete(name);
                    }
                });
            }

            // Clear localStorage and sessionStorage
            localStorage.clear();
            sessionStorage.clear();

            // Clear cookies (for this domain)
            document.cookie.split(";").forEach(function(c) {
                document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date()
                .toUTCString() + ";path=/");
            });

            // Force a hard reload from server
            window.location.href = "{{ url('/') }}";
        });
    </script>
@endsection
