@php
 
    $averageRating = Sohoj::average_rating($product->ratings);
    $ratingCount = $product->ratings->count();
    $currentPrice = $product->sale_price ?? $product->price;
    $originalPrice = $product->price;
    $hasDiscount = $product->sale_price && $product->sale_price < $product->price;
    $discountPercentage = $hasDiscount ? round((($originalPrice - $currentPrice) / $originalPrice) * 100) : 0;
    $fullStars = floor($averageRating);
    $hasHalfStar = $averageRating - $fullStars >= 0.5;
    
    $showMultipleCategories = $showMultipleCategories ?? true;
@endphp

<div class="col-md-3 col-sm-6 col-12 mb-4">
    <div class="product-card">
        {{-- Product Image Section --}}
        <div class="product-image-wrapper">
            <div class="product-image">
                <img src="{{ Storage::url($product->image) }}" 
                     alt="{{ $product->name }}" 
                     class="product-img" 
                     style="width: 100%; height: 100%; object-fit: cover;"
                     >

                {{-- Product Actions Overlay --}}
                <div class="product-overlay">
                    <div class="product-actions">
                        <a href="{{ route('product_details', $product->slug) }}" class="action-btn" title="Quick View"
                            aria-label="View {{ $product->name }} details">
                            <i class="fas fa-eye text-light"></i>
                        </a>

                        <form action="{{ route('cart.store') }}" method="post" class="cart-form">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button class="action-btn" title="Add to Cart" type="submit"
                                aria-label="Add {{ $product->name }} to cart">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </form>

                        @if (!in_array($product->id, session()->get('wishlist', [])))
                            <a href="{{ route('wishlist.add', ['productId' => $product->id]) }}"
                                class="action-btn compare-btn" title="Wishlist"
                                aria-label="Add {{ $product->name }} to wishlist"><i class="far fa-heart"></i></a>
                        @else
                            <a href="{{ route('wishlist.remove', ['productId' => $product->id]) }}"
                                class="action-btn compare-btn" title="Remove from Wishlist"
                                aria-label="Remove {{ $product->name }} from wishlist"><i class="fas fa-heart text-success"></i></a>
                        @endif
                    </div>
                </div>

                {{-- Discount Badge --}}
                @if ($hasDiscount)
                    <div class="discount-badge" aria-label="{{ $discountPercentage }}% discount">
                        <span>-{{ $discountPercentage }}%</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Product Content Section --}}
        <div class="product-content">
            {{-- Product Category --}}
            <div class="product-category">
                @if ($showMultipleCategories && $product->prodcats->count() > 0)
                    @foreach ($product->prodcats as $categoryName)
                        <span>{{ $categoryName->name }}</span>
                    @endforeach
                @else
                    <span>{{ $product->category->name ?? 'General' }}</span>
                @endif
            </div>

            {{-- Product Title --}}
            <h3 class="product-title">
                <a href="{{ route('product_details', $product->slug) }}"
                    aria-label="View {{ $product->name }} details">
                    {{ Str::limit($product->name, 35) }}
                </a>
            </h3>

            {{-- Product Rating --}}
            <div class="product-rating" aria-label="Rating: {{ $averageRating }} out of 5 stars">
                <div class="stars" role="img" aria-label="Rating: {{ $averageRating }} stars">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $fullStars)
                            <i class="fas fa-star filled" aria-hidden="true"></i>
                        @elseif($i == $fullStars + 1 && $hasHalfStar)
                            <i class="fas fa-star-half-alt filled" aria-hidden="true"></i>
                        @else
                            <i class="fas fa-star" aria-hidden="true"></i>
                        @endif
                    @endfor
                </div>
                <span class="rating-count">({{ $ratingCount }})</span>
            </div>

            {{-- Product Price --}}
            <div class="product-price">
                @if ($hasDiscount)
                    <span class="original-price" style="color: red !important; font-weight: 600; font-size: large;" aria-label="Original price">{{ Sohoj::price($originalPrice) }}</span>
                @endif
                <span class="current-price" aria-label="Current price">{{ Sohoj::price($currentPrice) }}</span>
            </div>

            {{-- Add to Cart Button --}}
            <form action="{{ route('cart.store') }}" method="POST" class="add-to-cart-form">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button class="add-to-cart-btn" type="submit" aria-label="Add {{ $product->name }} to cart">
                    <span class="spinner" style="display:none;margin-right:8px;"><i
                            class="fas fa-spinner fa-spin"></i></span>
                    <i class="fas fa-shopping-cart me-2" aria-hidden="true"></i>
                    <span class="btn-text">Add to Cart</span>
                </button>
            </form>

        </div>
    </div>
</div> 