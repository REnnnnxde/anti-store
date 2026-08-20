<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Anti — Everyday Comfort With Stylish Versatility')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,500;0,9..144,600;1,9..144,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/js/app.js'])

    <style>
        :root{
            --cream:#f3ede4;
            --cream-2:#ece3d6;
            --ink:#241d16;
            --ink-soft:#4a4038;
            --brown:#8a5a34;
            --brown-deep:#5c3b21;
            --gold:#c79a5b;
            --line:rgba(36,29,22,0.12);
            --white:#fffdf9;
            --radius-lg: 26px;
            --radius-md: 16px;
            --ease:cubic-bezier(.16,.84,.32,1);
        }

        *{margin:0;padding:0;box-sizing:border-box;}
        html{scroll-behavior:smooth;}
        body{
            font-family:'Inter',sans-serif;
            background:var(--cream);
            color:var(--ink);
            -webkit-font-smoothing:antialiased;
            overflow-x:hidden;
        }
        img{display:block;max-width:100%;}
        a{text-decoration:none;color:inherit;}
        ul{list-style:none;}
        button{font-family:inherit;cursor:pointer;border:none;background:none;}

        h1,h2,h3,.serif{font-family:'Fraunces',serif;}

        .eyebrow{
            text-transform:uppercase;
            letter-spacing:.14em;
            font-size:.72rem;
            font-weight:600;
            color:var(--brown);
        }

        /* ---------- layout shell ---------- */
        .page{
            display:grid;
            grid-template-columns: 1fr 400px;
            max-width:1440px;
            margin:0 auto;
            background:var(--cream);
        }
        .col-main{border-right:1px solid var(--line);}
        .col-side{background:var(--cream-2);}

        section{padding:64px 56px;}
        .col-side section{padding:44px 32px;}

        /* utility */
        .pt-0{padding-top:0;}

        /* reveal */
        .reveal{
            opacity:0;
            transform:translateY(28px);
            transition:opacity .9s var(--ease), transform .9s var(--ease);
        }
        .reveal.in{opacity:1;transform:translateY(0);}
        .reveal-stagger > *{
            opacity:0;
            transform:translateY(22px);
            transition:opacity .7s var(--ease), transform .7s var(--ease);
        }
        .reveal-stagger.in > *{opacity:1;transform:translateY(0);}
        .reveal-stagger.in > *:nth-child(1){transition-delay:.05s;}
        .reveal-stagger.in > *:nth-child(2){transition-delay:.15s;}
        .reveal-stagger.in > *:nth-child(3){transition-delay:.25s;}
        .reveal-stagger.in > *:nth-child(4){transition-delay:.35s;}

        /* ---------- header ---------- */
        header.site{
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:32px 56px 20px;
            background:var(--cream);
        }
        .logo{
            font-family:'Fraunces',serif;
            font-size:1.7rem;
            font-weight:500;
            letter-spacing:.02em;
        }
        nav.main-nav ul{display:flex;gap:38px;}
        nav.main-nav a{
            font-size:.92rem;
            font-weight:500;
            position:relative;
            padding-bottom:4px;
        }
        nav.main-nav a::after{
            content:"";
            position:absolute;left:0;bottom:0;
            width:0;height:1px;background:var(--ink);
            transition:width .35s var(--ease);
        }
        nav.main-nav a:hover::after{width:100%;}
        .header-icons{display:flex;align-items:center;gap:22px;}
        .header-icons button{
            width:20px;height:20px;color:var(--ink);
            display:flex;align-items:center;justify-content:center;
            transition:transform .25s var(--ease);
            background:none;border:none;cursor:pointer;
        }
        .header-icons button:hover{transform:translateY(-2px);}
        .header-icons a{color:var(--ink);}
        .cart-wrap{position:relative;}
        .cart-badge{
            position:absolute;top:-8px;right:-10px;
            background:var(--brown);color:#fff;
            font-size:.62rem;font-weight:700;
            width:16px;height:16px;border-radius:50%;
            display:flex;align-items:center;justify-content:center;
        }
        .burger{
            display:none;
            align-items:center;
            justify-content:center;
            flex-direction:column;
            gap:4px;
            width:40px;
            height:40px;
            flex-shrink:0;
            border:1px solid var(--line);
            border-radius:50%;
            background:var(--white);
            cursor:pointer;
            transition:background .25s var(--ease), border-color .25s var(--ease);
        }
        .burger:hover{background:var(--cream-2);}
        .burger span{
            width:16px;height:1.6px;background:var(--ink);border-radius:2px;
            transition:transform .3s var(--ease), opacity .3s var(--ease);
        }
        .burger.open{background:var(--ink);border-color:var(--ink);}
        .burger.open span{background:var(--cream);}
        .burger.open span:nth-child(1){transform:translateY(5.6px) rotate(45deg);}
        .burger.open span:nth-child(2){opacity:0;}
        .burger.open span:nth-child(3){transform:translateY(-5.6px) rotate(-45deg);}

        /* ---------- mobile menu ---------- */
        .mobile-menu{
            max-height:0;
            opacity:0;
            overflow:hidden;
            background:var(--white);
            margin:0 24px;
            border-radius:var(--radius-md);
            border:1px solid var(--line);
            transition:max-height .4s var(--ease), opacity .3s var(--ease), margin .4s var(--ease), box-shadow .3s var(--ease);
        }
        .mobile-menu.open{
            max-height:520px;
            opacity:1;
            margin:0 24px 22px;
            box-shadow:0 20px 40px -18px rgba(30,20,10,.28);
        }
        .mobile-menu ul{
            display:flex;
            flex-direction:column;
            padding:8px 0;
        }
        .mobile-menu li{border-bottom:1px solid var(--line);}
        .mobile-menu li:last-child{border-bottom:none;}
        .mobile-menu li form{margin:0;}
        .mobile-menu a,
        .mobile-menu button{
            display:block;
            width:100%;
            text-align:center;
            padding:15px 20px;
            font-size:.92rem;
            font-weight:500;
            transition:background .2s var(--ease);
        }
        .mobile-menu a:hover,
        .mobile-menu button:hover{background:var(--cream-2);}
        .mobile-menu li:last-child button{
            color:var(--brown-deep);
            font-weight:700;
        }

        /* ---------- toast ---------- */
        .toast{
            position:fixed;
            right:28px;
            bottom:28px;
            background:var(--ink);
            color:#fff;
            padding:14px 22px;
            border-radius:12px;
            font-size:12px;
            z-index:999;
            opacity:0;
            transform:translateY(16px);
            transition:all .4s ease;
            box-shadow:0 8px 32px rgba(0,0,0,0.15);
        }
        .toast.show{
            opacity:1;
            transform:translateY(0);
        }

        /* ---------- hero ---------- */
        .hero{
            position:relative;
            margin:0 56px 0;
            border-radius:var(--radius-lg);
            overflow:hidden;
            min-height:640px;
            display:flex;
            align-items:flex-end;
        }
        .hero img{
            position:absolute;inset:0;
            width:100%;height:100%;object-fit:cover;
        }
        .hero::after{
            content:"";
            position:absolute;inset:0;
            background:linear-gradient(0deg, rgba(20,14,8,.72) 0%, rgba(20,14,8,.28) 46%, rgba(20,14,8,0) 68%);
            pointer-events:none;
        }
        .hero-content{
            position:relative;z-index:2;
            padding:0 60px 64px;
            color:#fff;
            max-width:640px;
        }
        .hero-content h1{
            font-size:clamp(2.4rem, 4vw, 3.5rem);
            font-weight:400;
            line-height:1.12;
            letter-spacing:-.01em;
        }
        .hero-content p{
            margin-top:18px;
            font-size:1rem;
            line-height:1.6;
            color:rgba(255,255,255,.86);
            max-width:460px;
        }
        .hero-content .btn{margin-top:30px;}

        .btn{
            display:inline-flex;align-items:center;gap:10px;
            background:var(--white);color:var(--ink);
            padding:16px 26px;border-radius:999px;
            font-size:.85rem;font-weight:600;
            letter-spacing:.03em;text-transform:uppercase;
            transition:transform .35s var(--ease), box-shadow .35s var(--ease), background .35s var(--ease);
        }
        .btn svg{width:15px;height:15px;transition:transform .35s var(--ease);}
        .btn:hover{transform:translateY(-3px);box-shadow:0 14px 30px rgba(20,14,8,.28);}
        .btn:hover svg{transform:translateX(4px);}
        .btn-dark{background:var(--ink);color:var(--cream);}
        .btn-dark:hover{background:var(--brown-deep);}

        /* ---------- why choose us ---------- */
        .why{
            display:grid;
            grid-template-columns: 1fr 1fr;
            gap:60px;
            align-items:center;
        }
        .why-text p{
            margin:22px 0 30px;
            color:var(--ink-soft);
            line-height:1.75;
            max-width:420px;
        }
        .why-text h2{
            font-size:2.3rem;
            font-weight:400;
            line-height:1.2;
            margin-top:10px;
        }
        .why-visual{position:relative;height:460px;}
        .why-visual .ph-back{
            position:absolute;top:0;right:0;
            width:78%;height:88%;
            border-radius:var(--radius-md);
            overflow:hidden;
            box-shadow:0 30px 60px -20px rgba(30,20,10,.35);
        }
        .why-visual .ph-front{
            position:absolute;bottom:0;left:0;
            width:52%;height:52%;
            border-radius:var(--radius-md);
            overflow:hidden;
            border:6px solid var(--cream);
            box-shadow:0 20px 40px -12px rgba(30,20,10,.4);
            transition:transform .5s var(--ease);
        }
        .why-visual:hover .ph-front{transform:translate(-6px,-6px);}
        .why-visual img{width:100%;height:100%;object-fit:cover;}
        .badge-quality{
            position:absolute;
            left:38%;bottom:14%;
            background:var(--white);
            width:118px;height:118px;
            border-radius:50%;
            display:flex;flex-direction:column;align-items:center;justify-content:center;
            text-align:center;
            font-size:.72rem;font-weight:600;
            letter-spacing:.02em;
            box-shadow:0 20px 40px -10px rgba(30,20,10,.3);
            animation:floaty 5s ease-in-out infinite;
        }
        .badge-quality svg{width:22px;height:22px;margin-bottom:6px;color:var(--brown);}
        @keyframes floaty{
            0%,100%{transform:translateY(0);}
            50%{transform:translateY(-10px);}
        }

        /* ---------- perk bar ---------- */
        .perk-bar{
            background:var(--ink);
            color:var(--cream);
            border-radius:var(--radius-md);
            display:flex;
            padding:30px 40px;
        }
        .perk{
            flex:1;
            display:flex;align-items:center;gap:16px;
            padding:0 18px;
        }
        .perk + .perk{border-left:1px solid rgba(243,237,228,.15);}
        .perk svg{width:26px;height:26px;flex-shrink:0;color:var(--gold);}
        .perk strong{display:block;font-size:.95rem;font-weight:600;}
        .perk span{display:block;font-size:.8rem;color:rgba(243,237,228,.62);margin-top:2px;}

        /* ---------- category ---------- */
        .cat-head{
            display:flex;align-items:baseline;justify-content:space-between;
            margin-bottom:30px;
        }
        .cat-head h2{font-size:2rem;font-weight:400;}
        .cat-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:22px;
        }
        .cat-card{
            background:var(--white);
            border-radius:var(--radius-md);
            overflow:hidden;
            transition:transform .45s var(--ease), box-shadow .45s var(--ease);
        }
        .cat-card:hover{transform:translateY(-8px);box-shadow:0 22px 40px -18px rgba(30,20,10,.35);}
        .cat-thumb{height:200px;overflow:hidden;}
        .cat-thumb img{width:100%;height:100%;object-fit:cover;transition:transform .6s var(--ease);}
        .cat-card:hover .cat-thumb img{transform:scale(1.08);}
        .cat-info{
            padding:18px 20px;
            display:flex;align-items:center;justify-content:space-between;
        }
        .cat-info h3{font-size:1.02rem;font-weight:500;font-family:'Fraunces',serif;}
        .cat-info a{
            font-size:.68rem;font-weight:700;letter-spacing:.08em;
            color:var(--brown);text-transform:uppercase;
            display:flex;align-items:center;gap:6px;
        }
        .cat-info a svg{width:12px;height:12px;transition:transform .3s var(--ease);}
        .cat-card:hover .cat-info a svg{transform:translateX(4px);}

        /* ---------- sidebar shared ---------- */
        .side-head{
            display:flex;align-items:center;justify-content:space-between;
            margin-bottom:22px;
        }
        .side-head h2{font-size:1.35rem;font-weight:500;}
        .side-head-title{font-size:1.35rem;font-weight:500;}
        .arrow-nav{display:flex;gap:8px;}
        .arrow-nav button{
            width:30px;height:30px;border-radius:50%;
            border:1px solid var(--line);
            display:flex;align-items:center;justify-content:center;
            transition:background .3s var(--ease), transform .3s var(--ease);
        }
        .arrow-nav button:hover{background:var(--ink);color:var(--cream);transform:scale(1.06);}
        .arrow-nav svg{width:13px;height:13px;}

        /* best sellers */
        .bs-grid{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:14px;
        }
        .bs-card{cursor:pointer;}
        .bs-thumb{
            border-radius:14px;overflow:hidden;
            aspect-ratio:3/4;margin-bottom:10px;
            position:relative;
        }
        .bs-thumb img{width:100%;height:100%;object-fit:cover;transition:transform .6s var(--ease);}
        .bs-card:hover .bs-thumb img{transform:scale(1.09);}
        .bs-card h4{font-size:.82rem;font-weight:500;line-height:1.3;}
        .bs-card p{font-size:.8rem;color:var(--brown);font-weight:600;margin-top:3px;}

        /* dark banner */
        .banner-dark{
            background:var(--ink);
            border-radius:var(--radius-md);
            overflow:hidden;
            position:relative;
            min-height:220px;
            display:flex;
        }
        .banner-dark .banner-text{
            padding:34px 30px;
            color:var(--cream);
            flex:1.1;
            position:relative;z-index:2;
        }
        .banner-dark h3{
            font-size:1.5rem;font-weight:400;line-height:1.25;
            margin-bottom:12px;
        }
        .banner-dark p{
            font-size:.84rem;color:rgba(243,237,228,.65);
            max-width:220px;margin-bottom:22px;line-height:1.5;
        }
        .play-row{display:flex;align-items:center;gap:14px;}
        .mini-btn{
            background:var(--cream);color:var(--ink);
            padding:11px 20px;border-radius:999px;
            font-size:.68rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;
        }
        .play-circle{
            width:38px;height:38px;border-radius:50%;
            border:1px solid rgba(243,237,228,.4);
            display:flex;align-items:center;justify-content:center;
            transition:background .3s var(--ease);
        }
        .play-circle:hover{background:rgba(243,237,228,.15);}
        .play-circle svg{width:12px;height:12px;color:var(--cream);}
        .banner-dark .banner-img{flex:1;position:relative;}
        .banner-dark .banner-img img{width:100%;height:100%;object-fit:cover;}
        .banner-dark .banner-img::before{
            content:"";position:absolute;inset:0;
            background:linear-gradient(90deg, var(--ink) 0%, rgba(36,29,22,0) 40%);
            z-index:1;
            pointer-events:none;
        }

        /* featured collection */
        .fc-grid{
            margin-top:22px;
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:12px;
        }
        .fc-card{position:relative;}
        .fc-thumb{
            border-radius:12px;overflow:hidden;
            aspect-ratio:3/4.4;margin-bottom:10px;
        }
        .fc-thumb img{width:100%;height:100%;object-fit:cover;transition:transform .6s var(--ease);}
        .fc-card:hover .fc-thumb img{transform:scale(1.09);}
        .fc-card h5{font-size:.76rem;font-weight:500;}
        .fc-card a{
            font-size:.66rem;color:var(--brown);font-weight:700;
            display:flex;align-items:center;gap:4px;margin-top:3px;
        }
        .fc-card a svg{width:10px;height:10px;}

        /* testimonials */
        .testimonial-wrap{
            text-align:center;
            position:relative;
        }
        .testimonial-wrap h2{font-size:1.35rem;font-weight:500;margin-bottom:26px;}
        .quote-row{display:flex;align-items:center;justify-content:center;gap:26px;}
        .quote-row svg{width:20px;height:20px;color:var(--gold);flex-shrink:0;}
        .testimonial-slide{max-width:340px;}
        .testimonial-slide p{
            font-size:.92rem;line-height:1.7;color:var(--ink-soft);
            min-height:96px;
        }
        .testimonial-slide span{
            display:block;margin-top:16px;
            font-size:.8rem;font-weight:600;color:var(--ink);
        }
        .dots{display:flex;justify-content:center;gap:8px;margin-top:22px;}
        .dots button{
            width:8px;height:8px;border-radius:50%;
            background:var(--line);
            transition:all .3s var(--ease);
        }
        .dots button.active{background:var(--brown);width:22px;border-radius:5px;}

        /* faq */
        .faq-wrap{
            background:var(--white);
            border-radius:var(--radius-md);
            padding:34px 30px;
        }
        .faq-wrap h2{font-size:1.35rem;font-weight:500;text-align:center;margin-bottom:22px;}
        .faq-item{border-top:1px solid var(--line);}
        .faq-item:last-child{border-bottom:1px solid var(--line);}
        .faq-q{
            width:100%;text-align:left;
            display:flex;align-items:center;justify-content:space-between;
            padding:16px 2px;
            font-size:.86rem;font-weight:500;
        }
        .faq-q .plus{
            width:18px;height:18px;position:relative;flex-shrink:0;
        }
        .faq-q .plus::before, .faq-q .plus::after{
            content:"";position:absolute;background:var(--ink);
            transition:transform .35s var(--ease), opacity .35s var(--ease);
        }
        .faq-q .plus::before{top:50%;left:0;width:100%;height:1.4px;transform:translateY(-50%);}
        .faq-q .plus::after{left:50%;top:0;height:100%;width:1.4px;transform:translateX(-50%);}
        .faq-item.open .plus::after{opacity:0;transform:translateX(-50%) rotate(90deg);}
        .faq-a{
            max-height:0;overflow:hidden;
            transition:max-height .4s var(--ease), padding .4s var(--ease);
            font-size:.83rem;color:var(--ink-soft);line-height:1.6;
        }
        .faq-item.open .faq-a{max-height:140px;padding-bottom:18px;}

        /* newsletter + footer */
        .newsletter-footer{
            background:var(--ink);
            color:var(--cream);
            border-radius:var(--radius-md) var(--radius-md) 0 0;
            padding:46px 34px 34px;
        }
        .newsletter-footer .nl-title{
            text-align:center;
            margin-bottom:26px;
        }
        .newsletter-footer h2{font-size:1.4rem;font-weight:400;margin-bottom:8px;}
        .newsletter-footer .nl-title p{font-size:.82rem;color:rgba(243,237,228,.6);}
        .nl-form{
            display:flex;
            background:rgba(243,237,228,.08);
            border:1px solid rgba(243,237,228,.2);
            border-radius:999px;
            padding:5px;
            max-width:420px;
            margin:0 auto 44px;
        }
        .nl-form input{
            flex:1;background:transparent;border:none;outline:none;
            color:var(--cream);padding:10px 16px;font-size:.82rem;
        }
        .nl-form input::placeholder{color:rgba(243,237,228,.45);}
        .nl-form button{
            background:var(--gold);color:var(--ink);
            padding:11px 22px;border-radius:999px;
            font-size:.7rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;
            transition:background .3s var(--ease);
            white-space:nowrap;
            border:none;cursor:pointer;
        }
        .nl-form button:hover{background:#dcb579;}

        .foot-grid{
            display:grid;grid-template-columns:1fr 1fr;
            gap:28px 20px;
            padding-top:34px;
            border-top:1px solid rgba(243,237,228,.12);
        }
        .foot-grid > div:first-child{grid-column:1 / -1;}
        .foot-grid .brand{font-family:'Fraunces',serif;font-size:1.3rem;margin-bottom:8px;}
        .foot-grid .tag{font-size:.76rem;color:rgba(243,237,228,.5);line-height:1.5;max-width:280px;}
        .foot-grid h4{font-size:.74rem;text-transform:uppercase;letter-spacing:.08em;margin-bottom:14px;color:rgba(243,237,228,.85);}
        .foot-grid li{margin-bottom:9px;}
        .foot-grid a{font-size:.78rem;color:rgba(243,237,228,.55);transition:color .25s var(--ease);}
        .foot-grid a:hover{color:var(--cream);}
        .foot-bottom{
            display:flex;align-items:center;justify-content:space-between;
            margin-top:34px;padding-top:22px;
            border-top:1px solid rgba(243,237,228,.12);
            font-size:.72rem;color:rgba(243,237,228,.45);
        }
        .socials{display:flex;gap:12px;}
        .socials a{
            width:30px;height:30px;border-radius:50%;
            border:1px solid rgba(243,237,228,.2);
            display:flex;align-items:center;justify-content:center;
            transition:background .3s var(--ease), transform .3s var(--ease);
        }
        .socials a:hover{background:var(--gold);transform:translateY(-3px);color:var(--ink);}
        .socials svg{width:13px;height:13px;}

        /* placeholder box (dipakai saat gambar produk/kategori kosong) */
        .ph-empty{
            width:100%;height:100%;
            display:flex;align-items:center;justify-content:center;
            background:#e7e1d9;color:#b3aa9e;font-size:32px;
        }

        /* ============================================================
           SHOP PAGE
           ============================================================ */
        .shop-wrap{
            max-width:1160px;
            margin:0 auto;
            padding:56px 56px 80px;
        }
        .shop-head{margin-bottom:36px;}
        .shop-eyebrow{
            text-transform:uppercase;letter-spacing:.14em;
            font-size:.72rem;font-weight:600;color:var(--brown);
            margin-bottom:10px;
        }
        .shop-title{
            font-size:2.6rem;font-weight:400;line-height:1.1;
            letter-spacing:-.01em;margin-bottom:12px;
        }
        .shop-subtitle{color:var(--ink-soft);font-size:.95rem;max-width:480px;line-height:1.6;}

        /* ---- filter bar ---- */
        .shop-filter{
            display:flex;
            flex-wrap:wrap;
            gap:12px;
            background:var(--white);
            border:1px solid var(--line);
            border-radius:var(--radius-md);
            padding:14px;
            margin-bottom:14px;
        }
        .shop-field{
            position:relative;
            flex:1 1 220px;
        }
        .shop-field svg{
            position:absolute;left:16px;top:50%;transform:translateY(-50%);
            width:16px;height:16px;color:var(--ink-soft);pointer-events:none;
        }
        .shop-input{
            width:100%;
            padding:13px 16px 13px 42px;
            border:1px solid var(--line);
            border-radius:999px;
            font-size:.85rem;
            background:var(--cream);
            outline:none;
            font-family:inherit;
            color:var(--ink);
            transition:border-color .25s var(--ease), background .25s var(--ease);
        }
        .shop-input:focus{border-color:var(--brown);background:var(--white);}
        .shop-select{
            flex:1 1 160px;
            padding:13px 38px 13px 18px;
            border:1px solid var(--line);
            border-radius:999px;
            font-size:.85rem;
            background:var(--cream) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234a4038' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") right 14px center / 14px no-repeat;
            appearance:none;
            -webkit-appearance:none;
            outline:none;
            font-family:inherit;
            color:var(--ink);
            cursor:pointer;
            transition:border-color .25s var(--ease), background-color .25s var(--ease);
        }
        .shop-select:focus{border-color:var(--brown);background-color:var(--white);}
        .shop-actions{display:flex;gap:10px;flex:0 0 auto;}
        .shop-btn-filter{
            padding:13px 26px;
            border-radius:999px;
            background:var(--ink);
            color:var(--cream);
            font-size:.8rem;font-weight:600;letter-spacing:.02em;
            border:none;cursor:pointer;
            transition:background .25s var(--ease), transform .25s var(--ease);
            white-space:nowrap;
        }
        .shop-btn-filter:hover{background:var(--brown-deep);transform:translateY(-2px);}
        .shop-btn-reset{
            padding:13px 20px;
            border-radius:999px;
            border:1px solid var(--line);
            color:var(--ink-soft);
            font-size:.8rem;font-weight:500;
            white-space:nowrap;
            transition:border-color .25s var(--ease), color .25s var(--ease);
        }
        .shop-btn-reset:hover{border-color:var(--brown);color:var(--brown);}
        .shop-meta{
            font-size:.8rem;color:var(--ink-soft);
            margin-bottom:26px;
        }
        .shop-meta strong{color:var(--ink);font-weight:600;}

        /* ---- product grid ---- */
        .shop-grid{
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(240px,1fr));
            gap:24px;
        }
        .shop-card{
            background:var(--white);
            border-radius:var(--radius-md);
            overflow:hidden;
            border:1px solid var(--line);
            transition:transform .4s var(--ease), box-shadow .4s var(--ease), border-color .4s var(--ease);
        }
        .shop-card:hover{
            transform:translateY(-6px);
            box-shadow:0 24px 50px -20px rgba(30,20,10,.25);
            border-color:transparent;
        }
        .shop-card-thumb{
            height:220px;overflow:hidden;background:var(--cream-2);
            position:relative;
        }
        .shop-card-thumb img{
            width:100%;height:100%;object-fit:cover;
            transition:transform .6s var(--ease);
        }
        .shop-card:hover .shop-card-thumb img{transform:scale(1.07);}
        .shop-card-body{padding:18px 20px 20px;}
        .shop-card-cat{
            font-size:.64rem;text-transform:uppercase;letter-spacing:.09em;
            color:var(--brown);font-weight:700;margin-bottom:6px;
        }
        .shop-card-name{
            font-family:'Fraunces',serif;font-size:1.02rem;font-weight:500;
            line-height:1.3;margin-bottom:8px;
            color:var(--ink);
        }
        .shop-card-price{font-size:1.05rem;font-weight:700;color:var(--ink);}
        .shop-card-cta{
            display:flex;align-items:center;justify-content:center;gap:8px;
            margin-top:14px;
            width:100%;
            padding:12px 18px;
            border-radius:999px;
            background:var(--ink);
            color:var(--cream);
            font-size:.76rem;font-weight:600;letter-spacing:.03em;text-transform:uppercase;
            transition:background .3s var(--ease), gap .3s var(--ease);
        }
        .shop-card-cta svg{width:13px;height:13px;transition:transform .3s var(--ease);}
        .shop-card:hover .shop-card-cta{background:var(--brown-deep);}
        .shop-card:hover .shop-card-cta svg{transform:translateX(4px);}

        /* ---- empty state ---- */
        .shop-empty{
            text-align:center;
            padding:80px 20px;
            background:var(--white);
            border-radius:var(--radius-md);
            border:1px solid var(--line);
        }
        .shop-empty svg{width:38px;height:38px;color:var(--brown);margin-bottom:16px;}
        .shop-empty h3{font-family:'Fraunces',serif;font-size:1.3rem;font-weight:500;margin-bottom:8px;}
        .shop-empty p{color:var(--ink-soft);font-size:.88rem;}

        /* ---- pagination (works with Bootstrap-style & Tailwind-default Laravel paginator) ---- */
        .shop-pagination{
            margin-top:44px;
            display:flex;
            justify-content:center;
        }
        .shop-pagination nav{width:100%;display:flex;justify-content:center;}
        .shop-pagination ul.pagination{
            display:flex;list-style:none;gap:6px;padding:0;margin:0;flex-wrap:wrap;justify-content:center;
        }
        .shop-pagination .page-item .page-link,
        .shop-pagination nav > div > span,
        .shop-pagination nav a{
            display:flex;align-items:center;justify-content:center;
            min-width:38px;height:38px;padding:0 12px;
            border-radius:10px;
            border:1px solid var(--line);
            background:var(--white);
            color:var(--ink);
            font-size:.82rem;font-weight:500;
            text-decoration:none;
            transition:background .25s var(--ease), color .25s var(--ease), border-color .25s var(--ease);
        }
        .shop-pagination .page-item.active .page-link,
        .shop-pagination nav a[aria-current="page"]{
            background:var(--ink);color:var(--cream);border-color:var(--ink);
        }
        .shop-pagination .page-item.disabled .page-link{
            opacity:.4;pointer-events:none;
        }
        .shop-pagination .page-link:hover{border-color:var(--brown);color:var(--brown);}
        .shop-pagination nav > div:first-child{display:none;} /* sembunyikan teks "Showing x to y of z" bawaan tailwind, sudah kita ganti .shop-meta */

        @media (max-width:860px){
            .shop-wrap{padding:40px 24px 60px;}
            .shop-title{font-size:2.1rem;}
            .shop-grid{grid-template-columns:repeat(2,1fr);gap:16px;}
            .shop-card-thumb{height:180px;}
            .shop-filter{flex-direction:column;align-items:stretch;}
            .shop-field, .shop-select{flex:1 1 auto;}
            .shop-actions{width:100%;}
            .shop-btn-filter{flex:1;}
            .shop-btn-reset{flex:1;text-align:center;}
        }

        @media (max-width:480px){
            .shop-wrap{padding:28px 16px 44px;}
            .shop-title{font-size:1.7rem;}
            .shop-subtitle{font-size:.86rem;}
            .shop-grid{grid-template-columns:repeat(2,1fr);gap:10px;}
            .shop-card-thumb{height:130px;}
            .shop-card-body{padding:12px 12px 14px;}
            .shop-card-name{font-size:.82rem;margin-bottom:4px;}
            .shop-card-price{font-size:.88rem;}
            .shop-card-cta{padding:10px 12px;font-size:.68rem;margin-top:10px;}
            .shop-filter{padding:12px;border-radius:18px;}
            .shop-input,.shop-select{padding-top:12px;padding-bottom:12px;font-size:.82rem;}
            .shop-meta{font-size:.74rem;}
        }

        /* ============================================================
           RESPONSIVE
           ============================================================ */
        @media (max-width:1180px){
            .page{grid-template-columns:1fr;}
            .col-main{border-right:none;}
            .col-side{border-top:1px solid var(--line);}
        }

        @media (max-width:860px){
            header.site{padding:22px 24px;}
            nav.main-nav{display:none;}
            .burger{display:flex;}
            section{padding:44px 24px;}
            .col-side section{padding:36px 24px;}
            .hero{margin:0 24px;min-height:420px;}
            .hero-content{padding:0 26px 36px;}
            .why{grid-template-columns:1fr;gap:40px;}
            .why-visual{height:380px;}
            .perk-bar{flex-direction:column;gap:20px;padding:26px;}
            .perk + .perk{border-left:none;border-top:1px solid rgba(243,237,228,.15);padding-top:20px;}
            .cat-grid{grid-template-columns:repeat(2,1fr);}
            .bs-grid{grid-template-columns:repeat(3,1fr);}
            .fc-grid{grid-template-columns:repeat(2,1fr);}
            .foot-grid{grid-template-columns:1fr 1fr;gap:28px;}
            .banner-dark{flex-direction:column;}
            .banner-dark .banner-img{height:180px;}
            .banner-dark .banner-img::before{background:linear-gradient(0deg, var(--ink) 0%, rgba(36,29,22,0) 45%);}
        }

        @media (max-width:480px){
            header.site{padding:16px 16px;}
            .logo{font-size:1.3rem;}
            .cat-grid{grid-template-columns:1fr 1fr;gap:12px;}
            .cat-thumb{height:140px;}
            .bs-grid{grid-template-columns:1fr 1fr;}
            .fc-grid{grid-template-columns:1fr 1fr;}
            .foot-grid{grid-template-columns:1fr;}
            .foot-bottom{flex-direction:column;gap:14px;align-items:flex-start;}
            .hero{min-height:320px;margin:0 16px;}
            .hero-content h1{font-size:1.6rem;}
            .hero-content p{font-size:.85rem;}
            .hero-content .btn{padding:12px 20px;font-size:.75rem;}
            .header-icons{gap:12px;}
            .header-icons button:first-child{display:none;}
            .why-text h2{font-size:1.6rem;}
            .why-visual{height:280px;}
            .col-side section{padding:24px 16px;}
            .faq-wrap{padding:20px 16px;}
            .newsletter-footer{padding:28px 16px 20px;}
            .nl-form{flex-direction:column;border-radius:12px;background:transparent;border:none;gap:10px;padding:0;max-width:100%;}
            .nl-form input{background:rgba(243,237,228,.08);border-radius:999px;padding:12px 16px;border:1px solid rgba(243,237,228,.2);width:100%;}
            .nl-form button{width:100%;justify-content:center;padding:12px;}
            .side-head h2{font-size:1.1rem;}
            .side-head-title{font-size:1.1rem;}
            .banner-text h3{font-size:1.1rem;}
        }

        @media (prefers-reduced-motion: reduce){
            *{animation-duration:.01ms !important; animation-iteration-count:1 !important; transition-duration:.01ms !important;}
        }
    </style>
</head>
<body>

<div class="page">

    <!-- ================= MAIN COLUMN ================= -->
    <div class="col-main">

        <!-- HEADER -->
        <header class="site">
            <a href="{{ route('home') }}" class="logo">Anti</a>
            <nav class="main-nav">
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('shop') }}">Collections</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('lookbook') }}">Lookbook</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </nav>
            <div class="header-icons">
                <button aria-label="Search" onclick="showToast('Search feature coming soon')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </button>
                <a href="{{ route('login') }}" aria-label="Account">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                </a>
                <div class="cart-wrap">
                    <a href="{{ route('cart') }}" aria-label="Cart">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M6 6h15l-1.5 9h-12z"/><path d="M6 6L4 3H2"/><circle cx="9" cy="20" r="1.4"/><circle cx="18" cy="20" r="1.4"/></svg>
                    </a>
                    <span class="cart-badge" id="cartBadge">0</span>
                </div>
                <button class="burger" id="burgerBtn" aria-label="Menu" aria-expanded="false" onclick="toggleMobileMenu()">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </header>

        <!-- MOBILE MENU -->
        <div class="mobile-menu" id="mobileMenu">
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('shop') }}">Collections</a></li>
                <li><a href="{{ route('about') }}">About Us</a></li>
                <li><a href="{{ route('lookbook') }}">Lookbook</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
                @auth
                    <li><a href="{{ route('orders.index') }}">My Orders</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}" style="color:var(--brown);font-weight:600;">Register</a></li>
                @endauth
            </ul>
        </div>

        <!-- MAIN CONTENT -->
        @yield('content')

    </div>

    <!-- ================= SIDEBAR COLUMN ================= -->
    <div class="col-side">
        @yield('sidebar')
    </div>

</div>

<!-- TOAST -->
<div class="toast" id="toast"></div>

<script>
    // ============================================================
    // TOAST
    // ============================================================
    function showToast(message) {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.classList.add('show');
        clearTimeout(toast._timeout);
        toast._timeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 2800);
    }

    // ============================================================
    // MOBILE MENU
    // ============================================================
    const mobileMenu = document.getElementById('mobileMenu');
    const burgerBtn = document.getElementById('burgerBtn');

    function toggleMobileMenu() {
        const willOpen = !mobileMenu.classList.contains('open');
        mobileMenu.classList.toggle('open', willOpen);
        burgerBtn.classList.toggle('open', willOpen);
        burgerBtn.setAttribute('aria-expanded', willOpen);
    }

    // tutup menu otomatis kalau salah satu link/tombol di dalamnya diklik
    mobileMenu.querySelectorAll('a, button').forEach(el => {
        el.addEventListener('click', () => {
            mobileMenu.classList.remove('open');
            burgerBtn.classList.remove('open');
            burgerBtn.setAttribute('aria-expanded', false);
        });
    });

    // ============================================================
    // SCROLL REVEAL
    // ============================================================
    const revealEls = document.querySelectorAll('.reveal, .reveal-stagger');
    const io = new IntersectionObserver((entries)=>{
        entries.forEach(e=>{
            if(e.isIntersecting){
                e.target.classList.add('in');
                io.unobserve(e.target);
            }
        });
    }, {threshold:.15});
    revealEls.forEach(el=>io.observe(el));
</script>

@stack('scripts')
</body>
</html>
