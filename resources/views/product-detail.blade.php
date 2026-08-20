@extends('layouts.app')

@section('title', $product->name . ' — Anti')

@section('content')
<style>
    .product-page{padding:0 56px 60px;}
    .product-breadcrumb{display:flex;align-items:center;gap:9px;margin:28px 0 26px;color:var(--ink-soft);font-size:.72rem;letter-spacing:.04em;flex-wrap:wrap;}
    .product-breadcrumb a{color:inherit;text-decoration:none;}
    .product-breadcrumb a:hover{color:var(--ink);}
    .product-breadcrumb .current{color:var(--ink);}

    .product-layout{display:grid;grid-template-columns:1fr 1fr;gap:44px;align-items:start;}

    .product-gallery{display:flex;flex-direction:column;gap:14px;}
    .gallery-main{position:relative;min-height:560px;overflow:hidden;border-radius:var(--radius-md);background:var(--cream-2);}
    .gallery-main img{width:100%;height:100%;min-height:560px;display:block;object-fit:cover;transition:transform .7s var(--ease);}
    .gallery-main:hover img{transform:scale(1.025);}
    .gallery-badge{position:absolute;top:18px;left:18px;z-index:2;padding:8px 14px;border-radius:999px;background:rgba(36,29,22,.9);color:var(--cream);font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;}
    .thumbs{display:flex;gap:10px;overflow-x:auto;}
    .thumb{width:88px;height:108px;flex-shrink:0;padding:0;overflow:hidden;border:1px solid var(--line);border-radius:12px;background:var(--cream-2);cursor:pointer;transition:.25s var(--ease);}
    .thumb img{width:100%;height:100%;object-fit:cover;display:block;}
    .thumb.active{border:2px solid var(--ink);transform:translateY(-1px);}

    .product-info{position:sticky;top:24px;}
    .eyebrow{margin:0 0 8px;}
    .product-title{margin:0;font-size:clamp(1.9rem,3vw,2.8rem);font-weight:400;line-height:1.08;letter-spacing:-.02em;}
    .product-rating{display:flex;align-items:center;gap:12px;margin:16px 0 0;font-size:.76rem;}
    .stars{letter-spacing:2px;color:var(--gold);}
    .review-link{color:var(--ink-soft);text-decoration:underline;text-underline-offset:3px;}
    .price-row{display:flex;align-items:baseline;gap:12px;margin:18px 0 0;}
    .price{font-size:1.5rem;font-weight:600;letter-spacing:-.02em;}
    .old-price{color:#9a948b;text-decoration:line-through;font-size:.95rem;}
    .save{color:var(--brown);font-size:.66rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;}
    .product-description{margin:16px 0 0;max-width:480px;color:var(--ink-soft);font-size:.88rem;line-height:1.75;}
    .stock-info{margin-top:12px;display:flex;align-items:center;gap:8px;font-size:.78rem;}
    .stock-info .in-stock{color:#2d7a5a;font-weight:600;}
    .stock-info .out-stock{color:#a64d47;font-weight:600;}
    .stock-info .low-stock{color:#986723;font-weight:600;}
    .product-rule{height:1px;margin:20px 0;background:var(--line);}
    .option-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;font-size:.73rem;}
    .option-head strong{font-weight:700;}
    .size-guide{color:var(--ink-soft);text-decoration:underline;text-underline-offset:3px;cursor:pointer;}
    .sizes{display:grid;grid-template-columns:repeat(5,1fr);gap:8px;}
    .size-btn{height:44px;border:1px solid var(--line);border-radius:10px;background:transparent;cursor:pointer;color:var(--ink);font-size:.74rem;transition:.22s var(--ease);font-family:inherit;}
    .size-btn:hover,.size-btn.active{background:var(--ink);border-color:var(--ink);color:var(--cream);}
    .size-btn.disabled{color:#b8b1a8;background:var(--cream-2);text-decoration:line-through;cursor:not-allowed;}
    .color-row{display:flex;gap:9px;margin-top:14px;flex-wrap:wrap;}
    .color-btn{width:30px;height:30px;padding:3px;border:1px solid transparent;border-radius:50%;background:transparent;cursor:pointer;}
    .color-btn span{display:block;width:100%;height:100%;border-radius:50%;border:1px solid rgba(0,0,0,.12);}
    .color-btn.active{border-color:var(--ink);}
    .purchase-row{display:grid;grid-template-columns:112px 1fr;gap:10px;margin-top:18px;}
    .quantity{display:flex;align-items:center;justify-content:space-between;height:52px;padding:0 8px;border:1px solid var(--line);border-radius:999px;}
    .quantity button{width:30px;height:30px;border:0;border-radius:50%;background:transparent;cursor:pointer;font-size:1rem;color:var(--ink);}
    .quantity span{font-size:.8rem;font-weight:700;}
    .add-btn{height:52px;border:0;border-radius:999px;background:var(--ink);color:var(--cream);cursor:pointer;font-size:.72rem;font-weight:700;letter-spacing:.11em;text-transform:uppercase;transition:.3s var(--ease);}
    .add-btn:hover{background:var(--brown-deep);transform:translateY(-2px);}
    .buy-now{width:100%;height:48px;margin-top:8px;border:1px solid var(--ink);border-radius:999px;background:transparent;color:var(--ink);cursor:pointer;font-size:.69rem;font-weight:700;letter-spacing:.11em;text-transform:uppercase;transition:.3s var(--ease);}
    .buy-now:hover{background:var(--ink);color:var(--cream);}
    .shipping-info{margin-top:18px;padding:14px 16px;background:var(--cream-2);border-radius:12px;display:flex;align-items:center;gap:12px;font-size:.72rem;color:var(--ink-soft);}
    .shipping-info svg{width:18px;height:18px;flex-shrink:0;color:var(--gold);}
    .shipping-info strong{display:block;font-size:.78rem;color:var(--ink);}
    .shipping-info span{font-size:.68rem;color:var(--ink-soft);}
    .trust-row{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-top:14px;}
    .trust-item{padding:12px 8px;border:1px solid var(--line);border-radius:12px;text-align:center;transition:all .3s ease;cursor:default;}
    .trust-item:hover{border-color:var(--gold);background:var(--white);}
    .trust-item strong{display:block;font-size:.66rem;margin-bottom:3px;}
    .trust-item span{display:block;color:var(--ink-soft);font-size:.58rem;line-height:1.4;}
    .highlights-box{margin-top:18px;padding:16px 18px;border:1px solid var(--line);border-radius:12px;background:var(--white);}
    .highlights-box h4{font-size:.7rem;text-transform:uppercase;letter-spacing:.1em;color:var(--ink-soft);margin:0 0 10px;}
    .highlights-box ul{list-style:none;padding:0;margin:0;}
    .highlights-box li{display:flex;align-items:center;gap:10px;padding:6px 0;font-size:.72rem;color:var(--ink-soft);border-bottom:1px solid var(--line);}
    .highlights-box li:last-child{border-bottom:none;}
    .highlights-box li .icon{color:var(--gold);font-size:.8rem;}
    .share-box{margin-top:14px;padding:12px 0;border-top:1px solid var(--line);display:flex;justify-content:space-between;align-items:center;}
    .share-box .label{font-size:.65rem;color:var(--ink-soft);letter-spacing:.06em;}
    .share-box .share-buttons{display:flex;gap:8px;}
    .share-box .share-btn{width:32px;height:32px;border-radius:50%;border:1px solid var(--line);background:transparent;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:.7rem;transition:all .3s ease;font-family:inherit;}
    .share-box .share-btn:hover{border-color:var(--gold);background:var(--white);}
    .sku-box{margin-top:14px;padding-top:12px;border-top:1px solid var(--line);font-size:.6rem;color:var(--ink-soft);letter-spacing:.06em;display:flex;justify-content:space-between;}
    .accordions{margin-top:18px;border-top:1px solid var(--line);}
    .accordion{border-bottom:1px solid var(--line);}
    .accordion button{width:100%;display:flex;justify-content:space-between;align-items:center;padding:14px 0;border:0;background:transparent;color:var(--ink);cursor:pointer;text-align:left;font-size:.75rem;font-weight:700;font-family:inherit;}
    .accordion .plus{position:relative;width:15px;height:15px;}
    .accordion .plus:before,.accordion .plus:after{content:'';position:absolute;top:7px;left:0;width:15px;height:1px;background:currentColor;transition:.25s;}
    .accordion .plus:after{transform:rotate(90deg);}
    .accordion.open .plus:after{transform:rotate(0);}
    .accordion-content{max-height:0;overflow:hidden;color:var(--ink-soft);font-size:.78rem;line-height:1.75;transition:max-height .35s var(--ease);}
    .accordion.open .accordion-content{max-height:200px;padding-bottom:16px;}

    .premium-strip{margin-top:60px;padding:32px 36px;display:grid;grid-template-columns:1fr 1fr 1fr;gap:25px;border-radius:var(--radius-md);background:var(--ink);color:var(--cream);}
    .premium-strip div{display:flex;gap:14px;align-items:flex-start;}
    .premium-icon{flex:0 0 34px;width:34px;height:34px;display:grid;place-items:center;border:1px solid rgba(243,237,228,.2);border-radius:50%;color:var(--gold);font-size:.8rem;}
    .premium-strip strong{display:block;margin-bottom:4px;font-family:'Fraunces',serif;font-size:1rem;font-weight:400;}
    .premium-strip span{display:block;color:rgba(243,237,228,.55);font-size:.68rem;line-height:1.55;}

    .related{margin-top:60px;}
    .section-head{display:flex;align-items:end;justify-content:space-between;margin-bottom:20px;}
    .section-head h2{margin:0;font-size:1.8rem;font-weight:400;letter-spacing:-.02em;}
    .section-head a{color:var(--ink-soft);font-size:.7rem;text-decoration:none;}
    .related-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;}
    .related-card{text-decoration:none;color:var(--ink);}
    .related-thumb{aspect-ratio:4/5;overflow:hidden;border-radius:14px;background:var(--cream-2);}
    .related-thumb img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .55s var(--ease);}
    .related-card:hover img{transform:scale(1.035);}
    .related-card h3{margin:10px 0 3px;font-size:.95rem;font-weight:400;font-family:'Fraunces',serif;}
    .related-card p{margin:0;color:var(--ink-soft);font-size:.73rem;}

    @media (max-width:860px){
        .product-page{padding:0 24px 44px;}
        .product-layout{grid-template-columns:1fr;gap:26px;}
        .gallery-main,.gallery-main img{min-height:400px;}
        .thumb{width:70px;height:86px;}
        .product-title{font-size:2rem;}
        .sizes{grid-template-columns:repeat(4,1fr);}
        .purchase-row{grid-template-columns:96px 1fr;}
        .trust-row{grid-template-columns:1fr;}
        .premium-strip{padding:24px 20px;grid-template-columns:1fr;}
        .related-grid{gap:12px;grid-template-columns:repeat(2,1fr);}
        .product-info{position:static;}
    }
    @media (max-width:480px){
        .product-page{padding:0 16px 32px;}
        .gallery-main,.gallery-main img{min-height:320px;}
        .product-title{font-size:1.7rem;}
        .thumb{width:56px;height:70px;}
        .sizes{grid-template-columns:repeat(3,1fr);}
        .purchase-row{grid-template-columns:1fr;}
        .quantity{height:48px;}
        .add-btn{height:48px;}
        .price{font-size:1.2rem;}
        .section-head h2{font-size:1.4rem;}
        .related-grid{grid-template-columns:repeat(2,1fr);gap:10px;}
        .related-card h3{font-size:.8rem;}
    }
</style>

<div class="product-page">

    <div class="product-breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span>/</span>
        <a href="{{ route('shop') }}">Shop</a>
        <span>/</span>
        <span>{{ $product->category->name ?? 'Collection' }}</span>
        <span>/</span>
        <span class="current">{{ $product->name }}</span>
    </div>

    <div class="product-layout">

        <!-- GALLERY -->
        <div class="product-gallery">
            <div class="gallery-main">
                @if($product->is_featured)
                <div class="gallery-badge">Featured Collection</div>
                @endif
                @if($product->image)
                <img id="mainProductImage" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                <div class="ph-empty" style="font-size:28px;">◈</div>
                @endif
            </div>
            <div class="thumbs">
                @if($product->image)
                <button class="thumb active" type="button" data-image="{{ asset('storage/' . $product->image) }}">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </button>
                @endif
                @foreach($product->galleries as $gallery)
                <button class="thumb" type="button" data-image="{{ asset('storage/' . $gallery->image) }}">
                    <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $product->name }}">
                </button>
                @endforeach
                @if($product->galleries->count() < 2)
                <button class="thumb" type="button" data-image="{{ asset('storage/' . $product->image) }}">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </button>
                <button class="thumb" type="button" data-image="{{ asset('storage/' . $product->image) }}">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </button>
                @endif
            </div>
        </div>

        <!-- PRODUCT INFO -->
        <aside class="product-info">

            <p class="eyebrow">{{ $product->category->name ?? 'Premium Collection' }}</p>
            <h1 class="product-title">{{ $product->name }}</h1>

            <div class="product-rating">
                <span class="stars">★★★★★</span>
                <span>4.9</span>
                <a class="review-link" href="#">128 reviews</a>
            </div>

            <div class="price-row">
                <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @php $oldPrice = $product->price * 1.2; @endphp
                <span class="old-price">Rp {{ number_format($oldPrice, 0, ',', '.') }}</span>
                <span class="save">Save 20%</span>
            </div>

            <div class="stock-info">
                @if($product->stock > 10)
                    <span class="in-stock">● In Stock</span>
                    <span style="color:var(--ink-soft);font-size:.7rem;">{{ $product->stock }} units available</span>
                @elseif($product->stock > 0 && $product->stock <= 10)
                    <span class="low-stock">● Low Stock</span>
                    <span style="color:var(--ink-soft);font-size:.7rem;">Only {{ $product->stock }} left</span>
                @else
                    <span class="out-stock">● Out of Stock</span>
                @endif
            </div>

            <p class="product-description">{{ $product->description ?? 'A refined everyday essential designed around comfort, clean proportions, and effortless versatility.' }}</p>

            <div class="product-rule"></div>

            <div class="option-head">
                <strong>Size</strong>
                <span class="size-guide" onclick="showToast('Size guide: XS — XXL. Check your usual fit before ordering.')">Size Guide</span>
            </div>

            <div class="sizes">
                @php $sizes = ['XS', 'S', 'M', 'L', 'XL']; @endphp
                @foreach($sizes as $index => $size)
                <button class="size-btn {{ $index === 1 ? 'active' : '' }}" type="button">{{ $size }}</button>
                @endforeach
            </div>

            <div class="option-head" style="margin-top:18px;">
                <strong>Color</strong>
                <span style="font-size:.7rem;color:var(--ink-soft);">Noir</span>
            </div>

            <div class="color-row">
                <button class="color-btn active" type="button" aria-label="Noir"><span style="background:#1c1b19"></span></button>
                <button class="color-btn" type="button" aria-label="Stone"><span style="background:#c7b9a7"></span></button>
                <button class="color-btn" type="button" aria-label="Olive"><span style="background:#656957"></span></button>
                <button class="color-btn" type="button" aria-label="Sand"><span style="background:#ede7dc"></span></button>
                <button class="color-btn" type="button" aria-label="Navy"><span style="background:#252421"></span></button>
            </div>

            <div class="purchase-row">
                <div class="quantity">
                    <button type="button" onclick="changeQty(-1)">−</button>
                    <span id="qty">1</span>
                    <button type="button" onclick="changeQty(1)">+</button>
                </div>
                <button class="add-btn" type="button" onclick="addToCart()">
                    Add to Bag — Rp {{ number_format($product->price, 0, ',', '.') }}
                </button>
            </div>

            <button class="buy-now" type="button" onclick="showToast('Checkout flow ready!')">
                Buy It Now
            </button>

            <div class="shipping-info">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2l8 4v6c0 5-3.4 8.6-8 10-4.6-1.4-8-5-8-10V6z"/><path d="M9 12l2 2 4-4"/></svg>
                <div><strong>Free Shipping</strong><span>On orders over Rp 1.500.000</span></div>
            </div>

            <div class="trust-row">
                <div class="trust-item"><strong>Easy Returns</strong><span>30 days, unworn</span></div>
                <div class="trust-item"><strong>Secure Payment</strong><span>Protected checkout</span></div>
                <div class="trust-item"><strong>24/7 Support</strong><span>We're here to help</span></div>
            </div>

            <div class="highlights-box">
                <h4>Product Highlights</h4>
                <ul>
                    <li><span class="icon">✦</span> Premium quality material</li>
                    <li><span class="icon">✦</span> Relaxed fit silhouette</li>
                    <li><span class="icon">✦</span> Versatile everyday style</li>
                    <li><span class="icon">✦</span> Ethically made & sustainable</li>
                </ul>
            </div>

            <div class="share-box">
                <span class="label">Share this product</span>
                <div class="share-buttons">
                    <button class="share-btn" onclick="showToast('Share to Facebook')">f</button>
                    <button class="share-btn" onclick="showToast('Share to Twitter')">🐦</button>
                    <button class="share-btn" onclick="showToast('Share to Pinterest')">📌</button>
                    <button class="share-btn" onclick="showToast('Link copied to clipboard!')">🔗</button>
                </div>
            </div>

            <div class="sku-box">
                <span>SKU: #{{ $product->id }}{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</span>
                <span>Category: {{ $product->category->name ?? 'General' }}</span>
            </div>

            <div class="accordions">
                <div class="accordion open">
                    <button type="button">Product Details<span class="plus"></span></button>
                    <div class="accordion-content">
                        {{ $product->description ?? 'Designed for a polished silhouette without sacrificing movement.' }}
                        <br><br>
                        <strong>Features:</strong>
                        <ul style="margin-top:4px;padding-left:18px;color:var(--ink-soft);">
                            <li>Premium quality fabric</li>
                            <li>Relaxed fit silhouette</li>
                            <li>Versatile everyday style</li>
                        </ul>
                    </div>
                </div>
                <div class="accordion">
                    <button type="button">Materials & Care<span class="plus"></span></button>
                    <div class="accordion-content">Premium-feel fabric blend. Machine wash cold with similar colors, use a gentle cycle, and hang dry. Do not bleach. Iron on low heat if needed.</div>
                </div>
                <div class="accordion">
                    <button type="button">Shipping & Returns<span class="plus"></span></button>
                    <div class="accordion-content">Orders are carefully packed before dispatch. Unworn items can be returned within 30 days of delivery. Free shipping on orders over Rp 1.500.000.</div>
                </div>
                <div class="accordion">
                    <button type="button">Reviews<span class="plus"></span></button>
                    <div class="accordion-content">
                        <strong style="display:block;font-size:.9rem;color:var(--ink);">4.9 / 5</strong>
                        <span style="font-size:.7rem;color:var(--ink-soft);">Based on 128 reviews</span>
                        <div style="margin-top:8px;padding-top:8px;border-top:1px solid var(--line);">
                            <p style="font-size:.78rem;color:var(--ink-soft);margin:0;">"The fit feels premium and the packaging made the whole experience feel special."</p>
                            <p style="font-size:.65rem;color:var(--ink-soft);margin-top:4px;">— Verified Customer</p>
                        </div>
                    </div>
                </div>
            </div>

        </aside>
    </div>

    <!-- PREMIUM STRIP -->
    <section class="premium-strip">
        <div><span class="premium-icon">✦</span><div><strong>Made to Feel Premium</strong><span>Every detail is presented with a calm, considered shopping experience.</span></div></div>
        <div><span class="premium-icon">◇</span><div><strong>Thoughtful Packaging</strong><span>Your order arrives clean, protected, and ready to gift to yourself.</span></div></div>
        <div><span class="premium-icon">↗</span><div><strong>Dedicated Support</strong><span>Need help choosing a size or completing your order? We are here to help.</span></div></div>
    </section>

    <!-- RELATED PRODUCTS -->
    <section class="related">
        <div class="section-head">
            <h2>You May Also Like</h2>
            <a href="{{ route('shop') }}">Explore All →</a>
        </div>
        <div class="related-grid">
            @php
                $relatedProducts = \App\Models\Product::where('id', '!=', $product->id)
                    ->where('category_id', $product->category_id)
                    ->where('status', 'active')
                    ->take(4)
                    ->get();
            @endphp
            @forelse($relatedProducts as $related)
            <a class="related-card" href="{{ route('product.detail', $related->slug) }}">
                <div class="related-thumb">
                    @if($related->image)
                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}">
                    @else
                    <div class="ph-empty">◈</div>
                    @endif
                </div>
                <h3>{{ $related->name }}</h3>
                <p>Rp {{ number_format($related->price, 0, ',', '.') }}</p>
            </a>
            @empty
            @for($i = 0; $i < 4; $i++)
            <a class="related-card" href="{{ route('shop') }}">
                <div class="related-thumb ph-empty" style="font-size:24px;">◈</div>
                <h3>Explore More</h3>
                <p>View collection</p>
            </a>
            @endfor
            @endforelse
        </div>
    </section>
</div>

<script>
    document.querySelectorAll('.thumb').forEach(thumb => {
        thumb.addEventListener('click', function() {
            document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('mainProductImage').src = this.dataset.image;
        });
    });

    document.querySelectorAll('.size-btn:not(.disabled)').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    document.querySelectorAll('.color-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    document.querySelectorAll('.accordion button').forEach(button => {
        button.addEventListener('click', function() {
            const item = this.closest('.accordion');
            const wasOpen = item.classList.contains('open');
            document.querySelectorAll('.accordion').forEach(i => i.classList.remove('open'));
            if (!wasOpen) item.classList.add('open');
        });
    });

    function changeQty(delta) {
        const el = document.getElementById('qty');
        let value = parseInt(el.textContent, 10) + delta;
        value = Math.max(1, Math.min(10, value));
        el.textContent = value;
    }

    function addToCart() {
        const selectedSize = document.querySelector('.size-btn.active')?.textContent || 'S';
        const qty = document.getElementById('qty').textContent;
        showToast(`Added to bag · Size ${selectedSize} · Qty ${qty}`);
    }
</script>
@endsection

@section('sidebar')

<!-- BEST SELLERS (persis pola home) -->
<section class="reveal">
    <div class="side-head">
        <h2>Best Sellers</h2>
        <div class="arrow-nav">
            <button aria-label="Sebelumnya" onclick="scrollBestSellers(-1)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button aria-label="Selanjutnya" onclick="scrollBestSellers(1)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>
    </div>
    <div class="bs-grid" id="bestSellersTrack" style="overflow-x:auto;scroll-behavior:smooth;scrollbar-width:none;">
        @php
            $bestSellers = \App\Models\Product::where('is_featured', true)
                ->where('id', '!=', $product->id)
                ->take(6)
                ->get();
        @endphp
        @forelse($bestSellers as $item)
        <a class="bs-card" href="{{ route('product.detail', $item->slug) }}" style="text-decoration:none;color:inherit;">
            <div class="bs-thumb">
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" loading="lazy">
                @else
                    <div class="ph-empty">◈</div>
                @endif
            </div>
            <h4>{{ Str::limit($item->name, 20) }}</h4>
            <p>Rp {{ number_format($item->price, 0, ',', '.') }}</p>
        </a>
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:20px;color:var(--ink-soft);font-size:.75rem;">Belum ada best seller.</div>
        @endforelse
    </div>
</section>

<!-- DARK BANNER -->
<section class="reveal pt-0">
    <div class="banner-dark">
        <div class="banner-text">
            <h3>Complete The Look</h3>
            <p>Curated pairings picked to match what you're viewing right now.</p>
            <div class="play-row">
                <a href="{{ route('shop') }}" class="mini-btn">Shop The Edit</a>
                <button class="play-circle" aria-label="Putar video" onclick="showToast('Lookbook coming soon!')">
                    <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="6 4 20 12 6 20"/></svg>
                </button>
            </div>
        </div>
        <div class="banner-img">
            @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            @endif
        </div>
    </div>
</section>

<script>
    function scrollBestSellers(direction) {
        const track = document.getElementById('bestSellersTrack');
        if (!track) return;
        const card = track.querySelector('.bs-card');
        const width = card ? card.offsetWidth + 14 : 160;
        track.scrollBy({ left: direction * width, behavior: 'smooth' });
    }
</script>

@endsection
