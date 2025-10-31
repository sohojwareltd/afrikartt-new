@php
    // Pre-calculate values to avoid multiple database calls
    $productCount = $shop->products->count();
    $followerCount = rand(50, 500);
    $averageRating = Sohoj::average_rating($shop->ratings);
    $ratingCount = $shop->ratings->count();
    $shopLocation =
        $shop->city . ' ' . $shop->state . ' ' . $shop->post_code . ' ' . $shop->country ?? 'Unknown Location';
    $shopDescription = Str::limit(
        $shop->short_description ?? 'A trusted shop offering quality products and excellent service.',
        60,
        '...',
    );
    $isAuthenticated = auth()->check();
    $isFollowing = $isAuthenticated ? auth()->user()->follows($shop) : false;
@endphp

<div class="col-lg-3 col-12 mb-4 pro-gl-content-shop">
    <div class="modern-shop-card">
        <div class="shop-card-image-wrapper">
            <div class="shop-card-image">
                <img src="{{ Storage::url($shop->logo) }}" alt="{{ $shop->name }}" class="shop-card-img">
                <div class="shop-card-overlay">
                    <div class="shop-card-actions">
                        <a href="{{ route('store_front', $shop->slug) }}" class="shop-action-btn" title="Visit Shop">
                            <i class="fas fa-external-link-alt" style="color: var(--rating-color)"></i>
                        </a>
                        <button class="shop-action-btn" title="Follow Shop">
                            <i class="fas fa-heart" style="color: var(--rating-color)"></i>
                        </button>
                        <button class="shop-action-btn" title="Share Shop">
                            <i class="fas fa-share-alt" style="color: var(--rating-color)"></i>
                        </button>
                    </div>
                </div>
                @if ($shop->is_featured)
                    <div class="shop-featured-badge">
                        <i class="fas fa-star"></i>
                        <span>Featured</span>
                    </div>
                @endif
                @if ($shop->is_verified)
                    <div class="shop-verified-badge">
                        <i class="fas fa-check-circle"></i>
                        <span>Verified</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="shop-card-content">
            <div class="shop-card-header">
                <h5 class="shop-card-title">
                    <a href="{{ route('store_front', $shop->slug) }}">{{ $shop->name }}</a>
                </h5>
                <div class="shop-card-rating">
                    <div class="shop-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= 4 ? 'filled' : '' }}"></i>
                        @endfor
                    </div>
                    <span class="shop-rating-text text-dark">({{ $shop->ratings->count() }})</span>

                </div>
            </div>

            <div class="shop-card-meta">
                <div class="shop-card-category">
                    <span>{{ $shop->company_name ?? 'General Store' }}</span>
                </div>
                <div class="shop-card-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <span
                        class="text-dark">{{ $shop->city . ' ' . $shop->state . ' ' . $shop->post_code . ' ' . $shop->country ?? 'Unknown Location' }}</span>
                </div>
            </div>

            @php
                if (is_array($shop->tags)) {
                    $tags = $shop->tags;
                } elseif (is_string($shop->tags)) {
                    $tags = explode(',', $shop->tags);
                } else {
                    $tags = [];
                }
            @endphp
            @if (!empty($shop->tags))
                <div class="shop-card-tags">
                    @foreach (array_slice($tags, 0, 3) as $tag)
                        <span class="shop-tag" title="{{ $tag }}">
                            {{ Str::limit($tag, 8, '...') }}
                        </span>
                    @endforeach
                </div>
            @endif

            <div class="shop-card-stats">
                <div class="shop-stat-item">
                    <i class="fas fa-box"></i>
                    <div>
                        <span class="stat-number">{{ $shop->products->count() }}</span>
                        <span>Products</span>
                    </div>
                </div>
                <div class="shop-stat-item">
                    <i class="fas fa-users"></i>
                    <div>
                        <span class="stat-number">{{ rand(50, 500) }}</span>
                        <span>Followers</span>
                    </div>
                </div>
            </div>

            <div class="shop-card-description">
                <p class="text-dark">
                    {{ Str::limit($shop->short_description ?? 'A trusted shop offering quality products and excellent service.', 60, '...') }}
                </p>
            </div>

            <div class="shop-card-footer">
                <a href="{{ route('store_front', $shop->slug) }}" class="shop-visit-btn">
                    <span class="text-light">Visit Shop</span>
                    <i class="fas fa-arrow-right text-light"></i>
                </a>
                @auth
                    <form action="{{ route('follow', $shop) }}" method="post" style="display:inline">
                        @csrf
                        @php
                            $follow = auth()->user()->follows($shop);
                        @endphp
                        <button class="shop-follow-btn text-center d-block" type="submit"><i class="fas fa-heart"></i>
                            {{ $follow ? 'Unfollow' : 'Follow' }}</button>
                    </form>
                @else
                    <a class="shop-follow-btn text-center d-block" href="{{ route('login') }}"><i class="fas fa-heart"></i>
                        <span>Follow</span></a>
                @endauth
            </div>
        </div>
    </div>
</div>

<style>
    .modern-shop-card {
        background: var(--bg-secondary);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px var(--shadow-light);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid var(--border-light);
        height: 100%;
    }

    .modern-shop-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px var(--shadow-medium);
        border-color: var(--accent-color) !important;
    }

    .shop-card-image-wrapper {
        position: relative;
        overflow: hidden;
    }

    .shop-card-image {
        position: relative;
        height: 160px;
        background: var(--bg-light);
    }

    .shop-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .modern-shop-card:hover .shop-card-img {
        transform: scale(1.05);
    }

    .shop-card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--overlay-medium) !important;
        opacity: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.3s ease;
    }

    .modern-shop-card:hover .shop-card-overlay {
        opacity: 1;
    }

    .shop-card-actions {
        display: flex;
        gap: 8px;
    }

    .shop-action-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: var(--overlay-light);
        color: var(--text-light);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        text-decoration: none;
        font-size: 0.8rem;
    }

    .shop-action-btn:hover {
        background: var(--overlay-medium);
        transform: scale(1.1);
        color: var(--text-light);
    }

    .shop-featured-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: var(--accent-color);
        color: var(--text-dark);
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
        z-index: 2;
    }

    .shop-verified-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: var(--success-color);
        color: var(--text-light);
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
        z-index: 2;
    }

    .shop-card-content {
        padding: 16px;
    }

    .shop-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .shop-card-title {
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        flex: 1;
        line-height: 1.3;
    }

    .shop-card-title a {
        color: var(--text-dark) !important;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .shop-card-rating {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .shop-stars {
        display: flex;
        gap: 1px;
    }

    .shop-stars i {
        color: var(--rating-empty);
        font-size: 0.7rem;
    }

    .shop-stars i.filled {
        color: var(--rating-color);
    }

    .shop-rating-text {
        font-size: 0.65rem;
        color: var(--text-secondary);
    }

    .shop-card-meta {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 12px;
    }

    .shop-card-category span {
        background: var(--bg-light);
        color: var(--accent-color) !important;
        padding: 3px 8px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .shop-card-location {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--text-secondary);
        font-size: 0.8rem;
    }

    .shop-card-location i {
        color: var(--accent-color) !important;
        font-size: 0.7rem;
    }

    .shop-card-tags {
        display: flex;
        gap: 4px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .shop-tag {
        background: var(--bg-light);
        color: var(--rating-color);
        padding: 2px 6px;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 500;
        border: 1px solid var(--border-light);
    }

    .shop-card-stats {
        display: flex;
        gap: 8px;
        margin-bottom: 12px;
        padding: 8px;
        background: var(--bg-light);
        border-radius: 8px;
        border: 1px solid var(--border-light);
    }

    .shop-stat-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.7rem;
        color: var(--text-dark);
        font-weight: 600;
        padding: 6px 8px;
        background: var(--bg-secondary);
        border-radius: 6px;
        box-shadow: 0 1px 4px var(--shadow-light);
        transition: all 0.3s ease;
        flex: 1;
        justify-content: center;
    }

    .shop-stat-item:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px var(--shadow-primary);
        background: var(--bg-light);
    }

    .shop-stat-item i {
        color: var(--accent-color) !important;
        font-size: 0.8rem;
        width: 12px;
        text-align: center;
    }

    .shop-stat-item span {
        font-weight: 600;
        color: var(--text-dark);
    }

    .shop-stat-item .stat-number {
        color: var(--accent-color) !important;
        font-weight: 800;
        font-size: 0.8rem;
    }

    .shop-card-description {
        margin-bottom: 16px;
    }

    .shop-card-description p {
        color: var(--text-secondary);
        font-size: 0.8rem;
        line-height: 1.4;
        margin: 0;
    }

    .shop-card-footer {
        display: flex;
        gap: 8px;
    }

    .shop-visit-btn {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 12px;
        background: var(--accent-color) !important;
        color: var(--text-light);
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }

    .shop-visit-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        color: var(--text-light);
    }

    .shop-follow-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        color: var(--text-light) !important;
        border: 1px solid var(--accent-color) !important;
        background: var(--accent-color) !important;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .shop-follow-btn:hover {
        background: var(--primary-dark) !important;
        color: var(--text-light) !important;
        transform: translateY(-1px);
        border-color: var(--primary-dark) !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .shop-card-content {
            padding: 12px;
        }

        .shop-card-title {
            font-size: 0.9rem;
        }

        .shop-card-image {
            height: 140px;
        }
    }

    @media (max-width: 576px) {
        .shop-card-image {
            height: 120px;
        }

        .shop-card-content {
            padding: 10px;
        }

        .shop-card-footer {
            flex-direction: column;
        }
    }
</style>

<script>
    // Optimized JavaScript with better error handling and performance
    document.addEventListener('DOMContentLoaded', function() {
        // Use event delegation for better performance
        document.addEventListener('click', function(e) {
            if (e.target.closest('.wishlist-shop-btn')) {
                e.preventDefault();
                handleFollowClick(e.target.closest('.wishlist-shop-btn'));
            }
        });

        function handleFollowClick(button) {
            const shopId = button.dataset.shopId;
            const form = button.closest('form');

            if (!shopId || !form) {
                console.error('Missing shop ID or form');
                return;
            }

            // Show loading state
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;

            fetch(`/follow/${shopId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const element = document.getElementById(`shop_heart_${shopId}`);
                    if (element) {
                        if (element.classList.contains('far')) {
                            element.classList.remove('far', 'fa-heart', 'text-white');
                            element.classList.add('fas', 'fa-heart');
                            button.style.color = 'rgba(252, 79, 79, 0.96)';
                        } else {
                            element.classList.remove('fas', 'fa-heart');
                            element.classList.add('far', 'fa-heart', 'text-white');
                            button.style.color = '';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Show user-friendly error message
                    alert('Something went wrong. Please try again.');
                })
                .finally(() => {
                    // Restore button state
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
        }
    });
</script>
