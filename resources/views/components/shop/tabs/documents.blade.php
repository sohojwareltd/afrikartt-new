@props(['shop', 'vendorData'])

@php
    $documents = [
        'business_license' => 'Business License',
        'export_license_doc' => 'Export License',
        'fnb_certificate' => 'F&B Certificate',
        'organic_certification' => 'Organic Certification',
        'fda_certificate' => 'FDA Certificate',
    ];

    $idDocuments = [
        'govt_id_front' => 'Government ID (Front)',
        'govt_id_back' => 'Government ID (Back)',
    ];

    $hasDocuments = false;
    foreach (array_merge($documents, $idDocuments) as $key => $label) {
        if (!empty($vendorData[$key])) {
            $hasDocuments = true;
            break;
        }
    }
@endphp

<div x-show="tab === 'documents'" x-cloak>
    <div class="bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Business Documents</h3>

        @if ($hasDocuments)
            {{-- Business Documents --}}
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Certificates & Licenses
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($documents as $key => $label)
                        @if (!empty($vendorData[$key]))
                            <div
                                class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h5 class="font-medium text-gray-900 mb-1">{{ $label }}</h5>
                                        <p class="text-xs text-gray-500 mb-3">
                                            {{ basename($vendorData[$key]) }}
                                        </p>
                                        <div class="flex gap-2">
                                            <a href="{{ Storage::url($vendorData[$key]) }}" target="_blank"
                                                class="inline-flex items-center px-3 py-1.5 bg-primary-600 text-white text-xs font-medium rounded hover:bg-primary-700 transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View
                                            </a>
                                            <a href="{{ Storage::url($vendorData[$key]) }}" download
                                                class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-medium rounded hover:bg-gray-200 transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        @php
                                            $extension = strtolower(pathinfo($vendorData[$key], PATHINFO_EXTENSION));
                                            $isPdf = $extension === 'pdf';
                                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                        @endphp
                                        @if ($isPdf)
                                            <div class="w-12 h-12 bg-red-100 rounded flex items-center justify-center">
                                                <svg class="w-6 h-6 text-red-600" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @elseif($isImage)
                                            <img src="{{ Storage::url($vendorData[$key]) }}" alt="{{ $label }}"
                                                class="w-12 h-12 object-cover rounded border border-gray-200">
                                        @else
                                            <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-600" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Identity Documents --}}
            @if (!empty($vendorData['govt_id_front']) || !empty($vendorData['govt_id_back']))
                <div>
                    <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                        Identity Verification
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($idDocuments as $key => $label)
                            @if (!empty($vendorData[$key]))
                                <div
                                    class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h5 class="font-medium text-gray-900 mb-1">{{ $label }}</h5>
                                            <p class="text-xs text-gray-500 mb-3">
                                                {{ basename($vendorData[$key]) }}
                                            </p>
                                            <div class="flex gap-2">
                                                <a href="{{ Storage::url($vendorData[$key]) }}" target="_blank"
                                                    class="inline-flex items-center px-3 py-1.5 bg-primary-600 text-white text-xs font-medium rounded hover:bg-primary-700 transition-colors">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    View
                                                </a>
                                                <a href="{{ Storage::url($vendorData[$key]) }}" download
                                                    class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 text-xs font-medium rounded hover:bg-gray-200 transition-colors">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    Download
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <img src="{{ Storage::url($vendorData[$key]) }}" alt="{{ $label }}"
                                                class="w-16 h-16 object-cover rounded border border-gray-200">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No Documents Uploaded</h3>
                <p class="mt-1 text-sm text-gray-500">No business documents or certificates have been uploaded yet.</p>
            </div>
        @endif
    </div>
</div>
