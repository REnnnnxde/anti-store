@extends('layouts.app')

@section('title', 'Contact — Anti')

@section('content')
<style>
    .contact-hero{
        padding:64px 56px 0;
        text-align:center;
    }
    .contact-hero .eyebrow{margin-bottom:14px;}
    .contact-hero h1{
        font-size:clamp(2.4rem,4.5vw,3.6rem);
        font-weight:400;
        line-height:1.08;
        letter-spacing:-.02em;
        margin-bottom:16px;
    }
    .contact-hero h1 span{color:var(--brown);font-style:italic;font-weight:400;}
    .contact-hero p{
        max-width:520px;margin:0 auto;
        color:var(--ink-soft);font-size:.95rem;line-height:1.75;
    }

    .contact-strip-wrap{padding:44px 56px 0;}

    .contact-form-section{padding:64px 56px;}
    .contact-form-card{
        background:var(--white);
        border-radius:var(--radius-lg);
        border:1px solid var(--line);
        padding:48px 52px;
        box-shadow:0 40px 80px -50px rgba(36,29,22,.25);
        position:relative;
        overflow:hidden;
    }
    .contact-form-card::before{
        content:"";
        position:absolute;top:-80px;right:-80px;
        width:220px;height:220px;border-radius:50%;
        background:radial-gradient(circle, rgba(199,154,91,.14), transparent 70%);
    }
    .contact-form-head{
        display:flex;align-items:flex-end;justify-content:space-between;
        gap:20px;margin-bottom:34px;position:relative;z-index:1;
        flex-wrap:wrap;
    }
    .contact-form-head h2{font-size:1.7rem;font-weight:400;margin-bottom:6px;}
    .contact-form-head p{color:var(--ink-soft);font-size:.85rem;max-width:380px;line-height:1.6;}
    .contact-form-head .response-pill{
        display:flex;align-items:center;gap:8px;
        padding:9px 16px;border-radius:999px;
        background:var(--cream-2);color:var(--ink-soft);
        font-size:.72rem;font-weight:600;white-space:nowrap;
    }
    .contact-form-head .response-pill .dot{
        width:7px;height:7px;border-radius:50%;background:#2d7a5a;
        box-shadow:0 0 0 3px rgba(45,122,90,.18);
    }

    .contact-form{position:relative;z-index:1;}
    .contact-form .form-group{margin-bottom:22px;}
    .contact-form label{
        display:block;font-size:.7rem;font-weight:700;
        letter-spacing:.08em;text-transform:uppercase;
        color:var(--ink-soft);margin-bottom:8px;
    }
    .contact-form input,
    .contact-form textarea{
        width:100%;padding:14px 18px;
        border:1px solid var(--line);border-radius:12px;
        font-size:.9rem;font-family:inherit;
        background:var(--cream);color:var(--ink);
        outline:none;
        transition:border-color .3s var(--ease), box-shadow .3s var(--ease), background .3s var(--ease);
    }
    .contact-form input:focus,
    .contact-form textarea:focus{
        border-color:var(--gold);background:var(--white);
        box-shadow:0 0 0 4px rgba(199,154,91,.14);
    }
    .contact-form textarea{min-height:160px;resize:vertical;}
    .contact-form .form-row{
        display:grid;grid-template-columns:1fr 1fr;gap:20px;
    }
    .contact-form .submit-btn{
        display:inline-flex;align-items:center;gap:10px;
        padding:16px 34px;border:0;border-radius:999px;
        background:var(--ink);color:var(--cream);
        font-size:.74rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
        cursor:pointer;transition:transform .35s var(--ease), box-shadow .35s var(--ease), background .35s var(--ease);
    }
    .contact-form .submit-btn svg{width:14px;height:14px;transition:transform .35s var(--ease);}
    .contact-form .submit-btn:hover{
        background:var(--brown-deep);transform:translateY(-3px);
        box-shadow:0 16px 34px -10px rgba(36,29,22,.4);
    }
    .contact-form .submit-btn:hover svg{transform:translateX(4px);}

    .field-error{color:#a64d47;font-size:.7rem;margin-top:6px;display:block;}
    .alert-success{
        display:flex;align-items:center;gap:10px;
        padding:16px 20px;border-radius:12px;
        background:#eaf5ee;color:#2e7d32;
        font-size:.85rem;margin-bottom:26px;
        border:1px solid #bfe3c9;position:relative;z-index:1;
    }

    /* FAQ (contact-specific, reuses global .faq-wrap look) */
    .contact-faq-section{padding:0 56px 64px;}
    .contact-faq-head{text-align:center;margin-bottom:26px;}
    .contact-faq-head h2{font-size:1.7rem;font-weight:400;margin-bottom:8px;}
    .contact-faq-head p{color:var(--ink-soft);font-size:.85rem;}

    @media (max-width:860px){
        .contact-hero{padding:36px 24px 0;}
        .contact-strip-wrap{padding:30px 24px 0;}
        .contact-form-section{padding:40px 24px;}
        .contact-form-card{padding:30px 22px;}
        .contact-form .form-row{grid-template-columns:1fr;}
        .contact-faq-section{padding:0 24px 44px;}
        .contact-form-head{align-items:flex-start;}
    }
    @media (max-width:480px){
        .contact-hero h1{font-size:1.9rem;}
        .contact-form-card{padding:22px 16px;border-radius:18px;}
        .contact-form input,.contact-form textarea{padding:12px 14px;}
        .contact-form .submit-btn{width:100%;justify-content:center;padding:15px;}
    }
</style>

<!-- HERO -->
<section class="contact-hero reveal">
    <p class="eyebrow">Get In Touch</p>
    <h1>Let's <span>Connect.</span></h1>
    <p>Have a question, feedback, or just want to say hello? We'd love to hear from you — our team usually replies within a day.</p>
</section>

<!-- PERK STRIP (reuses global .perk-bar) -->
<div class="contact-strip-wrap reveal">
    <div class="perk-bar">
        <div class="perk">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg>
            <div><strong>Fast Response</strong><span>Reply within 24 hours</span></div>
        </div>
        <div class="perk">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M17 21v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2"/><circle cx="10" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
            <div><strong>Dedicated Team</strong><span>Real people, not bots</span></div>
        </div>
        <div class="perk">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 15v-3a8 8 0 0116 0v3"/><path d="M2 16.5a2 2 0 012-2h1v5H4a2 2 0 01-2-2zM22 16.5a2 2 0 00-2-2h-1v5h1a2 2 0 002-2z"/></svg>
            <div><strong>Always Here</strong><span>Mon–Fri, 9AM – 6PM</span></div>
        </div>
    </div>
</div>

<!-- FORM -->
<section class="contact-form-section reveal">
    <div class="contact-form-card">
        <div class="contact-form-head">
            <div>
                <h2>Send Us a Message</h2>
                <p>Fill out the form below and we'll get back to you shortly.</p>
            </div>
            <span class="response-pill"><span class="dot"></span>Online now</span>
        </div>

        @if(session('success'))
            <div class="alert-success">✓ {{ session('success') }}</div>
        @endif

        <form class="contact-form" action="{{ route('contact.store') }}" method="POST">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Jane Doe" required>
                    @error('name')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="jane@email.com" required>
                    @error('email')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" placeholder="How can we help?" required>
                @error('subject')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" placeholder="Tell us a bit more..." required>{{ old('message') }}</textarea>
                @error('message')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <button type="submit" class="submit-btn">
                Send Message
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </button>
        </form>
    </div>
</section>

<!-- FAQ -->
<section class="contact-faq-section reveal">
    <div class="contact-faq-head">
        <p class="eyebrow" style="justify-content:center;display:flex;">Before You Write In</p>
        <h2>Quick Answers</h2>
        <p>Might save you a message — and save us a reply.</p>
    </div>
    <div class="faq-wrap">
        <div class="faq-item">
            <button class="faq-q" type="button">How fast will I get a reply?<span class="plus"></span></button>
            <div class="faq-a">Our team replies to every message within 24 hours on business days, and often much sooner.</div>
        </div>
        <div class="faq-item">
            <button class="faq-q" type="button">Can I ask about an existing order?<span class="plus"></span></button>
            <div class="faq-a">Absolutely — just include your order number in the subject line so we can look it up right away.</div>
        </div>
        <div class="faq-item">
            <button class="faq-q" type="button">Do you offer phone support?<span class="plus"></span></button>
            <div class="faq-a">Yes, you can reach us directly by phone Monday to Friday, 9AM–6PM. The number is listed in the sidebar.</div>
        </div>
        <div class="faq-item">
            <button class="faq-q" type="button">Is there a physical store?<span class="plus"></span></button>
            <div class="faq-a">Yes, our studio is open for visits by appointment — drop us a message first and we'll set a time.</div>
        </div>
    </div>
</section>

<script>
    document.querySelectorAll('.faq-item').forEach(item => {
        item.querySelector('.faq-q').addEventListener('click', () => {
            const wasOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
            if (!wasOpen) item.classList.add('open');
        });
    });
</script>
@endsection

@section('sidebar')
<style>
    .contact-card{
        background:var(--white);
        border-radius:var(--radius-md);
        border:1px solid var(--line);
        padding:22px 20px;
        transition:transform .35s var(--ease), box-shadow .35s var(--ease), border-color .35s var(--ease);
    }
    .contact-card:hover{
        transform:translateY(-4px);
        box-shadow:0 20px 40px -22px rgba(36,29,22,.3);
        border-color:transparent;
    }
    .contact-card .icon{
        width:42px;height:42px;border-radius:50%;
        background:var(--cream-2);
        display:flex;align-items:center;justify-content:center;
        margin-bottom:14px;color:var(--brown);
    }
    .contact-card .icon svg{width:18px;height:18px;}
    .contact-card h3{font-size:.92rem;font-weight:500;margin-bottom:4px;}
    .contact-card p{font-size:.82rem;color:var(--ink-soft);margin:0;line-height:1.6;}
    .contact-card a{color:var(--ink);text-decoration:none;font-weight:600;transition:color .3s var(--ease);}
    .contact-card a:hover{color:var(--brown);}
    .contact-card .sub{font-size:.72rem;color:var(--ink-soft);margin-top:4px;display:block;}

    .contact-cards-grid{display:flex;flex-direction:column;gap:14px;margin-bottom:14px;}

    .contact-hours{
        background:var(--ink);color:var(--cream);
        border-radius:var(--radius-md);
        padding:22px 20px;margin-bottom:14px;
    }
    .contact-hours h3{font-size:.92rem;font-weight:500;margin-bottom:14px;}
    .contact-hours .row{
        display:flex;justify-content:space-between;
        font-size:.78rem;padding:8px 0;
        border-top:1px solid rgba(243,237,228,.12);
        color:rgba(243,237,228,.75);
    }
    .contact-hours .row:first-of-type{border-top:none;}
    .contact-hours .row strong{color:var(--cream);font-weight:500;}

    .contact-social-card{margin-bottom:14px;}
    .contact-social-card .icons{display:flex;gap:10px;margin-top:14px;flex-wrap:wrap;}
    .contact-social-card .icons a{
        width:38px;height:38px;border-radius:50%;
        border:1px solid var(--line);
        display:flex;align-items:center;justify-content:center;
        color:var(--ink-soft);
        transition:all .3s var(--ease);
    }
    .contact-social-card .icons a:hover{
        background:var(--gold);border-color:var(--gold);color:var(--white);
        transform:translateY(-3px);
    }
    .contact-social-card .icons svg{width:15px;height:15px;}

    .contact-map{
        border-radius:var(--radius-md);overflow:hidden;
        border:1px solid var(--line);
    }
    .contact-map iframe{display:block;width:100%;height:220px;border:0;}

    @media (max-width:1180px){
        .contact-cards-grid{display:grid;grid-template-columns:repeat(3,1fr);}
    }
    @media (max-width:768px){
        .contact-cards-grid{grid-template-columns:1fr 1fr;}
    }
    @media (max-width:480px){
        .contact-cards-grid{grid-template-columns:1fr;}
    }
</style>

<section class="reveal">
    <div class="side-head">
        <h2>Contact Info</h2>
    </div>

    <div class="contact-cards-grid">
        <div class="contact-card">
            <div class="icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 4h16v16H4z"/><path d="M4 6l8 7 8-7"/></svg>
            </div>
            <h3>Email Us</h3>
            <p><a href="mailto:hello@anti.com">hello@anti.com</a></p>
            <span class="sub">We reply within 24 hours</span>
        </div>

        <div class="contact-card">
            <div class="icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M22 16.9v3a2 2 0 01-2.2 2 19.8 19.8 0 01-8.6-3.1 19.5 19.5 0 01-6-6A19.8 19.8 0 012.1 4.2 2 2 0 014.1 2h3a2 2 0 012 1.7c.1 1 .3 2 .6 3a2 2 0 01-.5 2.1L8 10a16 16 0 006 6l1.2-1.2a2 2 0 012.1-.5c1 .3 2 .5 3 .6a2 2 0 011.7 2.1z"/></svg>
            </div>
            <h3>Call Us</h3>
            <p><a href="tel:+62123456789">+62 123 456 789</a></p>
            <span class="sub">Mon–Fri, 9AM – 6PM</span>
        </div>

        <div class="contact-card">
            <div class="icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 22s8-7.2 8-13a8 8 0 10-16 0c0 5.8 8 13 8 13z"/><circle cx="12" cy="9" r="3"/></svg>
            </div>
            <h3>Visit Us</h3>
            <p>Jl. Anti No. 123<br>Jakarta, Indonesia 12345</p>
        </div>
    </div>

    <div class="contact-hours">
        <h3>Studio Hours</h3>
        <div class="row"><span>Monday – Friday</span><strong>9AM – 6PM</strong></div>
        <div class="row"><span>Saturday</span><strong>10AM – 4PM</strong></div>
        <div class="row"><span>Sunday</span><strong>Closed</strong></div>
    </div>

    <div class="contact-card contact-social-card">
        <h3>Follow Us</h3>
        <p style="margin-top:4px;">Stay connected on social media</p>
        <div class="icons">
            <a href="#" aria-label="Instagram">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>
            </a>
            <a href="#" aria-label="Twitter">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.5-1.3 1.8-2.3-.8.5-1.7.8-2.6 1a4 4 0 00-6.9 3.6A11.5 11.5 0 013 4.6a4 4 0 001.3 5.4c-.6 0-1.2-.2-1.7-.5v.1a4 4 0 003.2 4 4 4 0 01-1.8.1 4 4 0 003.8 2.8A8.1 8.1 0 012 18.4a11.5 11.5 0 006.3 1.9c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.2z"/></svg>
            </a>
            <a href="#" aria-label="Facebook">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M15 3h-2a5 5 0 00-5 5v2H6v4h2v7h4v-7h3l1-4h-4V8a1 1 0 011-1h3z"/></svg>
            </a>
            <a href="#" aria-label="YouTube">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M23 7.5a3 3 0 00-2.1-2.1C19.7 5 12 5 12 5s-7.7 0-8.9.4A3 3 0 001 7.5C.6 8.7.6 12 .6 12s0 3.3.4 4.5a3 3 0 002.1 2.1c1.2.4 8.9.4 8.9.4s7.7 0 8.9-.4a3 3 0 002.1-2.1c.4-1.2.4-4.5.4-4.5s0-3.3-.4-4.5z"/><polygon points="10 15.5 16 12 10 8.5"/></svg>
            </a>
        </div>
    </div>

    <div class="contact-map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.518872119722!2d106.82898241476993!3d-6.175437495545707!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f421f0f9b3cf%3A0x8b6b3e0a8b5b3e0!2sJakarta!5e0!3m2!1sen!2sid!4v1700000000000"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</section>
@endsection
