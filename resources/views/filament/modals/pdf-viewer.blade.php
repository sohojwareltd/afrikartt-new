<div class="p-4">
    <div class="border rounded-lg overflow-hidden" style="height: 70vh;">
        <iframe src="{{ $url }}" class="w-full h-full" frameborder="0">
        </iframe>
    </div>
    <div class="mt-4 text-center">
        <a href="{{ $url }}" target="_blank"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
            </svg>
            Open PDF in New Tab
        </a>
    </div>
</div>
