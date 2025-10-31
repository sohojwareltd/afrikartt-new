<x-filament-panels::page>
    @push('styles')
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'system-ui', 'sans-serif'],
                        },
                    }
                }
            }
        </script>
        <style>
            .profile-card {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .profile-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            .tab-button {
                transition: all 0.2s ease-in-out;
            }

            .tab-button.active {
                background: darkcyan;
                color: white;
            }

            .form-section {
                animation: fadeIn 0.5s ease-in-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .avatar-upload {
                position: relative;
                display: inline-block;
            }

            .avatar-upload:hover .avatar-overlay {
                opacity: 1;
            }

            .avatar-banner-upload {
                position: relative;
            }

            .avatar-banner-upload:hover .avatar-banner-overlay {
                opacity: 1;
            }

            .avatar-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .avatar-banner-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .progress-ring {
                transform: rotate(-90deg);
            }

            .progress-ring-circle {
                transition: stroke-dasharray 0.35s;
                transform-origin: 50% 50%;
            }

            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .glass-effect {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .status-indicator {
                animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            @keyframes pulse {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.5;
                }
            }

            /* Modal Enhancements */
            .modal-content {
                border-radius: 16px;
                overflow: hidden;
            }

            .modal-header {
                background: linear-gradient(135deg, #f97316 0%, #dc2626 100%);
            }

            .modal-body {
                font-family: 'Inter', sans-serif;
            }

            .modal-footer {
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            }

            .btn-primary {
                background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
                border: none;
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            }

            .btn-secondary {
                background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
                border: none;
                transition: all 0.3s ease;
            }

            .btn-secondary:hover {
                background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
                transform: translateY(-1px);
            }

            /* Modal Animation */
            .modal.fade .modal-dialog {
                transition: transform 0.3s ease-out;
                transform: translate(0, -50px);
            }

            .modal.show .modal-dialog {
                transform: none;
            }
        </style>
    @endpush

    @php
        $user = Auth::user();
        $shop = $user->shop;

        $userFields = ['name', 'l_name', 'email'];
        $shopFields = [
            'name',
            'logo',
            'banner',
            'short_description',
            'company_name',
            'company_registration',
            'description',
            'phone',
            'email',
            'city',
            'state',
            'post_code',
            'country',
        ];

        $userCompleted = collect($userFields)->filter(fn($field) => !empty($user->$field))->count();
        $shopCompleted = collect($shopFields)->filter(fn($field) => !empty($shop->$field))->count();
        $totalFields = count($userFields) + count($shopFields);
        $completedFields = $userCompleted + $shopCompleted;
        $profileCompletion = round(($completedFields / $totalFields) * 100);
        $radius = 28;
        $circumference = 2 * M_PI * $radius;
        $offset = $circumference * (1 - $profileCompletion / 100);
    @endphp

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Success Alert Box -->
            @if(session('success_msg'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('success_msg') }}
                            </p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button type="button" onclick="this.parentElement.parentElement.parentElement.parentElement.remove()" class="inline-flex bg-green-50 text-green-500 rounded-full p-1.5 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">
                                    <span class="sr-only">Dismiss</span>
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Enhanced Header Section -->
            <form method="post" action="{{ route('vendor.logo.cover') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-8">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <div class="">
                            <div class="card">
                                <div class="card-header avatar-banner-upload">
                                    @php
                                        $bannerPath = $shop ? $shop->banner : null;
                                        $extension = $bannerPath
                                            ? strtolower(pathinfo($bannerPath, PATHINFO_EXTENSION))
                                            : '';
                                        $videoExtensions = ['mp4', 'webm', 'ogg', 'mov', 'avi'];
                                        $imageExtensions = [
                                            'jpeg',
                                            'png',
                                            'webp',
                                            'jpg',
                                            'gif',
                                            'svg',
                                            'svg+xml',
                                            'avif',
                                        ];

                                        $isVideo = $bannerPath && in_array($extension, $videoExtensions);
                                        $isImage = $bannerPath && in_array($extension, $imageExtensions);
                                    @endphp
                                    {{-- @dd($bannerPath, $isVideo, $isImage) --}}
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
                                    <div class="avatar-banner-overlay">
                                        <div
                                            class="absolute inset-0 bg-black/40 flex items-center justify-center hover:bg-black/60 transition cursor-pointer">
                                            <label for="banner-upload"
                                                class="flex flex-col items-center text-white w-full">
                                                <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span class="text-xs">Change Banner</span>
                                            </label>
                                            <input id="banner-upload" type="file" name="banner" class="hidden" />
                                        </div>
                                    </div>
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
                                    <div class="avatar-overlay">
                                        <label for="logo-upload" class="flex flex-col items-center text-white">
                                            <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="text-xs">Change logo</span>
                                        </label>
                                        <input id="logo-upload" type="file" name="logo" class="hidden" />
                                    </div>
                                </div>
                                <div class=" ms-6">
                                    <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }} {{ $user->l_name }}
                                    </h1>
                                    <p class="text-gray-600">{{ $user->email }}</p>
                                    <div class="flex items-center mt-1 space-x-2">
                                        <span
                                            class="inline-flex items-center py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                            <span
                                                class="w-2 h-2 bg-primary-400 rounded-full mr-1 status-indicator"></span>
                                            Vendor Profile
                                        </span>
                                        @if ($shop)
                                            @if ($shop->status == 1)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200 shadow-sm ms-1">
                                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Shop Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200 shadow-sm ms-1">
                                                    <svg class="w-4 h-4 mr-1 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728"/>
                                                    </svg>
                                                    Shop Inactive
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Profile Completion</p>
                                    <div class="flex items-center space-x-2 justify-center mt-3">
                                        <div class="w-16 h-16 relative">
                                            <svg class="w-16 h-16 progress-ring" viewBox="0 0 64 64">
                                                <circle cx="32" cy="32" r="28" stroke="#e5e7eb"
                                                    stroke-width="4" fill="transparent" />
                                                <circle cx="32" cy="32" r="28" stroke="#3b82f6"
                                                    stroke-width="4" fill="transparent"
                                                    stroke-dasharray="{{ 2 * pi() * 28 }}"
                                                    stroke-dashoffset="{{ 2 * pi() * 28 * (1 - $profileCompletion / 100) }}"
                                                    class="progress-ring-circle" />
                                            </svg>
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <span
                                                    class="text-sm font-bold text-gray-900">{{ $profileCompletion }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>


            <div x-data="{ tab: 'personal' }"
                class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mt-6">
                <!-- Enhanced Tab Navigation -->
                <div class="border-b border-gray-200 bg-gray-50">
                    <nav class="flex space-x-8 px-6" aria-label="Tabs">
                        <button @click="tab = 'personal'"
                            :class="tab === 'personal' ? 'border-primary-600 text-primary-600' :
                                'border-transparent text-gray-500 hover:text-primary-600 hover:border-primary-600'"
                            class="py-4 px-1 border-b-2 font-medium text-sm transition">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Shop Information
                            </div>
                        </button>
                        <button @click="tab = 'shop'"
                            :class="tab === 'shop' ? 'border-primary-600 text-primary-600' :
                                'border-transparent text-gray-500 hover:text-primary-600 hover:border-primary-600'"
                            class="py-4 px-1 border-b-2 font-medium text-sm transition">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Personal Information
                            </div>
                        </button>
                        <button @click="tab = 'security'"
                            :class="tab === 'security' ? 'border-primary-600 text-primary-600' :
                                'border-transparent text-gray-500 hover:text-primary-600 hover:border-primary-600'"
                            class="py-4 px-1 border-b-2 font-medium text-sm transition">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Security & Privacy
                            </div>
                        </button>
                    </nav>
                </div>

                <!-- Enhanced Tab Content -->
                <div class="p-6">
                    <div x-show="tab === 'personal'">
                        <form wire:submit="submit">
                            <div class="bg-gray-50 rounded-lg p-6">{{ $this->form }}</div>

                            <div class="flex justify-end mt-6">
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-primary-500 from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 shadow-lg">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Save Shop Information
                                </button>
                            </div>
                        </form>
                    </div>
                    <div x-show="tab === 'shop'" x-cloak>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <form action="{{ route('vendor.personal_info') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block mb-1">First Name</label>
                                        <input type="text" name="first_name" placeholder="First Name"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500"
                                            value="{{ $user->name }}">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Last Name</label>
                                        <input type="text" name="last_name" placeholder="Last Name"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500"
                                            value="{{ $user->l_name }}">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Email</label>
                                        <input type="email" name="email" placeholder="Email"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500"
                                            value="{{ $user->email }}">
                                    </div>
                                    <div>
                                        <label class="block mb-1">Photo</label>
                                        <input type="file" name="avatar"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500">
                                    </div>
                                    {{-- @dd($user->avatar) --}}
                                    {{-- @if ($user->avatar)
                                        <div class="col-span-1 md:col-span-2">
                                        <label class="block mb-1">Avatar</label>
                                        <img src="{{ Storage::url($user->avatar) }}" alt="User Avatar"
                                            class="w-20 h-20 object-cover mt-2 border border-gray-300 shadow" />
                                    </div>
                                    @endif --}}
                                </div>
                                <div class="flex justify-end mt-6">
                                    <button type="submit"
                                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition shadow">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Save Personal Information
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div x-show="tab === 'security'" x-cloak>
                        <div class="space-y-6">
                            <!-- Password Change Section -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Change Password</h3>
                                <form action="{{ route('vendor.update_password') }}" method="POST">
                                    @csrf
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Current
                                                Password</label>
                                            <input type="password" name="current_password"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500"
                                                placeholder="Enter current password" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">New
                                                Password</label>
                                            <input type="password" name="new_password"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500"
                                                placeholder="Enter new password" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New
                                                Password</label>
                                            <input type="password" name="new_password_confirmation"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500"
                                                placeholder="Confirm new password" required>
                                        </div>
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition-colors">
                                            Update Password
                                        </button>
                                    </div>
                                </form>

                            </div>

                        
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const bannerInput = document.getElementById('banner-upload');
                const logoInput = document.getElementById('logo-upload');

                bannerInput.addEventListener('change', function() {
                    this.closest('form').submit();
                });

                logoInput.addEventListener('change', function() {
                    this.closest('form').submit();
                });

                // Auto-open modal if shop is inactive
                @if ($shop && $shop->status == 1)
                    const shopStatusModal = new bootstrap.Modal(document.getElementById('shopStatusModal'));
                    shopStatusModal.show();
                @endif
            });
        </script>
    @endpush
</x-filament-panels::page>
