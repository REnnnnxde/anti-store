<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Anti Fashion — Admin</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600&display=swap');
        :root{--bg:#f6f3ee;--panel:#fff;--ink:#25211e;--muted:#817a72;--line:#e7e1d9;--accent:#9b7654;--dark:#28231f;--green:#397052;--red:#a64d47}
        *{box-sizing:border-box}
        body{margin:0;background:var(--bg);color:var(--ink);font-family:"DM Sans",sans-serif}
        button,input,select,textarea{font:inherit}
        button{cursor:pointer}
        .layout{display:flex;min-height:100vh}
        .sidebar{width:250px;background:#25211e;color:#eee8df;position:fixed;inset:0 auto 0 0;padding:25px 18px}
        .brand{font:600 25px "Playfair Display";padding:8px 13px 30px}
        .brand small{display:block;font:500 10px "DM Sans";letter-spacing:.18em;color:#a9a198;margin-top:5px}
        .nav-title{font-size:10px;text-transform:uppercase;letter-spacing:.14em;color:#777069;padding:16px 13px 8px}
        .nav a{display:flex;gap:12px;color:#c9c1b8;text-decoration:none;padding:12px 13px;border-radius:10px;font-size:13px}
        .nav a.active,.nav a:hover{background:#3a342f;color:#fff}
        .icon{width:20px;text-align:center}
        .admin{position:absolute;bottom:18px;left:18px;right:18px;border-top:1px solid #3b3631;padding:16px 10px;display:flex;gap:10px;align-items:center}
        .avatar{width:34px;height:34px;border-radius:50%;background:#9b7654;display:grid;place-items:center;font-size:12px;font-weight:700}
        .admin b{font-size:12px}
        .admin span{display:block;font-size:10px;color:#918a82}
        .main{margin-left:250px;width:calc(100% - 250px)}
        .topbar{height:76px;background:#ffffffe8;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;padding:0 34px;position:sticky;top:0;z-index:5;backdrop-filter:blur(14px)}
        .crumb{font-size:12px;color:var(--muted)}
        .crumb b{color:var(--ink)}
        .top-actions{display:flex;gap:9px}
        .icon-btn{border:1px solid var(--line);background:#fff;width:38px;height:38px;border-radius:10px}
        .content{padding:32px 34px;max-width:1500px;margin:auto}
        .heading{display:flex;justify-content:space-between;align-items:end;margin-bottom:25px}
        .eyebrow{font-size:10px;text-transform:uppercase;letter-spacing:.16em;color:var(--accent);font-weight:700}
        .heading h1{font:500 36px "Playfair Display";margin:7px 0}
        .heading p{margin:0;color:var(--muted);font-size:13px}
        .primary{border:0;background:var(--dark);color:#fff;border-radius:11px;padding:13px 18px;font-size:12px;font-weight:700}
        .stats{display:grid;grid-template-columns:repeat(4,1fr);gap:15px;margin-bottom:24px}
        .stat{background:#fff;border:1px solid var(--line);border-radius:15px;padding:18px;box-shadow:0 18px 50px #231c1510}
        .stat-top{display:flex;justify-content:space-between;color:var(--muted);font-size:11px}
        .stat-icon{width:32px;height:32px;border-radius:9px;background:#f1e9df;display:grid;place-items:center}
        .stat strong{display:block;font-size:25px;margin-top:13px}
        .stat small{font-size:10px;color:var(--green)}
        .toolbar{background:#fff;border:1px solid var(--line);border-radius:15px 15px 0 0;padding:15px;display:flex;gap:10px;justify-content:space-between}
        .filters{display:flex;gap:9px;flex:1}
        .search{max-width:340px;flex:1;position:relative}
        .search input{width:100%;padding:11px 13px 11px 36px;border:1px solid var(--line);border-radius:9px;background:#faf8f5;outline:0;font-size:12px}
        .search span{position:absolute;left:13px;top:10px;color:var(--muted)}
        select,.filter-btn{border:1px solid var(--line);background:#faf8f5;border-radius:9px;padding:10px 12px;font-size:11px}
        .table-wrap{background:#fff;border:1px solid var(--line);border-top:0;border-radius:0 0 15px 15px;overflow:auto}
        table{width:100%;border-collapse:collapse;min-width:850px}
        th{text-align:left;padding:13px 17px;background:#fbf9f6;color:#8b837b;font-size:10px;text-transform:uppercase;letter-spacing:.08em}
        td{padding:13px 17px;border-top:1px solid var(--line);font-size:12px}
        .badge{display:inline-flex;padding:5px 9px;border-radius:99px;font-size:9px;font-weight:700}
        .in{background:#e7f2ea;color:#397052}
        .low{background:#fff0d9;color:#986723}
        .out{background:#f7e3e2;color:#a64d47}
        .actions{display:flex;gap:5px}
        .action{width:30px;height:30px;border:1px solid var(--line);border-radius:8px;background:#fff}
        .danger{color:var(--red)}
        .footer-table{padding:14px 17px;display:flex;justify-content:space-between;color:var(--muted);font-size:10px}
        .toast{position:fixed;right:25px;bottom:25px;background:#25211e;color:#fff;padding:13px 17px;border-radius:11px;font-size:11px;z-index:50;opacity:0;transform:translateY(20px);transition:.3s}
        .toast.show{opacity:1;transform:none}
        @media(max-width:900px){.sidebar{width:70px;padding:20px 10px}.brand{font-size:0;text-align:center}.brand:before{content:"AF";font:600 18px "Playfair Display"}.brand small,.nav-title,.nav a span:not(.icon),.admin div:not(.avatar){display:none}.nav a{justify-content:center}.main{margin-left:70px;width:calc(100% - 70px)}.stats{grid-template-columns:1fr 1fr}}
        @media(max-width:650px){.content{padding:22px 15px}.heading{align-items:start;gap:15px;flex-direction:column}.stats{grid-template-columns:1fr 1fr}.toolbar,.filters{flex-direction:column}.search{max-width:none}}
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="brand">ANTI FASHION<small>Admin Studio</small></div>
        <div class="nav-title">Main Menu</div>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="icon">⌂</span><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <span class="icon">◈</span><span>Kategori</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <span class="icon">▦</span><span>Produk</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <span class="icon">◫</span><span>Pesanan</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <span class="icon">♙</span><span>Pelanggan</span>
            </a>
            <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
    <span class="icon">◉</span><span>Laporan</span>
</a>
        </nav>
        <div class="nav-title">System</div>
        <nav class="nav">
            <a href="#"><span class="icon">⚙</span><span>Pengaturan</span></a>
        </nav>
        <div class="admin">
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
            <div>
                <b>{{ Auth::user()->name }}</b>
                <span>Administrator</span>
            </div>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="main">
        <!-- TOPBAR -->


        <!-- CONTENT -->
        <section class="content">
            @if(session('success'))
                <div style="background:#e7f2ea;color:#397052;padding:12px 18px;border-radius:10px;margin-bottom:20px;font-size:13px;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background:#f7e3e2;color:#a64d47;padding:12px 18px;border-radius:10px;margin-bottom:20px;font-size:13px;">
                    {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </section>
    </main>
</div>

<!-- TOAST -->
<div class="toast" id="toast"></div>

<script>
    function toast(t){
        let x = document.getElementById("toast");
        x.textContent = t;
        x.classList.add("show");
        setTimeout(()=>x.classList.remove("show"), 2200);
    }
</script>

@stack('scripts')
</body>
</html>
