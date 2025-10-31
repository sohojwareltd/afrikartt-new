<x-filament::page>
    <x-filament::card>
        @php
            $ticket = $this->record;
        @endphp

        <!-- Reply Form -->
        <form class="space-y-6 mb-8" action="{{ route('ticket.reply', $ticket) }}" method="POST"
            enctype='multipart/form-data'>
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                <textarea
                    class="w-full min-h-[120px] border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 p-3 border"
                    placeholder="Type your reply here..." name="massage" id="massage" required>{{ old('massage') }}</textarea>
                @error('massage')
                    <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Attachment</label>
                <div class="w-full">
                    <label class="flex flex-col w-full cursor-pointer">
                        <div
                            class="flex flex-col items-center justify-center pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50">
                            <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500">Click to upload or drag and drop</p>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF (MAX. 5MB)</p>
                        </div>
                        <input type="file" class="hidden" accept="image/*" name="image" id="image">
                    </label>
                </div>
                @error('image')
                    <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors">
                    Submit Reply
                </button>
            </div>
        </form>

        <!-- Ticket Thread -->
        <div class="space-y-6">
            <!-- Original Ticket -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mt-3">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-lg font-medium text-gray-900">{{ $ticket->subject }}</h3>
                    <span class="text-sm text-gray-500">{{ $ticket->created_at->diffForHumans() }}</span>
                </div>
                <div class="prose prose-sm max-w-none text-gray-700 mb-4">
                    {{ $ticket->massage }}
                </div>
                @if ($ticket->image)
                    <div class="mt-3">
                        <p class="text-sm font-medium text-gray-700 mb-1">Attachment:</p>
                        <a href="{{ Storage::url($ticket->image) }}" target="_blank"
                            class="text-primary-600 hover:text-primary-800 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                </path>
                            </svg>
                            View Attachment
                        </a>
                    </div>
                @endif
            </div>

            <!-- Updates Section -->
            <h4 class="text-lg font-medium text-gray-900 mt-8 mb-4">Updates</h4>

            @foreach ($ticket->children as $reply)
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 {{ $reply->user_id == Auth()->id() ? 'border-l-4 border-l-primary-500' : '' }}">
                    <div class="flex items-start gap-3 mb-3">
                        @if ($reply->user->role_id == 1)
                            <img src="{{ asset('images/user-2.png') }}" class="w-8 h-8 rounded-full" alt="User">
                        @else
                            <div
                                class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 text-primary-800 font-medium">
                                {{ $reply->user->name[0] }}
                            </div>
                        @endif
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <h5 class="text-sm font-medium text-gray-900">{{ $reply->user->name }}</h5>
                                <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="prose prose-sm max-w-none text-gray-700 mt-1">
                                {{ $reply->massage }}
                            </div>
                            @if ($reply->image)
                                <div class="mt-3">
                                    <p class="text-xs font-medium text-gray-700 mb-1">Attachment:</p>
                                    <a href="{{ Storage::url($reply->image) }}" target="_blank"
                                        class="text-primary-600 hover:text-primary-800 text-xs flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                            </path>
                                        </svg>
                                        View Attachment
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::card>
</x-filament::page>
