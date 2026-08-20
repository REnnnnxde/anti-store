@extends('layouts.app')

@section('title', 'Lookbook — Anti')

@section('content')
<style>
    .lookbook-page {
        max-width: 1440px;
        margin: 0 auto;
        padding: 40px 48px 80px;
    }

    .lookbook-hero {
        position: relative;
        min-height: 70vh;
        border-radius: var(--radius-md);
        overflow: hidden;
        margin-bottom: 60px;
        background: var(--ink);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .lookbook-hero .hero-bg {
        position: absolute;
        inset: 0;
        opacity: 0.4;
        background-size: cover;
        background-position: center;
        background-image: url('https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=1600&q=80&dpr=1&auto=format');
    }
    .lookbook-hero .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        padding: 60px 40px;
        max-width: 700px;
    }
    .lookbook-hero .eyebrow {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .22em;
        text-transform: uppercase;
        color: var(--gold);
        font-family: 'Inter', sans-serif;
        margin: 0 0 16px;
    }
    .lookbook-hero h1 {
        font-family: 'Fraunces', Georgia, serif;
        font-size: clamp(48px, 8vw, 96px);
        font-weight: 300;
        line-height: 0.92;
        letter-spacing: -0.04em;
        color: var(--cream);
        margin: 0 0 20px;
    }
    .lookbook-hero h1 span {
        color: var(--gold);
        font-weight: 400;
    }
    .lookbook-hero p {
        color: rgba(255,255,255,0.6);
        font-size: 16px;
        line-height: 1.8;
        max-width: 500px;
        margin: 0 auto;
        font-weight: 300;
    }
    .lookbook-hero .scroll-indicator {
        margin-top: 40px;
        color: rgba(255,255,255,0.3);
        font-size: 11px;
        letter-spacing: .2em;
        text-transform: uppercase;
        animation: bounceDown 2s infinite;
    }
    @keyframes bounceDown {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(8px); }
    }

    .lookbook-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 0 20px;
        border-bottom: 1px solid var(--line);
        margin-bottom: 40px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .lookbook-nav .filters {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }
    .lookbook-nav .filter-btn {
        padding: 8px 20px;
        border: 1px solid var(--line);
        border-radius: 999px;
        background: transparent;
        font-size: 10px;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
        color: var(--ink-soft);
        cursor: pointer;
        transition: all .4s ease;
        letter-spacing: .04em;
    }
    .lookbook-nav .filter-btn:hover,
    .lookbook-nav .filter-btn.active {
        background: var(--ink);
        color: var(--cream);
        border-color: var(--ink);
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(30,24,20,.1);
    }
    .lookbook-nav .count {
        font-size: 11px;
        color: var(--ink-soft);
        letter-spacing: .04em;
    }
    .lookbook-nav .count strong {
        color: var(--ink);
        font-weight: 600;
    }

    .lookbook-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 60px;
    }

    .lookbook-item {
        position: relative;
        border-radius: var(--radius-md);
        overflow: hidden;
        background: var(--cream-2);
        cursor: pointer;
        transition: all .6s cubic-bezier(.22,1,.36,1);
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .lookbook-item:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 60px rgba(30,24,20,.12);
    }
    .lookbook-item:hover .item-image img {
        transform: scale(1.05);
    }
    .lookbook-item:hover .item-overlay {
        opacity: 1;
    }

    .lookbook-item .item-image {
        aspect-ratio: 3/4;
        overflow: hidden;
        background: var(--cream-2);
    }
    .lookbook-item .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .8s cubic-bezier(.22,1,.36,1);
    }

    .lookbook-item.tall .item-image {
        aspect-ratio: 3/5;
    }

    .lookbook-item.wide {
        grid-column: span 2;
    }
    .lookbook-item.wide .item-image {
        aspect-ratio: 16/10;
    }

    .lookbook-item .item-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, transparent 60%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 30px 28px;
        opacity: 0;
        transition: opacity .5s ease;
    }
    .lookbook-item .item-overlay .tag {
        font-size: 9px;
        font-weight: 700;
        letter-spacing: .15em;
        text-transform: uppercase;
        color: var(--gold);
        font-family: 'Inter', sans-serif;
        margin-bottom: 4px;
    }
    .lookbook-item .item-overlay h3 {
        font-family: 'Fraunces', Georgia, serif;
        font-size: 1.2rem;
        font-weight: 400;
        color: var(--cream);
        margin: 0 0 4px;
    }
    .lookbook-item .item-overlay p {
        font-size: .78rem;
        color: rgba(255,255,255,0.6);
        margin: 0;
    }

    .lookbook-item .featured-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        z-index: 2;
        background: var(--gold);
        color: var(--ink);
        font-size: 8px;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        padding: 4px 14px;
        border-radius: 999px;
        font-family: 'Inter', sans-serif;
    }

    .editorial-section {
        margin-bottom: 60px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: center;
        padding: 40px 0;
        border-top: 1px solid var(--line);
        border-bottom: 1px solid var(--line);
    }
    .editorial-section .editorial-content {
        padding-right: 20px;
    }
    .editorial-section .editorial-content .eyebrow {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .2em;
        text-transform: uppercase;
        color: var(--gold);
        font-family: 'Inter', sans-serif;
        margin: 0 0 12px;
    }
    .editorial-section .editorial-content h2 {
        font-family: 'Fraunces', Georgia, serif;
        font-size: clamp(1.8rem, 3vw, 2.8rem);
        font-weight: 400;
        letter-spacing: -0.03em;
        margin: 0 0 16px;
        color: var(--ink);
    }
    .editorial-section .editorial-content p {
        color: var(--ink-soft);
        font-size: .92rem;
        line-height: 1.9;
        margin: 0 0 20px;
    }
    .editorial-section .editorial-content .btn-outline {
        display: inline-block;
        padding: 12px 32px;
        border: 1px solid var(--ink);
        border-radius: 999px;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--ink);
        text-decoration: none;
        transition: all .3s ease;
    }
    .editorial-section .editorial-content .btn-outline:hover {
        background: var(--ink);
        color: var(--cream);
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(30,24,20,.12);
    }
    .editorial-section .editorial-image {
        border-radius: var(--radius-md);
        overflow: hidden;
        aspect-ratio: 4/3;
        background: var(--cream-2);
    }
    .editorial-section .editorial-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .lookbook-cta {
        text-align: center;
        padding: 50px 40px;
        background: var(--ink);
        border-radius: var(--radius-md);
        margin-top: 20px;
    }
    .lookbook-cta h2 {
        font-family: 'Fraunces', Georgia, serif;
        font-size: clamp(1.6rem, 2.5vw, 2.4rem);
        font-weight: 400;
        color: var(--cream);
        margin: 0 0 8px;
        letter-spacing: -0.02em;
    }
    .lookbook-cta h2 span {
        color: var(--gold);
    }
    .lookbook-cta p {
        color: rgba(255,255,255,0.5);
        font-size: .92rem;
        max-width: 500px;
        margin: 0 auto 24px;
        line-height: 1.7;
    }
    .lookbook-cta form {
        display: flex;
        max-width: 420px;
        margin: 0 auto;
        gap: 10px;
    }
    .lookbook-cta input {
        flex: 1;
        padding: 12px 18px;
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 999px;
        font-size: .85rem;
        font-family: inherit;
        background: rgba(255,255,255,0.08);
        color: var(--cream);
        outline: none;
        transition: border-color .3s ease;
    }
    .lookbook-cta input::placeholder {
        color: rgba(255,255,255,0.3);
    }
    .lookbook-cta input:focus {
        border-color: var(--gold);
    }
    .lookbook-cta button {
        padding: 12px 28px;
        border: 0;
        border-radius: 999px;
        background: var(--gold);
        color: var(--ink);
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        cursor: pointer;
        transition: all .3s ease;
        font-family: inherit;
        white-space: nowrap;
    }
    .lookbook-cta button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(199,154,91,.3);
    }

    .shuffle-btn {
        padding: 10px 24px;
        border: 1px solid var(--gold);
        border-radius: 999px;
        background: transparent;
        color: var(--gold);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        cursor: pointer;
        transition: all .3s ease;
        font-family: 'Inter', sans-serif;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .shuffle-btn:hover {
        background: var(--gold);
        color: var(--ink);
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(199,154,91,.2);
    }
    .shuffle-btn svg {
        width: 14px;
        height: 14px;
    }

    @media (max-width: 1200px) {
        .lookbook-grid { grid-template-columns: repeat(2, 1fr); }
        .lookbook-item.wide { grid-column: span 1; }
        .lookbook-item.wide .item-image { aspect-ratio: 3/4; }
        .lookbook-item.tall .item-image { aspect-ratio: 3/4; }
        .editorial-section { grid-template-columns: 1fr; gap: 30px; }
        .editorial-section .editorial-content { padding-right: 0; }
        .editorial-section .editorial-image { aspect-ratio: 16/9; }
    }

    @media (max-width: 1024px) {
        .lookbook-page { padding: 30px 32px 60px; }
        .lookbook-hero { min-height: 50vh; }
        .lookbook-hero h1 { font-size: clamp(36px, 6vw, 60px); }
    }

    @media (max-width: 768px) {
        .lookbook-page { padding: 20px 20px 44px; }
        .lookbook-hero { min-height: 40vh; border-radius: var(--radius-sm); margin-bottom: 40px; }
        .lookbook-hero .hero-content { padding: 40px 24px; }
        .lookbook-hero h1 { font-size: 2.4rem; }
        .lookbook-hero p { font-size: 14px; }
        .lookbook-nav { flex-direction: column; align-items: stretch; }
        .lookbook-nav .filters { justify-content: center; }
        .lookbook-grid { grid-template-columns: 1fr 1fr; gap: 14px; }
        .lookbook-item .item-overlay { opacity: 1; padding: 20px 18px; }
        .lookbook-item .item-overlay h3 { font-size: 1rem; }
        .editorial-section { padding: 30px 0; }
        .lookbook-cta { padding: 30px 20px; }
        .lookbook-cta form { flex-direction: column; gap: 8px; }
        .lookbook-cta input { text-align: center; }
        .lookbook-cta button { width: 100%; }
    }

    @media (max-width: 480px) {
        .lookbook-page { padding: 16px 14px 32px; }
        .lookbook-hero { min-height: 35vh; }
        .lookbook-hero h1 { font-size: 1.8rem; }
        .lookbook-hero .scroll-indicator { display: none; }
        .lookbook-grid { grid-template-columns: 1fr; gap: 16px; }
        .lookbook-nav .filters { gap: 4px; }
        .lookbook-nav .filter-btn { padding: 6px 12px; font-size: 9px; }
        .lookbook-item .item-overlay { padding: 16px 14px; }
        .lookbook-item .item-overlay h3 { font-size: .9rem; }
        .lookbook-item .featured-badge { top: 10px; left: 10px; font-size: 7px; padding: 3px 10px; }
        .shuffle-btn { padding: 8px 16px; font-size: 9px; }
    }
</style>

<div class="lookbook-page">

    <!-- HERO -->
    <div class="lookbook-hero">
        <div class="hero-bg"></div>
        <div class="hero-content">
            <p class="eyebrow">Anti Lookbook 2026</p>
            <h1>Where <span>Style</span> Meets <span>Substance.</span></h1>
            <p>Explore our latest collection — curated looks that define modern elegance.</p>
            <div class="scroll-indicator">Scroll to explore ↓</div>
        </div>
    </div>

    <!-- NAV -->
    <div class="lookbook-nav">
        <div class="filters">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="casual">Casual</button>
            <button class="filter-btn" data-filter="formal">Formal</button>
            <button class="filter-btn" data-filter="street">Street</button>
            <button class="filter-btn" data-filter="minimal">Minimal</button>
            <button class="filter-btn" data-filter="spring">Spring</button>
            <button class="filter-btn" data-filter="winter">Winter</button>
        </div>
        <div class="count" style="display:flex;align-items:center;gap:12px;">
            <strong id="lookCount">20</strong> looks
            <button class="shuffle-btn" onclick="shuffleLooks()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 16v4h-4"/>
                    <path d="M21 8V4h-4"/>
                    <path d="M21 4l-6 6"/>
                    <path d="M3 20l6-6"/>
                    <path d="M12 12l6-6"/>
                    <path d="M9 4H5v4"/>
                </svg>
                Shuffle
            </button>
        </div>
    </div>

    <!-- GRID - RENDER BY JAVASCRIPT -->
    <div class="lookbook-grid" id="lookbookGrid"></div>

    <!-- EDITORIAL -->
    <div class="editorial-section">
        <div class="editorial-content">
            <p class="eyebrow">Behind the Look</p>
            <h2>Every Piece <span style="color:var(--gold);">Tells a Story.</span></h2>
            <p>Our lookbook is more than just beautiful images — it's a narrative of craftsmanship, authenticity, and the art of dressing well. Each look is carefully curated to inspire your personal style journey.</p>
            <p>From the studio to the streets, every piece is designed with intention, quality, and timeless appeal.</p>
            <a href="{{ route('shop') }}" class="btn-outline">Shop the Collection →</a>
        </div>
        <div class="editorial-image">
            <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=800&q=80&dpr=1&auto=format" alt="Behind the Scenes" loading="lazy">
        </div>
    </div>

    <!-- CTA -->
    <div class="lookbook-cta">
        <h2>Get the <span>Look.</span></h2>
        <p>Subscribe to our newsletter and be the first to know about new drops, exclusive lookbooks, and style inspiration.</p>
        <form onsubmit="event.preventDefault(); alert('Subscribed!'); this.querySelector('input').value='';">
            <input type="email" placeholder="Enter your email" required>
            <button type="submit">Subscribe</button>
        </form>
    </div>

</div>

<script>
    // ============================================================
    // DATA LOOKBOOK - 20 LOOKS
    // ============================================================
    const lookbookData = [
        // Formal
        { id: 1, category: 'formal', title: 'The Essential Blazer', desc: 'Tailored perfection — the blazer that works everywhere.', img: 'https://images.unsplash.com/photo-1617137968427-85924c800a22?w=800&q=80&dpr=1&auto=format', type: 'wide', featured: true },
        { id: 2, category: 'formal', title: 'Evening Elegance', desc: 'Refined silhouettes for special occasions.', img: 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=800&q=80&dpr=1&auto=format', type: 'regular', featured: false },
        { id: 3, category: 'formal', title: 'Power Suit', desc: 'Command attention with bold, tailored elegance.', img: 'https://images.unsplash.com/photo-1580618672591-eb180b1a973f?w=800&q=80&dpr=1&auto=format', type: 'tall', featured: false },
        { id: 4, category: 'formal', title: 'Classic Tuxedo', desc: 'Timeless elegance for the most special occasions.', img: 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=800&q=80&dpr=1&auto=format', type: 'regular', featured: false },

        // Casual
        { id: 5, category: 'casual', title: 'Relaxed Weekend', desc: 'Effortless comfort for your days off.', img: 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=800&q=80&dpr=1&auto=format', type: 'regular', featured: false },
        { id: 6, category: 'casual', title: 'Cozy Layers', desc: 'Warm, comfortable, and effortlessly stylish.', img: 'https://images.unsplash.com/photo-1539533018447-63fcce2678e3?w=800&q=80&dpr=1&auto=format', type: 'wide', featured: false },
        { id: 7, category: 'casual', title: 'Weekend Escape', desc: 'Your go-to pieces for a getaway.', img: 'https://images.unsplash.com/photo-1529139574466-a303027c1d8b?w=800&q=80&dpr=1&auto=format', type: 'regular', featured: false },
        { id: 8, category: 'casual', title: 'Denim Days', desc: 'Classic denim reimagined for modern living.', img: 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80&dpr=1&auto=format', type: 'tall', featured: false },

        // Street
        { id: 9, category: 'street', title: 'Urban Edge', desc: 'Bold silhouettes for the city that never sleeps.', img: 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=800&q=80&dpr=1&auto=format', type: 'tall', featured: false },
        { id: 10, category: 'street', title: 'Street Culture', desc: 'Where art meets fashion — expressive and bold.', img: 'https://images.unsplash.com/photo-1562157873-818bc0726f68?w=800&q=80&dpr=1&auto=format', type: 'regular', featured: false },
        { id: 11, category: 'street', title: 'Street Flow', desc: 'Movement, rhythm, and urban energy.', img: 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=800&q=80&dpr=1&auto=format', type: 'regular', featured: false },
        { id: 12, category: 'street', title: 'Concrete Jungle', desc: 'Made for the streets that inspire us.', img: 'https://images.unsplash.com/photo-1523398002811-999ca8dec234?w=800&q=80&dpr=1&auto=format', type: 'wide', featured: false },

        // Minimal
        { id: 13, category: 'minimal', title: 'Pure Minimal', desc: 'Less is more — clean lines, timeless style.', img: 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=800&q=80&dpr=1&auto=format', type: 'regular', featured: false },
        { id: 14, category: 'minimal', title: 'Monochrome Study', desc: 'Black and white — classic, sophisticated, timeless.', img: 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=800&q=80&dpr=1&auto=format', type: 'regular', featured: false },
        { id: 15, category: 'minimal', title: 'Minimalist Dream', desc: 'Simplicity elevated — clean, crisp, and refined.', img: 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=800&q=80&dpr=1&auto=format', type: 'wide', featured: false },
        { id: 16, category: 'minimal', title: 'Quiet Luxury', desc: 'Understated elegance for the discerning eye.', img: 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=800&q=80&dpr=1&auto=format', type: 'tall', featured: false },

        // Spring
        { id: 17, category: 'spring', title: 'Spring Bloom', desc: 'Light, airy, and full of life — embrace the season.', img: 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?w=800&q=80&dpr=1&auto=format', type: 'regular', featured: false },
        { id: 18, category: 'spring', title: 'Garden Party', desc: 'Floral, fresh, and full of charm.', img: 'https://images.unsplash.com/photo-1487222477894-8943e31ef7b2?w=800&q=80&dpr=1&auto=format', type: 'regular', featured: false },

        // Winter - URL DIGANTI DENGAN YANG PASTI VALID
        { id: 19, category: 'winter', title: 'Winter Layers', desc: 'Stay warm without compromising on style.', img: 'https://images.unsplash.com/photo-1603283476050-d4f2b04d1f5f?w=800&q=80&dpr=1&auto=format', type: 'tall', featured: false },
        { id: 20, category: 'winter', title: 'Cozy Cabin', desc: 'Warm knits and comfort for the coldest days.', img: 'https://images.unsplash.com/photo-1558618666-fcd25c85f7f4?w=800&q=80&dpr=1&auto=format', type: 'regular', featured: false },
    ];

    // ============================================================
    // SHUFFLE FUNCTION
    // ============================================================
    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    // ============================================================
    // RENDER LOOKBOOK
    // ============================================================
    function renderLookbook(data) {
        const grid = document.getElementById('lookbookGrid');
        const countDisplay = document.getElementById('lookCount');

        countDisplay.textContent = data.length;

        let html = '';
        data.forEach(item => {
            const typeClass = item.type === 'wide' ? 'wide' : item.type === 'tall' ? 'tall' : '';
            const featuredBadge = item.featured ? '<div class="featured-badge">★ Featured</div>' : '';
            const tagLabel = item.category.charAt(0).toUpperCase() + item.category.slice(1);

            html += `
                <div class="lookbook-item ${typeClass}" data-category="${item.category}">
                    ${featuredBadge}
                    <div class="item-image">
                        <img src="${item.img}" alt="${item.title}" loading="lazy" onerror="this.style.display='none'">
                    </div>
                    <div class="item-overlay">
                        <span class="tag">${tagLabel}</span>
                        <h3>${item.title}</h3>
                        <p>${item.desc}</p>
                    </div>
                </div>
            `;
        });

        grid.innerHTML = html;

        setTimeout(() => {
            document.querySelectorAll('.lookbook-item').forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(30px)';
                item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                item.style.transitionDelay = (index * 0.04) + 's';

                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, 100 + (index * 40));
            });
        }, 50);
    }

    // ============================================================
    // SHUFFLE LOOKS
    // ============================================================
    let currentData = [...lookbookData];

    function shuffleLooks() {
        const shuffled = shuffleArray([...currentData]);
        currentData = shuffled;
        renderLookbook(currentData);

        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        document.querySelector('.filter-btn[data-filter="all"]').classList.add('active');
    }

    // ============================================================
    // FILTER LOOKBOOK
    // ============================================================
    function filterLooks(category) {
        let filtered;
        if (category === 'all') {
            filtered = [...lookbookData];
        } else {
            filtered = lookbookData.filter(item => item.category === category);
        }

        filtered = shuffleArray(filtered);
        currentData = filtered;
        renderLookbook(filtered);
    }

    // ============================================================
    // INITIALIZE
    // ============================================================
    document.addEventListener('DOMContentLoaded', function() {
        const shuffled = shuffleArray([...lookbookData]);
        currentData = shuffled;
        renderLookbook(shuffled);

        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const filter = this.dataset.filter;
                filterLooks(filter);
            });
        });
    });

    // ============================================================
    // SCROLL REVEAL
    // ============================================================
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        setTimeout(() => {
            document.querySelectorAll('.lookbook-item').forEach(item => {
                observer.observe(item);
            });
        }, 500);
    });

    function showToast(message) {
        const toast = document.getElementById('toast');
        if (toast) {
            toast.textContent = message;
            toast.classList.add('show');
            clearTimeout(window.toastTimer);
            window.toastTimer = setTimeout(() => toast.classList.remove('show'), 2800);
        }
    }
</script>
@endsection
