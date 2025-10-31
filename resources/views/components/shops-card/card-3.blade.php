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
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0, 0, 0, 0.05);
        height: 100%;
    }

    .modern-shop-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        border-color: #FF0000 !important;
    }

    .shop-card-image-wrapper {
        position: relative;
        overflow: hidden;
    }

    .shop-card-image {
        position: relative;
        height: 160px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
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
        background: #c1bebe91 !important;
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
        background: rgba(255, 255, 255, 0.2);
        color: white;
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
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
        color: white;
    }

    .shop-featured-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: linear-gradient(135deg, #ffd700, #ffed4e);
        color: #2c3e50;
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
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
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
        color: #2c3e50 !important;
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
        color: #ddd;
        font-size: 0.7rem;
    }

    .shop-stars i.filled {
        color: #ffc107;
    }

    .shop-rating-text {
        font-size: 0.65rem;
        color: #6c757d;
    }

    .shop-card-meta {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 12px;
    }

    .shop-card-category span {
        background: linear-gradient(135deg, #e8f5e8, #d4edda);
        color: #01949a !important;
        padding: 3px 8px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .shop-card-location {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #6c757d;
        font-size: 0.8rem;
    }

    .shop-card-location i {
        color: #01949a !important;
        font-size: 0.7rem;
    }

    .shop-card-tags {
        display: flex;
        gap: 4px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .shop-tag {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        color: #6c757d;
        padding: 2px 6px;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 500;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .shop-card-stats {
        display: flex;
        gap: 8px;
        margin-bottom: 12px;
        padding: 8px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 8px;
        border: 1px solid rgba(59, 183, 126, 0.1);
    }

    .shop-stat-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.7rem;
        color: #2c3e50;
        font-weight: 600;
        padding: 6px 8px;
        background: white;
        border-radius: 6px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        flex: 1;
        justify-content: center;
    }

    .shop-stat-item:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(59, 183, 126, 0.15);
        background: linear-gradient(135deg, #e8f5e8, #d4edda);
    }

    .shop-stat-item i {
        color: #01949a !important;
        font-size: 0.8rem;
        width: 12px;
        text-align: center;
    }

    .shop-stat-item span {
        font-weight: 600;
        color: #2c3e50;
    }

    .shop-stat-item .stat-number {
        color: #01949a !important;
        font-weight: 800;
        font-size: 0.8rem;
    }

    .shop-card-description {
        margin-bottom: 16px;
    }

    .shop-card-description p {
        color: #6c757d;
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
        background: #FF0000 !important;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }

    .shop-visit-btn:hover {
        background: linear-gradient(135deg, #2d9d6b, #1a7a4a);
        transform: translateY(-1px);
        color: white;
    }

    .shop-follow-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        color: #ffffff !important;
        border: 1px solid #01949a !important;
        background: #01949a !important;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .shop-follow-btn:hover {
        background: #01949a !important;
        color: white !important;
        transform: translateY(-1px);
        border-color: #01949a !important;
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
