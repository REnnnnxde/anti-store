@extends('layouts.app')

@section('title', 'Shop — Anti')

@section('content')
<style>
    .shop-page {
        max-width: 1440px;
        margin: 0 auto;
        padding: 0 48px 80px;
    }

    .shop-hero {
        padding: 60px 0 44px;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 40px;
        border-bottom: 1px solid var(--line);
        margin-bottom: 28px;
    }
    .shop-hero .left .eyebrow {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .22em;
        text-transform: uppercase;
        color: var(--gold);
        margin: 0 0 14px;
        font-family: 'Inter', sans-serif;
    }
    .shop-hero .left h1 {
        font-size: clamp(40px, 5.5vw, 68px);
        font-weight: 300;
        line-height: 0.88;
        letter-spacing: -0.045em;
        font-family: 'Fraunces', Georgia, serif;
        margin: 0;
        color: var(--ink);
    }
    .shop-hero .left h1 span {
        color: var(--gold);
        font-weight: 400;
    }
    .shop-hero p {
        max-width: 440px;
        color: var(--ink-soft);
        font-size: 13px;
        line-height: 1.8;
        margin: 0;
        font-weight: 400;
        letter-spacing: 0.01em;
    }

    .shop-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 0 18px;
        border-bottom: 1px solid var(--line);
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .shop-filters {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    .shop-filter-btn {
        border: 1px solid var(--line);
        background: transparent;
        border-radius: 100px;
        padding: 8px 18px;
        font-size: 10px;
        font-weight: 500;
        cursor: pointer;
        transition: all .4s ease;
        font-family: 'Inter', sans-serif;
        color: var(--ink-soft);
        letter-spacing: .02em;
    }
    .shop-filter-btn.active,
    .shop-filter-btn:hover {
        background: var(--ink);
        color: var(--cream);
        border-color: var(--ink);
        box-shadow: 0 4px 16px rgba(30,24,20,.1);
        transform: translateY(-1px);
    }
    .shop-tools {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }
    .shop-count {
        font-size: 11px;
        color: var(--muted);
        font-weight: 400;
        letter-spacing: .02em;
    }
    .shop-count strong {
        color: var(--ink);
        font-weight: 600;
    }
    .shop-sort {
        border: 1px solid var(--line);
        background: transparent;
        border-radius: 100px;
        padding: 8px 28px 8px 14px;
        font-size: 10px;
        color: var(--ink);
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234a4038' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 12px;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: border-color .3s ease, box-shadow .3s ease;
        background-color: var(--white);
        font-weight: 500;
    }
    .shop-sort:hover {
        border-color: var(--gold);
    }
    .shop-sort:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(199,154,91,.15);
    }

    .shop-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px 20px;
    }

    .shop-card {
        min-width: 0;
        transition: all .5s cubic-bezier(.22,1,.36,1);
        cursor: pointer;
    }
    .shop-card a {
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .shop-card .image {
        position: relative;
        aspect-ratio: 4/5;
        overflow: hidden;
        border-radius: 14px;
        background: #e6dfd5;
        transition: all .5s cubic-bezier(.22,1,.36,1);
    }
    .shop-card:hover .image {
        box-shadow: 0 20px 60px -16px rgba(30,24,20,.12);
    }
    .shop-card .image img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transition: transform .8s cubic-bezier(.22,1,.36,1);
    }
    .shop-card:hover .image img {
        transform: scale(1.045);
    }

    .shop-card .badge {
        position: absolute;
        left: 12px;
        top: 12px;
        background: var(--ink);
        color: var(--cream);
        font-size: 8px;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        padding: 5px 12px;
        border-radius: 100px;
        z-index: 2;
        font-family: 'Inter', sans-serif;
    }
    .shop-card .badge.featured {
        background: var(--gold);
        box-shadow: 0 4px 16px rgba(199,154,91,.25);
    }
    .shop-card .badge.sold {
        background: #a64d47;
    }
    .shop-card .badge.low {
        background: #986723;
    }

    .shop-card .heart {
        position: absolute;
        right: 12px;
        top: 12px;
        width: 34px;
        height: 34px;
        border: 0;
        border-radius: 50%;
        background: rgba(255,255,255,.92);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        cursor: pointer;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .3s ease;
        z-index: 2;
        color: var(--ink-soft);
        box-shadow: 0 2px 12px rgba(30,24,20,.04);
    }
    .shop-card .heart:hover {
        background: #fff;
        transform: scale(1.08);
        color: #c0392b;
        box-shadow: 0 4px 20px rgba(30,24,20,.1);
    }

    .shop-card .info {
        padding: 14px 4px 4px;
    }
    .shop-card .meta {
        font-size: 9px;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 5px;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
    }
    .shop-card .name {
        font-size: 16px;
        font-weight: 400;
        font-family: 'Fraunces', Georgia, serif;
        margin: 0 0 5px;
        line-height: 1.3;
        color: var(--ink);
        transition: color .3s ease;
    }
    .shop-card:hover .name {
        color: var(--brown-deep);
    }
    .shop-card .bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .shop-card .price {
        font-size: 13px;
        font-weight: 600;
        color: var(--ink);
        font-family: 'Inter', sans-serif;
    }

    .shop-pagination {
        display: flex;
        justify-content: center;
        gap: 6px;
        margin-top: 48px;
    }
    .shop-pagination .pg {
        width: 38px;
        height: 38px;
        border: 1px solid var(--line);
        border-radius: 50%;
        background: transparent;
        cursor: pointer;
        font-size: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .3s ease;
        font-family: 'Inter', sans-serif;
        color: var(--ink);
        font-weight: 500;
    }
    .shop-pagination .pg.active,
    .shop-pagination .pg:hover {
        background: var(--ink);
        color: var(--cream);
        border-color: var(--ink);
        box-shadow: 0 4px 16px rgba(30,24,20,.08);
        transform: translateY(-1px);
    }

    .shop-empty {
        grid-column: 1/-1;
        padding: 80px 20px;
        text-align: center;
        color: var(--muted);
        background: var(--white);
        border-radius: var(--radius-md);
        border: 1px solid var(--line);
    }
    .shop-empty strong {
        display: block;
        color: var(--ink);
        font-size: 24px;
        font-weight: 400;
        font-family: 'Fraunces', Georgia, serif;
        margin-bottom: 8px;
    }
    .shop-empty p {
        font-size: 13px;
    }

    @media (max-width: 1024px) {
        .shop-page { padding: 0 32px 60px; }
        .shop-grid { grid-template-columns: repeat(2, 1fr); gap: 20px 14px; }
        .shop-hero .left h1 { font-size: 3rem; }
        .shop-hero p { max-width: 340px; font-size: 12px; }
    }

    @media (max-width: 768px) {
        .shop-page { padding: 0 20px 44px; }
        .shop-hero { display: block; padding: 40px 0 28px; }
        .shop-hero p { margin-top: 16px; max-width: 100%; }
        .shop-toolbar { flex-direction: column; align-items: stretch; gap: 12px; }
        .shop-tools { justify-content: space-between; }
        .shop-grid { gap: 16px 10px; }
        .shop-card .image { aspect-ratio: 3/4; border-radius: 12px; }
        .shop-card .name { font-size: 14px; }
        .shop-card .price { font-size: 12px; }
        .shop-filters { gap: 4px; }
        .shop-filter-btn { padding: 6px 12px; font-size: 9px; }
        .shop-card .badge { font-size: 7px; padding: 4px 8px; left: 8px; top: 8px; }
        .shop-card .heart { width: 28px; height: 28px; font-size: 13px; right: 8px; top: 8px; }
    }

    @media (max-width: 480px) {
        .shop-page { padding: 0 14px 36px; }
        .shop-grid { grid-template-columns: repeat(2, 1fr); gap: 12px 8px; }
        .shop-card .image { border-radius: 10px; }
        .shop-card .info { padding: 10px 2px 2px; }
        .shop-card .name { font-size: 12px; }
        .shop-card .meta { font-size: 8px; }
        .shop-card .price { font-size: 11px; }
        .shop-hero .left h1 { font-size: 2rem; }
        .shop-hero p { font-size: 11px; }
        .shop-filter-btn { padding: 5px 8px; font-size: 8px; }
        .shop-toolbar { padding: 12px 0 14px; }
        .shop-pagination .pg { width: 32px; height: 32px; font-size: 10px; }
    }
</style>

<div class="shop-page">

    <!-- HERO -->
    <div class="shop-hero reveal">
        <div class="left">
            <p class="eyebrow">The Anti Collection</p>
            <h1>Shop <span>Everything.</span></h1>
        </div>
        <p>Curated essentials designed for modern everyday living. Refined silhouettes, considered details, and effortless comfort.</p>
    </div>

    <!-- TOOLBAR -->
    <div class="shop-toolbar reveal">
        <div class="shop-filters">
            <button class="shop-filter-btn active" data-cat="all">All</button>
            @foreach($categories as $cat)
            <button class="shop-filter-btn" data-cat="{{ $cat->id }}">{{ $cat->name }}</button>
            @endforeach
        </div>
        <div class="shop-tools">
            <span class="shop-count"><strong>{{ $products->count() }}</strong> products</span>
            <select class="shop-sort" id="sort">
                <option value="featured">Sort: Featured</option>
                <option value="low">Price: Low to High</option>
                <option value="high">Price: High to Low</option>
                <option value="az">Name: A–Z</option>
            </select>
        </div>
    </div>

    <!-- PRODUCT GRID -->
    <div class="shop-grid reveal-stagger">
        @forelse($products as $product)
        <div class="shop-card" data-category="{{ $product->category_id }}" data-price="{{ $product->price }}" data-name="{{ $product->name }}" data-stock="{{ $product->stock }}">
            <a href="{{ route('product.detail', $product->slug) }}">
                <div class="image">
                    @if($product->image && file_exists(storage_path('app/public/' . $product->image)))
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" loading="lazy">
                    @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#e7e1d9;color:#b3aa9e;font-size:24px;">◈</div>
                    @endif
                    @if($product->is_featured)
                        <span class="badge featured">★ Featured</span>
                    @endif
                    @if($product->stock == 0)
                        <span class="badge sold">Sold Out</span>
                    @elseif($product->stock <= 5)
                        <span class="badge low">Low Stock</span>
                    @endif
                    <button class="heart" onclick="event.preventDefault();this.textContent=this.textContent==='♡'?'♥':'♡'">♡</button>
                </div>
                <div class="info">
                    <div class="meta">{{ $product->category->name ?? 'Uncategorized' }}</div>
                    <h3 class="name">{{ $product->name }}</h3>
                    <div class="bottom">
                        <div class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="shop-empty">
            <strong>No pieces found.</strong>
            <p>Try adjusting your filters.</p>
        </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    @if($products->hasPages())
    <div class="shop-pagination">
        {{ $products->withQueryString()->links() }}
    </div>
    @endif

</div>

<script>
    // ============================================================
    // FILTER - DATA ASLI
    // ============================================================
    document.addEventListener('DOMContentLoaded', function() {
        const grid = document.getElementById('grid');
        const empty = document.getElementById('empty');
        const count = document.getElementById('count');
        let activeCat = "all";

        function render() {
            let cards = document.querySelectorAll('.shop-card');
            let visibleCount = 0;

            const sort = document.getElementById("sort").value;

            cards.forEach(card => {
                const catId = card.dataset.category;

                let show = true;

                if (activeCat !== "all") {
                    if (parseInt(activeCat) > 0) {
                        show = parseInt(catId) === parseInt(activeCat);
                    }
                }

                card.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });

            count.textContent = visibleCount;
            empty.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        // Events
        document.querySelectorAll(".shop-filter-btn").forEach(btn => {
            btn.onclick = function() {
                document.querySelectorAll(".shop-filter-btn").forEach(x => x.classList.remove("active"));
                this.classList.add("active");
                activeCat = this.dataset.cat;
                render();
            };
        });

        document.getElementById("sort").onchange = render;

        // Initial render
        render();

        // Scroll reveal
        const reveals = document.querySelectorAll('.reveal, .reveal-stagger');
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            reveals.forEach(el => observer.observe(el));
        } else {
            reveals.forEach(el => el.classList.add('in'));
        }
    });
</script>
@endsection

@section('sidebar')

<!-- ============================================================
SIDEBAR - KANAN
============================================================ -->

<!-- BEST SELLERS -->
<section class="reveal" style="padding:44px 32px 24px;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
        <h2 style="font-size:1.2rem;font-weight:500;font-family:'Fraunces',serif;">Best Sellers</h2>
        <a href="{{ route('shop') }}" style="font-size:.65rem;color:var(--brown);font-weight:600;text-decoration:none;letter-spacing:.06em;text-transform:uppercase;">View All →</a>
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        @php
            $bestSellers = \App\Models\Product::where('is_featured', true)->take(4)->get();
        @endphp
        @forelse($bestSellers as $product)
        <a href="{{ route('product.detail', $product->slug) }}" style="cursor:pointer;text-decoration:none;color:inherit;display:block;">
            <div style="border-radius:10px;overflow:hidden;aspect-ratio:1/1;margin-bottom:6px;position:relative;background:#f0edea;">
                @if($product->image && file_exists(storage_path('app/public/' . $product->image)))
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;transition:transform .6s ease;">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#d4c9be;font-size:28px;">◈</div>
                @endif
                <div style="position:absolute;bottom:6px;right:6px;background:rgba(255,255,255,0.92);backdrop-filter:blur(4px);padding:2px 10px;border-radius:20px;font-size:7px;font-weight:700;color:var(--brown);">★ Best</div>
            </div>
            <h4 style="font-size:.72rem;font-weight:500;line-height:1.3;margin:0;">{{ $product->name }}</h4>
            <p style="font-size:.72rem;color:var(--brown);font-weight:600;margin-top:1px;">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        </a>
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:20px;color:var(--muted);font-size:.8rem;">Belum ada best seller.</div>
        @endforelse
    </div>
</section>

<!-- NEWSLETTER MINI -->
<section style="padding:0 32px 20px;" class="reveal">
    <div style="background:var(--white);border-radius:var(--radius-md);padding:20px 18px;border:1px solid var(--line);">
        <h3 style="font-size:1rem;font-weight:500;font-family:'Fraunces',serif;margin:0 0 4px;">Stay in Style</h3>
        <p style="font-size:.72rem;color:var(--ink-soft);margin:0 0 12px;line-height:1.5;">Get 10% off your first order.</p>
        <form onsubmit="event.preventDefault(); showToast('Subscribed!'); this.querySelector('input').value='';" style="display:flex;gap:6px;">
            <input type="email" placeholder="Email" required style="flex:1;padding:7px 12px;border:1px solid var(--line);border-radius:100px;font-size:.7rem;outline:none;font-family:inherit;background:var(--cream);transition:border-color .3s ease;" onfocus="this.style.borderColor='var(--brown)'" onblur="this.style.borderColor='var(--line)'">
            <button type="submit" style="padding:7px 14px;border:0;border-radius:100px;background:var(--ink);color:var(--cream);font-size:.6rem;font-weight:600;white-space:nowrap;cursor:pointer;transition:all .3s ease;" onmouseenter="this.style.background='var(--brown-deep)'" onmouseleave="this.style.background='var(--ink)'">Subscribe</button>
        </form>
    </div>
</section>

<!-- QUOTE -->
<section style="padding:0 32px 20px;" class="reveal">
    <div style="background:var(--cream-2);border-radius:var(--radius-md);padding:20px 18px;border:1px solid var(--line);">
        <svg viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;color:var(--gold);margin-bottom:6px;opacity:0.6;"><path d="M9 7C6 7 4 9.5 4 12.5S6 18 9 18v-3c-1.5 0-2.5-1-2.5-2.5S7.5 10 9 10z"/><path d="M18 7c-3 0-5 2.5-5 5.5S15 18 18 18v-3c-1.5 0-2.5-1-2.5-2.5S16.5 10 18 10z"/></svg>
        <p style="font-size:.78rem;line-height:1.6;color:var(--ink-soft);margin:0 0 6px;font-style:italic;">"Anti has completely transformed my wardrobe. The quality and style are unmatched."</p>
        <p style="font-size:.68rem;font-weight:600;color:var(--ink);margin:0;">— Jessica M.</p>
    </div>
</section>

<!-- CATEGORY QUICK LINKS -->
<section style="padding:0 32px 20px;" class="reveal">
    <div style="background:var(--white);border-radius:var(--radius-md);padding:16px 18px;border:1px solid var(--line);">
        <h3 style="font-size:.8rem;font-weight:600;margin:0 0 10px;font-family:'Fraunces',serif;">Shop by Category</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:5px;">
            @foreach(\App\Models\Category::all()->take(4) as $cat)
            <a href="{{ route('shop', ['category' => $cat->id]) }}" style="padding:5px 8px;border-radius:100px;background:var(--cream);font-size:.65rem;font-weight:500;color:var(--ink-soft);text-align:center;text-decoration:none;transition:all .3s ease;" onmouseenter="this.style.background='var(--line)';this.style.color='var(--ink)'" onmouseleave="this.style.background='var(--cream)';this.style.color='var(--ink-soft)'">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- SOCIAL MEDIA -->
<section style="padding:0 32px 20px;" class="reveal">
    <div style="background:var(--ink);border-radius:var(--radius-md);padding:18px 20px;color:var(--cream);text-align:center;">
        <p style="font-size:.65rem;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,0.5);margin:0 0 6px;">Follow Us</p>
        <div style="display:flex;justify-content:center;gap:10px;">
            <a href="#" style="width:32px;height:32px;border-radius:50%;border:1px solid rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;transition:all .3s ease;color:rgba(255,255,255,0.5);" onmouseenter="this.style.background='var(--gold)';this.style.borderColor='var(--gold)';this.style.color='var(--ink)'" onmouseleave="this.style.background='transparent';this.style.borderColor='rgba(255,255,255,0.15)';this.style.color='rgba(255,255,255,0.5)'">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" style="width:12px;height:12px;"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>
            </a>
            <a href="#" style="width:32px;height:32px;border-radius:50%;border:1px solid rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;transition:all .3s ease;color:rgba(255,255,255,0.5);" onmouseenter="this.style.background='var(--gold)';this.style.borderColor='var(--gold)';this.style.color='var(--ink)'" onmouseleave="this.style.background='transparent';this.style.borderColor='rgba(255,255,255,0.15)';this.style.color='rgba(255,255,255,0.5)'">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" style="width:12px;height:12px;"><path d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.5-1.3 1.8-2.3-.8.5-1.7.8-2.6 1a4 4 0 00-6.9 3.6A11.5 11.5 0 013 4.6a4 4 0 001.3 5.4c-.6 0-1.2-.2-1.7-.5v.1a4 4 0 003.2 4 4 4 0 01-1.8.1 4 4 0 003.8 2.8A8.1 8.1 0 012 18.4a11.5 11.5 0 006.3 1.9c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.2z"/></svg>
            </a>
            <a href="#" style="width:32px;height:32px;border-radius:50%;border:1px solid rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;transition:all .3s ease;color:rgba(255,255,255,0.5);" onmouseenter="this.style.background='var(--gold)';this.style.borderColor='var(--gold)';this.style.color='var(--ink)'" onmouseleave="this.style.background='transparent';this.style.borderColor='rgba(255,255,255,0.15)';this.style.color='rgba(255,255,255,0.5)'">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" style="width:12px;height:12px;"><path d="M15 3h-2a5 5 0 00-5 5v2H6v4h2v7h4v-7h3l1-4h-4V8a1 1 0 011-1h3z"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- SHIPPING INFO -->
<section style="padding:0 32px 20px;" class="reveal">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
        <div style="background:var(--white);border-radius:var(--radius-sm);padding:12px 10px;border:1px solid var(--line);text-align:center;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" style="width:16px;height:16px;color:var(--gold);margin-bottom:4px;display:block;margin-left:auto;margin-right:auto;"><path d="M3 4h2l2.4 12.2a2 2 0 0 0 2 1.6h7.6a2 2 0 0 0 2-1.6L21 8H6"/><circle cx="9.5" cy="20" r="1.4"/><circle cx="17" cy="20" r="1.4"/></svg>
            <div style="font-size:.6rem;font-weight:600;">Free Shipping</div>
            <div style="font-size:.5rem;color:var(--ink-soft);">On orders $100+</div>
        </div>
        <div style="background:var(--white);border-radius:var(--radius-sm);padding:12px 10px;border:1px solid var(--line);text-align:center;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" style="width:16px;height:16px;color:var(--gold);margin-bottom:4px;display:block;margin-left:auto;margin-right:auto;"><path d="M12 2l8 4v6c0 5-3.4 8.6-8 10-4.6-1.4-8-5-8-10V6z"/><path d="M9 12l2 2 4-4"/></svg>
            <div style="font-size:.6rem;font-weight:600;">Secure Payment</div>
            <div style="font-size:.5rem;color:var(--ink-soft);">100% protected</div>
        </div>
    </div>
</section>

@endsection
