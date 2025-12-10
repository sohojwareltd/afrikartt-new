@props(['shop', 'profileCompletion'])

<div class="mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="">
            <div class="card">
                <div class="card-header avatar-banner-upload">
                    @php
                        $bannerPath = $shop ? $shop->banner : null;
                        $extension = $bannerPath ? strtolower(pathinfo($bannerPath, PATHINFO_EXTENSION)) : '';
                        $videoExtensions = ['mp4', 'webm', 'ogg', 'mov', 'avi'];
                        $imageExtensions = ['jpeg', 'png', 'webp', 'jpg', 'gif', 'svg', 'svg+xml', 'avif'];

                        $isVideo = $bannerPath && in_array($extension, $videoExtensions);
                        $isImage = $bannerPath && in_array($extension, $imageExtensions);
                    @endphp
                    @if ($bannerPath)
                        @if ($isVideo)
                            <video src="{{ Storage::url($bannerPath) }}" autoplay muted loop
                                class="w-full object-cover rounded-t-lg" style="height: 250px;"></video>
                        @elseif ($isImage)
                            <img src="{{ Storage::url($bannerPath) }}" alt="Shop Banner"
                                class="w-full object-cover rounded-t-lg" style="height: 250px;">
                        @else
                            <img src="{{ asset('assets/img/header.jpg') }}" alt="Default Banner"
                                class="w-full object-cover rounded-t-lg" style="height: 250px;">
                        @endif
                    @else
                        <img src="{{ asset('assets/img/heaer.jpg') }}" alt="Default Banner"
                            class="w-full object-cover rounded-t-lg" style="height: 250px;">
                    @endif
                </div>
            </div>
        </div>
        <div class="flex items-center justify-between mt-6">
            <div class="flex items-center space-x-4">
                <div class="avatar-upload">
                    @if ($shop && $shop->logo)
                        <img src="{{ Storage::url($shop->logo) }}" alt="Profile"
                            class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                    @else
                        <img src="{{ asset('assets/img/heaer.jpg') }}" alt="Profile"
                            class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                    @endif
                </div>
                <div class=" ms-6">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $shop->name }}
                    </h1>
                    <p class="text-gray-600">{{ $shop->email }}</p>
                    <div class="flex items-center mt-1">
                        <span
                            class="inline-flex items-center py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                            <span class="w-2 h-2 bg-primary-400 rounded-full mr-1 status-indicator"></span>
                            Vendor Profile
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="text-right">
                    <p class="text-sm text-gray-500">Profile Completion</p>
                    <div class="flex items-center space-x-2 justify-center mt-3">
                        <div class="w-16 h-16 relative">
                            <svg class="w-16 h-16 progress-ring" viewBox="0 0 64 64">
                                <circle cx="32" cy="32" r="28" stroke="#e5e7eb" stroke-width="4"
                                    fill="transparent" />
                                <circle cx="32" cy="32" r="28" stroke="#3b82f6" stroke-width="4"
                                    fill="transparent" stroke-dasharray="{{ 2 * pi() * 28 }}"
                                    stroke-dashoffset="{{ 2 * pi() * 28 * (1 - $profileCompletion / 100) }}"
                                    class="progress-ring-circle" />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-sm font-bold text-gray-900">{{ $profileCompletion }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
