@extends('layouts.app')

@section('title', 'Anti — Everyday Comfort With Stylish Versatility')

@section('content')

<!-- HERO -->
<div class="hero">
    <img src="https://images.unsplash.com/photo-1634921276069-c24ba5d6b35c?auto=format&fit=crop&w=1400&q=80"
         alt="Fashion style">
    <div class="hero-content">
        <h1>Everyday Comfort<br>With Stylish Versatility</h1>
        <p>Look designs for business and special occasions. Relaxed style with breathable comfort.</p>
        <a href="{{ route('shop') }}" class="btn">
            Shop Now
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
    </div>
</div>

<!-- WHY CHOOSE US -->
<section id="why" class="why reveal">
    <div class="why-text">
        <p class="eyebrow">Why Choose Us?</p>
        <h2>Crafted for Comfort.<br>Designed for You.</h2>
        <p>Our platform allows you to set up intelligent workflows that handle repetitive, time-consuming tasks with precision and efficiency.</p>
        <a href="{{ route('shop') }}" class="btn btn-dark">
            Explore More
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
    </div>
    <div class="why-visual">
        <div class="ph-back">
            <img src="https://images.unsplash.com/photo-1559127452-829071a09516?auto=format&fit=crop&w=800&q=80" alt="Model">
        </div>
        <div class="ph-front">
            <img src="https://images.unsplash.com/photo-1520367745676-56196632073f?auto=format&fit=crop&w=500&q=80" alt="Jaket">
        </div>
        <div class="badge-quality">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 3h12l3 5-9 13L3 8z"/><path d="M3 8h18M9 3l3 5 3-5M12 8l-2 13M12 8l2 13"/></svg>
            Premium Quality
        </div>
    </div>
</section>

<!-- PERK BAR -->
<section class="reveal pt-0">
    <div class="perk-bar">
        <div class="perk">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="1" y="7" width="14" height="10" rx="1.5"/><path d="M15 10h4l3 3v4h-7z"/><circle cx="6" cy="19.5" r="1.6"/><circle cx="18" cy="19.5" r="1.6"/></svg>
            <div><strong>Free Shipping</strong><span>On all orders over $100</span></div>
        </div>
        <div class="perk">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2l8 4v6c0 5-3.4 8.6-8 10-4.6-1.4-8-5-8-10V6z"/><path d="M9 12l2 2 4-4"/></svg>
            <div><strong>Secure Payment</strong><span>100% secure checkout</span></div>
        </div>
        <div class="perk">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 15v-3a8 8 0 0116 0v3"/><path d="M2 16.5a2 2 0 012-2h1v5H4a2 2 0 01-2-2zM22 16.5a2 2 0 00-2-2h-1v5h1a2 2 0 002-2z"/></svg>
            <div><strong>24/7 Support</strong><span>Dedicated support</span></div>
        </div>
    </div>
</section>

<!-- SHOP BY CATEGORY -->
<section id="category" class="reveal">
    <div class="cat-head">
        <h2>Shop By Category</h2>
    </div>
    <div class="cat-grid">
        @foreach($categories as $category)
        <div class="cat-card">
            <div class="cat-thumb">
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                @else
                    <div class="ph-empty">◈</div>
                @endif
            </div>
            <div class="cat-info">
                <h3>{{ $category->name }}</h3>
                <a href="{{ route('shop', ['category' => $category->id]) }}">
                    Explore
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>

@endsection

@section('sidebar')

<!-- BEST SELLERS -->
<section class="reveal">
    <div class="side-head">
        <h2>Best Sellers</h2>
        <div class="arrow-nav">
            <button aria-label="Sebelumnya">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button aria-label="Selanjutnya">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>
    </div>
    <div class="bs-grid">
        @php
            $bestSellers = \App\Models\Product::where('is_featured', true)->take(3)->get();
        @endphp
        @foreach($bestSellers as $product)
        <div class="bs-card">
            <div class="bs-thumb">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                    <div class="ph-empty">◈</div>
                @endif
            </div>
            <h4>{{ $product->name }}</h4>
            <p>Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        </div>
        @endforeach
    </div>
</section>

<!-- DARK BANNER -->
<section class="reveal pt-0">
    <div class="banner-dark">
        <div class="banner-text">
            <h3>Designed With You In Mind</h3>
            <p>Our comprehensive features make managing expenses a breeze.</p>
            <div class="play-row">
                <a href="{{ route('shop') }}" class="mini-btn">Discover Now</a>
                <button class="play-circle" aria-label="Putar video">
                    <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="6 4 20 12 6 20"/></svg>
                </button>
            </div>
        </div>
        <div class="banner-img">
            <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=500&q=80" alt="Couple">
        </div>
    </div>
</section>

<!-- FEATURED COLLECTION -->
<section id="featured" class="reveal pt-0">
    <h2 class="side-head-title">The Featured Collection</h2>
    <div class="fc-grid">
        @php
            $featuredProducts = \App\Models\Product::where('is_featured', true)->take(4)->get();
        @endphp
        @foreach($featuredProducts as $product)
        <div class="fc-card">
            <div class="fc-thumb">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                    <div class="ph-empty">◈</div>
                @endif
            </div>
            <h5>{{ $product->name }}</h5>
            <a href="{{ route('product.detail', $product->slug) }}">
                Explore Now
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
        @endforeach
    </div>
</section>

<!-- TESTIMONIALS -->
<section class="reveal pt-0">
    <div class="testimonial-wrap">
        <h2>What Our Customers Say</h2>
        <div class="quote-row">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 7C6 7 4 9.5 4 12.5S6 18 9 18v-3c-1.5 0-2.5-1-2.5-2.5S7.5 10 9 10z"/><path d="M18 7c-3 0-5 2.5-5 5.5S15 18 18 18v-3c-1.5 0-2.5-1-2.5-2.5S16.5 10 18 10z"/></svg>
            <div class="testimonial-slide" id="testimonialText">
                <p id="tText">Anti has completely transformed my wardrobe. The quality, style, and comfort are unmatched. Truly my go-to brand.</p>
                <span id="tAuthor">— Jessica M.</span>
            </div>
            <svg viewBox="0 0 24 24" fill="currentColor" style="transform:rotate(180deg)"><path d="M9 7C6 7 4 9.5 4 12.5S6 18 9 18v-3c-1.5 0-2.5-1-2.5-2.5S7.5 10 9 10z"/><path d="M18 7c-3 0-5 2.5-5 5.5S15 18 18 18v-3c-1.5 0-2.5-1-2.5-2.5S16.5 10 18 10z"/></svg>
        </div>
        <div class="dots" id="dots">
            <button class="active" data-i="0"></button>
            <button data-i="1"></button>
            <button data-i="2"></button>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="reveal pt-0">
    <div class="faq-wrap">
        <h2>Frequently Asked Questions</h2>
        <div class="faq-item">
            <button class="faq-q">
                What sizes do we offer?
                <span class="plus"></span>
            </button>
            <div class="faq-a">We offer sizes from XS to XXL across most of our collections, with an extended size guide available on every product page.</div>
        </div>
        <div class="faq-item">
            <button class="faq-q">
                Do you ship internationally?
                <span class="plus"></span>
            </button>
            <div class="faq-a">Yes, we ship to over 40 countries. Shipping costs and delivery times are calculated at checkout based on your location.</div>
        </div>
        <div class="faq-item">
            <button class="faq-q">
                How can I track my order?
                <span class="plus"></span>
            </button>
            <div class="faq-a">Once your order ships, you will receive a tracking link by email so you can follow it every step of the way.</div>
        </div>
        <div class="faq-item">
            <button class="faq-q">
                What is your return policy?
                <span class="plus"></span>
            </button>
            <div class="faq-a">Unworn items can be returned within 30 days of delivery for a full refund or exchange.</div>
        </div>
    </div>
</section>

<!-- NEWSLETTER + FOOTER -->
<!-- NEWSLETTER + FOOTER -->
<section id="footer" class="reveal pt-0" style="padding:0 32px 0;">
    <div class="newsletter-footer" style="background:var(--ink);color:var(--cream);border-radius:var(--radius-md) var(--radius-md) 0 0;padding:46px 34px 34px;">
        <div class="nl-title" style="text-align:center;margin-bottom:26px;">
            <h2 style="font-size:1.4rem;font-weight:400;margin-bottom:8px;">Stay in Style</h2>
            <p style="font-size:.82rem;color:rgba(243,237,228,.6);">Join our newsletter and get 10% off your first order.</p>
        </div>
        <form class="nl-form" onsubmit="event.preventDefault(); showToast('Subscribed successfully!'); this.querySelector('input').value='';" style="display:flex;background:rgba(243,237,228,.08);border:1px solid rgba(243,237,228,.2);border-radius:999px;padding:5px;max-width:420px;margin:0 auto 44px;">
            <input type="email" placeholder="Enter your email" required style="flex:1;background:transparent;border:none;outline:none;color:var(--cream);padding:10px 16px;font-size:.82rem;">
            <button type="submit" style="background:var(--gold);color:var(--ink);padding:11px 22px;border-radius:999px;font-size:.7rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;transition:background .3s var(--ease);white-space:nowrap;border:none;cursor:pointer;">Subscribe</button>
        </form>

        <div class="foot-grid" style="display:grid;grid-template-columns:1.4fr 1fr 1fr 1fr;gap:20px;padding-top:34px;border-top:1px solid rgba(243,237,228,.12);">
            <div>
                <div class="brand" style="font-family:'Fraunces',serif;font-size:1.3rem;margin-bottom:8px;">Anti</div>
                <p class="tag" style="font-size:.76rem;color:rgba(243,237,228,.5);line-height:1.5;">Timeless style. Everyday comfort.</p>
            </div>
            <div>
                <h4 style="font-size:.74rem;text-transform:uppercase;letter-spacing:.08em;margin-bottom:14px;color:rgba(243,237,228,.85);">Shop</h4>
                <ul>
                    <li style="margin-bottom:9px;"><a href="{{ route('shop') }}" style="font-size:.78rem;color:rgba(243,237,228,.55);transition:color .25s var(--ease);text-decoration:none;">Men</a></li>
                    <li style="margin-bottom:9px;"><a href="{{ route('shop') }}" style="font-size:.78rem;color:rgba(243,237,228,.55);transition:color .25s var(--ease);text-decoration:none;">Women</a></li>
                    <li style="margin-bottom:9px;"><a href="{{ route('shop') }}" style="font-size:.78rem;color:rgba(243,237,228,.55);transition:color .25s var(--ease);text-decoration:none;">Accessories</a></li>
                    <li style="margin-bottom:9px;"><a href="{{ route('shop') }}" style="font-size:.78rem;color:rgba(243,237,228,.55);transition:color .25s var(--ease);text-decoration:none;">Footwear</a></li>
                </ul>
            </div>
            <div>
                <h4 style="font-size:.74rem;text-transform:uppercase;letter-spacing:.08em;margin-bottom:14px;color:rgba(243,237,228,.85);">Company</h4>
                <ul>
                    <li style="margin-bottom:9px;"><a href="{{ route('about') }}" style="font-size:.78rem;color:rgba(243,237,228,.55);transition:color .25s var(--ease);text-decoration:none;">About Us</a></li>
                    <li style="margin-bottom:9px;"><a href="{{ route('lookbook') }}" style="font-size:.78rem;color:rgba(243,237,228,.55);transition:color .25s var(--ease);text-decoration:none;">Lookbook</a></li>
                    <li style="margin-bottom:9px;"><a href="{{ route('contact') }}" style="font-size:.78rem;color:rgba(243,237,228,.55);transition:color .25s var(--ease);text-decoration:none;">Contact</a></li>
                    <li style="margin-bottom:9px;"><a href="#" style="font-size:.78rem;color:rgba(243,237,228,.55);transition:color .25s var(--ease);text-decoration:none;">Careers</a></li>
                </ul>
            </div>
            <div>
                <h4 style="font-size:.74rem;text-transform:uppercase;letter-spacing:.08em;margin-bottom:14px;color:rgba(243,237,228,.85);">Help</h4>
                <ul>
                    <li style="margin-bottom:9px;"><a href="#" style="font-size:.78rem;color:rgba(243,237,228,.55);transition:color .25s var(--ease);text-decoration:none;">FAQs</a></li>
                    <li style="margin-bottom:9px;"><a href="#" style="font-size:.78rem;color:rgba(243,237,228,.55);transition:color .25s var(--ease);text-decoration:none;">Shipping</a></li>
                    <li style="margin-bottom:9px;"><a href="#" style="font-size:.78rem;color:rgba(243,237,228,.55);transition:color .25s var(--ease);text-decoration:none;">Returns</a></li>
                    <li style="margin-bottom:9px;"><a href="#" style="font-size:.78rem;color:rgba(243,237,228,.55);transition:color .25s var(--ease);text-decoration:none;">Privacy Policy</a></li>
                </ul>
            </div>
        </div>

        <div class="foot-bottom" style="display:flex;align-items:center;justify-content:space-between;margin-top:34px;padding-top:22px;border-top:1px solid rgba(243,237,228,.12);font-size:.72rem;color:rgba(243,237,228,.45);">
            <span>© 2026 Anti. All rights reserved.</span>
            <div class="socials" style="display:flex;gap:12px;">
                <a href="#" aria-label="Instagram" style="width:30px;height:30px;border-radius:50%;border:1px solid rgba(243,237,228,.2);display:flex;align-items:center;justify-content:center;transition:background .3s var(--ease), transform .3s var(--ease);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" style="width:13px;height:13px;"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>
                </a>
                <a href="#" aria-label="Twitter" style="width:30px;height:30px;border-radius:50%;border:1px solid rgba(243,237,228,.2);display:flex;align-items:center;justify-content:center;transition:background .3s var(--ease), transform .3s var(--ease);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" style="width:13px;height:13px;"><path d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.5-1.3 1.8-2.3-.8.5-1.7.8-2.6 1a4 4 0 00-6.9 3.6A11.5 11.5 0 013 4.6a4 4 0 001.3 5.4c-.6 0-1.2-.2-1.7-.5v.1a4 4 0 003.2 4 4 4 0 01-1.8.1 4 4 0 003.8 2.8A8.1 8.1 0 012 18.4a11.5 11.5 0 006.3 1.9c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.2z"/></svg>
                </a>
                <a href="#" aria-label="Facebook" style="width:30px;height:30px;border-radius:50%;border:1px solid rgba(243,237,228,.2);display:flex;align-items:center;justify-content:center;transition:background .3s var(--ease), transform .3s var(--ease);">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" style="width:13px;height:13px;"><path d="M15 3h-2a5 5 0 00-5 5v2H6v4h2v7h4v-7h3l1-4h-4V8a1 1 0 011-1h3z"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    // FAQ Accordion
    document.querySelectorAll('.faq-item').forEach(item => {
        item.querySelector('.faq-q').addEventListener('click', () => {
            const wasOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
            if (!wasOpen) item.classList.add('open');
        });
    });

    // Testimonial Carousel
    const testimonials = [
        {text: "Anti has completely transformed my wardrobe. The quality, style, and comfort are unmatched. Truly my go-to brand.", author: "— Jessica M."},
        {text: "Every piece feels considered, from the stitching to the fit. I get compliments every single time I wear Anti.", author: "— Daniel R."},
        {text: "Fast shipping, thoughtful packaging, and clothes that actually last. This is what online shopping should feel like.", author: "— Maria K."}
    ];
    let tIndex = 0;
    const tText = document.getElementById('tText');
    const tAuthor = document.getElementById('tAuthor');
    const dots = document.querySelectorAll('#dots button');

    function showTestimonial(i) {
        tText.style.opacity = 0;
        tAuthor.style.opacity = 0;
        setTimeout(() => {
            tText.textContent = testimonials[i].text;
            tAuthor.textContent = testimonials[i].author;
            tText.style.transition = 'opacity .4s ease';
            tAuthor.style.transition = 'opacity .4s ease';
            tText.style.opacity = 1;
            tAuthor.style.opacity = 1;
        }, 220);
        dots.forEach(d => d.classList.remove('active'));
        dots[i].classList.add('active');
        tIndex = i;
    }

    dots.forEach(d => d.addEventListener('click', () => showTestimonial(parseInt(d.dataset.i))));
    setInterval(() => { showTestimonial((tIndex + 1) % testimonials.length); }, 5500);
</script>

@endsection
