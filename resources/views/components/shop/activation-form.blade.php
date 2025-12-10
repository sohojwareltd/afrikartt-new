@props(['shop'])

<div class="px-6 py-4 border-t border-gray-200">
    <form action="{{ route('shop_status_update', $shop->id) }}" method="POST">
        @csrf
        <div>
            @if ($shop->status == 1)
                <button type="submit" name="status" value="deactivate" class="border px-3.5 py-1.5 rounded-lg mt-3"
                    style="background: rgb(255, 0, 0); color: #ffff;">
                    Deactivate
                </button>
            @else
                <button type="submit" name="status" value="activate" class="border px-3.5 py-1.5 rounded-lg mt-3"
                    style="background: seagreen; color: #ffff;">
                    Activate
                </button>
            @endif
        </div>
    </form>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bannerInput = document.getElementById('banner-upload');
            const logoInput = document.getElementById('logo-upload');

            if (bannerInput) {
                bannerInput.addEventListener('change', function() {
                    this.closest('form').submit();
                });
            }

            if (logoInput) {
                logoInput.addEventListener('change', function() {
                    this.closest('form').submit();
                });
            }
        });
    </script>
@endpush
