@extends('layouts.app')

@section('title', 'About Us — Anti')

@section('content')
<style>
    /* ===== HERO ===== */
    .about-hero{
        position:relative;
        margin:0 56px;
        border-radius:var(--radius-lg);
        overflow:hidden;
        min-height:520px;
        display:flex;align-items:flex-end;
    }
    .about-hero img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;}
    .about-hero::after{
        content:"";position:absolute;inset:0;
        background:linear-gradient(0deg, rgba(20,14,8,.75) 0%, rgba(20,14,8,.3) 48%, rgba(20,14,8,0) 72%);
    }
    .about-hero-content{position:relative;z-index:2;padding:0 56px 54px;color:#fff;max-width:620px;}
    .about-hero-content .eyebrow{color:var(--gold);}
    .about-hero-content h1{
        font-size:clamp(2.2rem,4vw,3.3rem);font-weight:400;line-height:1.1;
        margin-top:12px;letter-spacing:-.01em;
    }
    .about-hero-content p{margin-top:16px;font-size:.95rem;line-height:1.7;color:rgba(255,255,255,.86);max-width:480px;}

    /* ===== INTRO STAT ROW ===== */
    .about-stats{
        padding:56px 56px 0;
    }
    .about-stats-grid{
        display:grid;grid-template-columns:repeat(4,1fr);
        gap:20px;text-align:center;
    }
    .about-stats-grid .stat{
        padding:30px 16px;background:var(--white);
        border:1px solid var(--line);border-radius:var(--radius-md);
        transition:transform .4s var(--ease), box-shadow .4s var(--ease);
    }
    .about-stats-grid .stat:hover{transform:translateY(-6px);box-shadow:0 20px 40px -20px rgba(30,20,10,.3);}
    .about-stats-grid .stat strong{
        display:block;font-family:'Fraunces',serif;font-size:2rem;font-weight:400;color:var(--ink);
    }
    .about-stats-grid .stat span{display:block;margin-top:6px;font-size:.74rem;color:var(--ink-soft);letter-spacing:.02em;}

    /* ===== OUR STORY (reuses .why pattern) ===== */
    .story-text p{margin:22px 0 30px;color:var(--ink-soft);line-height:1.8;max-width:460px;}
    .story-text h2{font-size:2.1rem;font-weight:400;line-height:1.22;margin-top:10px;}

    /* ===== TIMELINE ===== */
    .timeline-section{padding-top:0;}
    .timeline-head{text-align:center;margin-bottom:50px;}
    .timeline-head h2{font-size:2rem;font-weight:400;margin-bottom:10px;}
    .timeline-head p{color:var(--ink-soft);font-size:.9rem;max-width:440px;margin:0 auto;}
    .timeline{position:relative;max-width:760px;margin:0 auto;padding-left:6px;}
    .timeline::before{
        content:"";position:absolute;left:19px;top:6px;bottom:6px;width:1px;
        background:var(--line);
    }
    .timeline-item{position:relative;padding-left:56px;margin-bottom:38px;}
    .timeline-item:last-child{margin-bottom:0;}
    .timeline-dot{
        position:absolute;left:0;top:2px;
        width:40px;height:40px;border-radius:50%;
        background:var(--ink);color:var(--cream);
        display:flex;align-items:center;justify-content:center;
        font-family:'Fraunces',serif;font-size:.78rem;font-weight:500;
        z-index:1;
    }
    .timeline-item .content{
        background:var(--white);border:1px solid var(--line);
        border-radius:var(--radius-md);padding:20px 24px;
        transition:transform .35s var(--ease), box-shadow .35s var(--ease);
    }
    .timeline-item .content:hover{transform:translateX(6px);box-shadow:0 16px 34px -20px rgba(30,20,10,.3);}
    .timeline-item h4{font-size:.98rem;font-weight:600;margin-bottom:4px;}
    .timeline-item p{font-size:.83rem;color:var(--ink-soft);line-height:1.6;margin:0;}

    /* ===== VALUES ===== */
    .values-head{display:flex;align-items:baseline;justify-content:space-between;margin-bottom:30px;}
    .values-head h2{font-size:2rem;font-weight:400;}
    .values-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;}
    .value-card{
        background:var(--white);border:1px solid var(--line);border-radius:var(--radius-md);
        padding:28px 22px;transition:transform .4s var(--ease), box-shadow .4s var(--ease), border-color .4s var(--ease);
    }
    .value-card:hover{transform:translateY(-8px);box-shadow:0 22px 44px -20px rgba(30,20,10,.32);border-color:transparent;}
    .value-card .v-icon{
        width:46px;height:46px;border-radius:50%;
        background:var(--cream-2);display:flex;align-items:center;justify-content:center;
        color:var(--brown);margin-bottom:16px;
    }
    .value-card .v-icon svg{width:20px;height:20px;}
    .value-card h3{font-size:1rem;font-weight:500;margin-bottom:8px;font-family:'Fraunces',serif;}
    .value-card p{font-size:.8rem;color:var(--ink-soft);line-height:1.65;}

    /* ===== TEAM ===== */
    .team-head{text-align:center;margin-bottom:34px;}
    .team-head h2{font-size:2rem;font-weight:400;margin-bottom:10px;}
    .team-head p{color:var(--ink-soft);font-size:.9rem;max-width:460px;margin:0 auto;}
    .team-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;}
    .team-card{text-align:center;}
    .team-photo{
        aspect-ratio:3/3.6;border-radius:var(--radius-md);overflow:hidden;
        margin-bottom:14px;background:var(--cream-2);position:relative;
    }
    .team-photo img{width:100%;height:100%;object-fit:cover;transition:transform .6s var(--ease);}
    .team-card:hover .team-photo img{transform:scale(1.07);}
    .team-photo .social-overlay{
        position:absolute;bottom:0;left:0;right:0;
        display:flex;justify-content:center;gap:8px;
        padding:14px 0;
        background:linear-gradient(0deg, rgba(20,14,8,.75), transparent);
        opacity:0;transform:translateY(8px);
        transition:all .35s var(--ease);
    }
    .team-card:hover .social-overlay{opacity:1;transform:translateY(0);}
    .social-overlay a{
        width:28px;height:28px;border-radius:50%;
        background:rgba(255,255,255,.15);backdrop-filter:blur(4px);
        display:flex;align-items:center;justify-content:center;color:#fff;
        transition:background .3s var(--ease);
    }
    .social-overlay a:hover{background:var(--gold);}
    .social-overlay svg{width:12px;height:12px;}
    .team-card h4{font-size:.92rem;font-weight:500;font-family:'Fraunces',serif;}
    .team-card span{display:block;font-size:.72rem;color:var(--brown);margin-top:2px;font-weight:600;letter-spacing:.02em;}

    /* ===== CTA BANNER ===== */
    .about-cta{
        margin:0;position:relative;overflow:hidden;
        background:var(--ink);color:var(--cream);
        border-radius:var(--radius-lg);
        padding:64px 56px;text-align:center;
    }
    .about-cta::before{
        content:"";position:absolute;top:-120px;left:50%;transform:translateX(-50%);
        width:420px;height:420px;border-radius:50%;
        background:radial-gradient(circle, rgba(199,154,91,.16), transparent 70%);
    }
    .about-cta h2{position:relative;z-index:1;font-size:2rem;font-weight:400;margin-bottom:14px;}
    .about-cta p{position:relative;z-index:1;color:rgba(243,237,228,.6);font-size:.9rem;max-width:440px;margin:0 auto 28px;line-height:1.65;}
    .about-cta .btn{position:relative;z-index:1;}

    @media (max-width:860px){
        .about-hero{margin:0 24px;min-height:400px;}
        .about-hero-content{padding:0 24px 34px;}
        .about-stats{padding:36px 24px 0;}
        .about-stats-grid{grid-template-columns:1fr 1fr;gap:12px;}
        .values-grid{grid-template-columns:1fr 1fr;}
        .team-grid{grid-template-columns:1fr 1fr;}
        .about-cta{padding:44px 24px;border-radius:0;margin:0 -24px;}
    }
    @media (max-width:480px){
        .about-hero{min-height:320px;}
        .about-hero-content h1{font-size:1.7rem;}
        .about-stats-grid{grid-template-columns:1fr 1fr;}
        .about-stats-grid .stat strong{font-size:1.5rem;}
        .story-text h2{font-size:1.6rem;}
        .values-grid,.team-grid{grid-template-columns:1fr;}
        .timeline-item{padding-left:46px;}
        .timeline-dot{width:34px;height:34px;font-size:.68rem;}
        .about-cta h2{font-size:1.5rem;}
    }
</style>

<!-- HERO -->
<section class="about-hero reveal">
    <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1400&q=80" alt="Anti studio">
    <div class="about-hero-content">
        <p class="eyebrow">Our Story</p>
        <h1>Made With Intention, Worn With Ease</h1>
        <p>Anti began as a small studio with one idea: clothing should feel as good as it looks. Years later, that idea still shapes everything we make.</p>
    </div>
</section>

<!-- STATS -->
<section class="about-stats reveal-stagger">
    <div class="about-stats-grid">
        <div class="stat"><strong>12+</strong><span>Years In Craft</span></div>
        <div class="stat"><strong>50K+</strong><span>Happy Customers</span></div>
        <div class="stat"><strong>40+</strong><span>Countries Shipped</span></div>
        <div class="stat"><strong>98%</strong><span>Would Recommend</span></div>
    </div>
</section>

<!-- OUR STORY (reuses global .why layout) -->
<section class="why reveal">
    <div class="why-text story-text">
        <p class="eyebrow">Why We Started</p>
        <h2>Comfort Shouldn't Be a Compromise.</h2>
        <p>We were tired of choosing between clothes that looked good and clothes that felt good. So we built a brand around a simple standard: every piece has to earn its place in your closet — through the fabric, the fit, and the way it holds up over years, not seasons.</p>
        <p>Today, our small team still hand-checks every sample before it goes into production, because the details are the point.</p>
        <a href="{{ route('shop') }}" class="btn btn-dark">
            Explore The Collection
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
    </div>
    <div class="why-visual">
        <div class="ph-back">
            <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=800&q=80" alt="Studio work">
        </div>
        <div class="ph-front">
            <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=500&q=80" alt="Fabric detail">
        </div>
        <div class="badge-quality">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 3h12l3 5-9 13L3 8z"/><path d="M3 8h18M9 3l3 5 3-5M12 8l-2 13M12 8l2 13"/></svg>
            Since 2013
        </div>
    </div>
</section>

<!-- TIMELINE -->
<section class="timeline-section reveal">
    <div class="timeline-head">
        <p class="eyebrow" style="justify-content:center;display:flex;">Our Journey</p>
        <h2>Milestones Along The Way</h2>
        <p>A decade of small decisions that added up to something we're proud of.</p>
    </div>
    <div class="timeline">
        <div class="timeline-item">
            <div class="timeline-dot">'13</div>
            <div class="content">
                <h4>The First Stitch</h4>
                <p>Anti launched from a one-room studio with a single linen shirt design and a promise to never cut corners on fabric.</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-dot">'16</div>
            <div class="content">
                <h4>Opening Our First Store</h4>
                <p>We opened our first physical space, giving customers a place to feel the fabric before they bought it — a principle we still hold onto online.</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-dot">'19</div>
            <div class="content">
                <h4>Going Sustainable</h4>
                <p>We shifted our entire supply chain to certified organic and recycled materials, cutting our water usage by 40%.</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-dot">'22</div>
            <div class="content">
                <h4>Shipping Worldwide</h4>
                <p>Anti crossed into 40+ countries, powered by a community that shared our belief in comfort without compromise.</p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-dot">'26</div>
            <div class="content">
                <h4>Today</h4>
                <p>Still independent, still hand-checking every sample — now with a team of 60 people who care as much as we did on day one.</p>
            </div>
        </div>
    </div>
</section>

<!-- VALUES -->
<section class="reveal-stagger">
    <div class="values-head">
        <h2>What We Stand For</h2>
    </div>
    <div class="values-grid">
        <div class="value-card">
            <div class="v-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M6 3h12l3 5-9 13L3 8z"/></svg></div>
            <h3>Uncompromising Quality</h3>
            <p>Every fabric is tested for feel, durability, and fade before it earns a place in our collection.</p>
        </div>
        <div class="value-card">
            <div class="v-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2C8 6 6 10 6 13a6 6 0 0012 0c0-3-2-7-6-11z"/></svg></div>
            <h3>Sustainable By Default</h3>
            <p>Organic and recycled materials aren't an upgrade for us — they're the standard we build everything on.</p>
        </div>
        <div class="value-card">
            <div class="v-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 20l-8-8 8-8 8 8z"/></svg></div>
            <h3>Honest Craftsmanship</h3>
            <p>No fast-fashion shortcuts. Every piece is made to be worn for years, not one season.</p>
        </div>
        <div class="value-card">
            <div class="v-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M17 21v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2"/><circle cx="10" cy="7" r="4"/></svg></div>
            <h3>People First</h3>
            <p>From our makers to our customers, every relationship is built on fairness and respect.</p>
        </div>
    </div>
</section>

<!-- TEAM -->
<section class="reveal-stagger">
    <div class="team-head">
        <p class="eyebrow" style="justify-content:center;display:flex;">The People Behind Anti</p>
        <h2>Meet Our Team</h2>
        <p>A small group of designers, makers, and dreamers working to make everyday clothing feel a little more special.</p>
    </div>
    <div class="team-grid">
        <div class="team-card">
            <div class="team-photo">
                <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&w=400&q=80" alt="Team member">
                <div class="social-overlay">
                    <a href="#" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/></svg></a>
                    <a href="#" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5a2.5 2.5 0 11-.02 5 2.5 2.5 0 01.02-5zM3 8.98h4v12H3v-12zM9 8.98h3.8v1.64h.06c.53-1 1.83-2.06 3.77-2.06 4.03 0 4.77 2.65 4.77 6.1v6.32h-4v-5.6c0-1.34-.02-3.06-1.87-3.06-1.87 0-2.16 1.46-2.16 2.96v5.7H9v-12z"/></svg></a>
                </div>
            </div>
            <h4>Maya Sinclair</h4>
            <span>Founder & Creative Director</span>
        </div>
        <div class="team-card">
            <div class="team-photo">
                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80" alt="Team member">
                <div class="social-overlay">
                    <a href="#" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/></svg></a>
                    <a href="#" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5a2.5 2.5 0 11-.02 5 2.5 2.5 0 01.02-5zM3 8.98h4v12H3v-12zM9 8.98h3.8v1.64h.06c.53-1 1.83-2.06 3.77-2.06 4.03 0 4.77 2.65 4.77 6.1v6.32h-4v-5.6c0-1.34-.02-3.06-1.87-3.06-1.87 0-2.16 1.46-2.16 2.96v5.7H9v-12z"/></svg></a>
                </div>
            </div>
            <h4>Daniel Cho</h4>
            <span>Head Of Design</span>
        </div>
        <div class="team-card">
            <div class="team-photo">
                <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=400&q=80" alt="Team member">
                <div class="social-overlay">
                    <a href="#" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/></svg></a>
                    <a href="#" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5a2.5 2.5 0 11-.02 5 2.5 2.5 0 01.02-5zM3 8.98h4v12H3v-12zM9 8.98h3.8v1.64h.06c.53-1 1.83-2.06 3.77-2.06 4.03 0 4.77 2.65 4.77 6.1v6.32h-4v-5.6c0-1.34-.02-3.06-1.87-3.06-1.87 0-2.16 1.46-2.16 2.96v5.7H9v-12z"/></svg></a>
                </div>
            </div>
            <h4>Priya Anand</h4>
            <span>Sustainability Lead</span>
        </div>
        <div class="team-card">
            <div class="team-photo">
                <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=400&q=80" alt="Team member">
                <div class="social-overlay">
                    <a href="#" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/></svg></a>
                    <a href="#" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5a2.5 2.5 0 11-.02 5 2.5 2.5 0 01.02-5zM3 8.98h4v12H3v-12zM9 8.98h3.8v1.64h.06c.53-1 1.83-2.06 3.77-2.06 4.03 0 4.77 2.65 4.77 6.1v6.32h-4v-5.6c0-1.34-.02-3.06-1.87-3.06-1.87 0-2.16 1.46-2.16 2.96v5.7H9v-12z"/></svg></a>
                </div>
            </div>
            <h4>Owen Ferrer</h4>
            <span>Operations Manager</span>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="reveal">
    <div class="about-cta">
        <h2>Ready To Feel The Difference?</h2>
        <p>Browse the collection our team has spent over a decade perfecting — one considered detail at a time.</p>
        <a href="{{ route('shop') }}" class="btn">
            Shop The Collection
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
    </div>
</section>

@endsection

@section('sidebar')
<style>
    .glance-card{
        background:var(--white);border:1px solid var(--line);border-radius:var(--radius-md);
        padding:20px;margin-bottom:14px;
    }
    .glance-list .row{
        display:flex;justify-content:space-between;align-items:center;
        padding:10px 0;border-top:1px solid var(--line);font-size:.8rem;
    }
    .glance-list .row:first-child{border-top:none;}
    .glance-list .row span:first-child{color:var(--ink-soft);}
    .glance-list .row span:last-child{font-weight:600;color:var(--ink);}

    .commitment-card{
        background:var(--ink);color:var(--cream);
        border-radius:var(--radius-md);padding:24px 20px;margin-bottom:14px;
    }
    .commitment-card .c-icon{
        width:40px;height:40px;border-radius:50%;
        background:rgba(243,237,228,.1);
        display:flex;align-items:center;justify-content:center;color:var(--gold);
        margin-bottom:14px;
    }
    .commitment-card .c-icon svg{width:18px;height:18px;}
    .commitment-card h3{font-size:.95rem;font-weight:500;margin-bottom:8px;}
    .commitment-card p{font-size:.78rem;color:rgba(243,237,228,.65);line-height:1.65;margin-bottom:16px;}
    .commitment-card .progress-track{
        height:5px;border-radius:999px;background:rgba(243,237,228,.14);overflow:hidden;margin-bottom:8px;
    }
    .commitment-card .progress-fill{
        height:100%;border-radius:999px;background:var(--gold);width:82%;
    }
    .commitment-card .progress-label{
        display:flex;justify-content:space-between;font-size:.68rem;color:rgba(243,237,228,.55);
    }

    .press-card ul{margin-top:12px;}
    .press-card li{
        display:flex;align-items:center;justify-content:space-between;
        padding:11px 0;border-top:1px solid var(--line);font-size:.8rem;
    }
    .press-card li:first-child{border-top:none;}
    .press-card li span:first-child{font-weight:600;color:var(--ink);}
    .press-card li span:last-child{color:var(--ink-soft);font-size:.72rem;}

    .careers-card{text-align:center;}
    .careers-card h3{font-size:.98rem;font-weight:500;margin:6px 0 6px;}
    .careers-card p{font-size:.8rem;color:var(--ink-soft);margin-bottom:16px;line-height:1.6;}
    .careers-card .mini-btn{
        display:inline-block;
        background:var(--ink);color:var(--cream);
        padding:11px 22px;border-radius:999px;
        font-size:.68rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;
        transition:background .3s var(--ease);
    }
    .careers-card .mini-btn:hover{background:var(--brown-deep);}

    .social-follow .icons{display:flex;gap:10px;margin-top:14px;flex-wrap:wrap;}
    .social-follow .icons a{
        width:38px;height:38px;border-radius:50%;
        border:1px solid var(--line);
        display:flex;align-items:center;justify-content:center;
        color:var(--ink-soft);transition:all .3s var(--ease);
    }
    .social-follow .icons a:hover{background:var(--gold);border-color:var(--gold);color:#fff;transform:translateY(-3px);}
    .social-follow .icons svg{width:15px;height:15px;}
</style>

<section class="reveal">
    <div class="side-head">
        <h2>At A Glance</h2>
    </div>

    <div class="glance-card glance-list">
        <div class="row"><span>Founded</span><span>2013, Jakarta</span></div>
        <div class="row"><span>Team Size</span><span>60+ People</span></div>
        <div class="row"><span>Materials</span><span>Organic & Recycled</span></div>
        <div class="row"><span>Ships To</span><span>40+ Countries</span></div>
    </div>

    <div class="commitment-card">
        <div class="c-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 2C8 6 6 10 6 13a6 6 0 0012 0c0-3-2-7-6-11z"/></svg>
        </div>
        <h3>Sustainability Commitment</h3>
        <p>We're on a path to 100% recycled and organic materials across every collection.</p>
        <div class="progress-track"><div class="progress-fill"></div></div>
        <div class="progress-label"><span>82% Complete</span><span>Goal: 2027</span></div>
    </div>

    <div class="glance-card press-card">
        <h3 style="font-size:.92rem;font-weight:500;">As Featured In</h3>
        <ul>
            <li><span>Vogue Business</span><span>2025</span></li>
            <li><span>The Slow Fashion Report</span><span>2024</span></li>
            <li><span>Studio Weekly</span><span>2023</span></li>
        </ul>
    </div>

    <div class="glance-card careers-card">
        <div class="v-icon" style="width:40px;height:40px;border-radius:50%;background:var(--cream-2);display:flex;align-items:center;justify-content:center;color:var(--brown);margin:0 auto;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" width="18" height="18"><path d="M17 21v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2"/><circle cx="10" cy="7" r="4"/></svg>
        </div>
        <h3>We're Hiring</h3>
        <p>Join a small team that cares deeply about the details.</p>
        <a href="{{ route('contact') }}" class="mini-btn">View Openings</a>
    </div>

    <div class="glance-card social-follow">
        <h3 style="font-size:.92rem;font-weight:500;">Follow Along</h3>
        <div class="icons">
            <a href="#" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg></a>
            <a href="#" aria-label="Twitter"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.5-1.3 1.8-2.3-.8.5-1.7.8-2.6 1a4 4 0 00-6.9 3.6A11.5 11.5 0 013 4.6a4 4 0 001.3 5.4c-.6 0-1.2-.2-1.7-.5v.1a4 4 0 003.2 4 4 4 0 01-1.8.1 4 4 0 003.8 2.8A8.1 8.1 0 012 18.4a11.5 11.5 0 006.3 1.9c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.2z"/></svg></a>
            <a href="#" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M15 3h-2a5 5 0 00-5 5v2H6v4h2v7h4v-7h3l1-4h-4V8a1 1 0 011-1h3z"/></svg></a>
        </div>
    </div>
</section>
@endsection
