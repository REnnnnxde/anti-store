@extends('layouts.admin')

@section('content')
<style>
    /* ============================================================
       PREMIUM DASHBOARD - ANTI FASHION
    ============================================================ */

    /* ---- STATS GRID ---- */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 22px 24px;
        border: 1px solid #f0edea;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 48px rgba(26,20,16,0.06);
        border-color: #e7e1d9;
    }

    .stat-card .stat-icon {
        font-size: 22px;
        color: #b3aa9e;
        float: right;
        margin-top: 2px;
    }

    .stat-card .stat-number {
        font-size: 30px;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
        color: #1a1410;
        line-height: 1.1;
        margin-bottom: 2px;
    }

    .stat-card .stat-label {
        font-size: 12px;
        color: #817a72;
        font-weight: 500;
    }

    .stat-card .stat-change {
        font-size: 11px;
        font-weight: 600;
        margin-top: 10px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 12px;
        border-radius: 20px;
    }

    .stat-card .stat-change.up { background: #e6f0ea; color: #2d7a5a; }
    .stat-card .stat-change.down { background: #f5e8e6; color: #a64d47; }
    .stat-card .stat-change.neutral { background: #f0edea; color: #817a72; }

    .stat-card .stat-bar {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
    }

    .stat-card:nth-child(1) .stat-bar { background: #3b6ea5; }
    .stat-card:nth-child(2) .stat-bar { background: #2d7a5a; }
    .stat-card:nth-child(3) .stat-bar { background: #b8954a; }
    .stat-card:nth-child(4) .stat-bar { background: #7a5a9e; }

    /* ---- DASHBOARD GRID ---- */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }

    /* ---- CARD ---- */
    .card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #f0edea;
        transition: all 0.3s ease;
    }

    .card:hover {
        border-color: #e7e1d9;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .card-title {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #817a72;
    }

    .card-link {
        font-size: 11px;
        color: #9b7654;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: gap 0.3s ease;
    }

    .card-link:hover { gap: 10px; }
    .card-link .arrow { font-size: 14px; line-height: 1; }

    /* ---- ORDER ITEMS ---- */
    .order-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f6f3ee;
        transition: background 0.2s ease;
    }

    .order-item:last-child { border-bottom: none; }

    .order-item .order-info {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .order-item .order-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #f1e9df;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
        color: #9b7654;
        flex-shrink: 0;
    }

    .order-item .order-name {
        font-weight: 600;
        font-size: 13px;
        color: #1a1410;
    }

    .order-item .order-date {
        font-size: 11px;
        color: #817a72;
    }

    .order-item .order-amount {
        font-weight: 700;
        font-size: 14px;
        color: #1a1410;
    }

    .status-badge {
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        display: inline-block;
        margin-top: 3px;
    }

    .status-badge.pending { background: #fff0d9; color: #986723; }
    .status-badge.processing { background: #e8edf5; color: #3b6ea5; }
    .status-badge.shipped { background: #e6f0ea; color: #2d7a5a; }
    .status-badge.delivered { background: #e6f0ea; color: #2d7a5a; }
    .status-badge.cancelled { background: #f5e8e6; color: #a64d47; }

    /* ---- ACTIVITY ---- */
    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 10px 0;
        border-bottom: 1px solid #f6f3ee;
    }

    .activity-item:last-child { border-bottom: none; }

    .activity-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-top: 6px;
        flex-shrink: 0;
    }

    .activity-dot.green { background: #2d7a5a; }
    .activity-dot.gold { background: #b8954a; }
    .activity-dot.blue { background: #3b6ea5; }
    .activity-dot.red { background: #a64d47; }

    .activity-text {
        font-size: 12px;
        color: #4a4038;
        line-height: 1.5;
    }

    .activity-text strong { color: #1a1410; }

    .activity-time {
        font-size: 10px;
        color: #817a72;
        margin-top: 2px;
    }

    /* ---- PRODUCT ITEMS ---- */
    .product-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 10px 0;
        border-bottom: 1px solid #f6f3ee;
    }

    .product-item:last-child { border-bottom: none; }

    .product-item .product-img {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        object-fit: cover;
        background: #f6f3ee;
        flex-shrink: 0;
    }

    .product-item .product-img.placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d4c9be;
        font-size: 18px;
    }

    .product-item .product-name {
        font-weight: 600;
        font-size: 13px;
        color: #1a1410;
    }

    .product-item .product-price {
        font-size: 12px;
        color: #9b7654;
        font-weight: 600;
    }

    .product-item .product-stock {
        font-size: 11px;
        color: #817a72;
        margin-left: auto;
        white-space: nowrap;
    }

    /* ---- QUICK ACTION ---- */
    .quick-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 12px;
    }

    .quick-btn {
        padding: 16px 12px;
        border-radius: 12px;
        border: 1px solid #f0edea;
        background: #fff;
        text-align: center;
        text-decoration: none;
        color: #1a1410;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .quick-btn:hover {
        background: #faf8f5;
        border-color: #9b7654;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(26,20,16,0.04);
    }

    .quick-btn .icon-wrap {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #f1e9df;
        color: #9b7654;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .quick-btn .label {
        font-size: 11px;
        font-weight: 600;
        color: #1a1410;
    }

    /* ---- REVENUE CARD ---- */
    .revenue-card {
        margin-top: 20px;
        background: linear-gradient(145deg, #1a1410 0%, #2d2520 100%);
        color: #fff;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .revenue-card .revenue-bg {
        position: absolute;
        top: -40%;
        right: -20%;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(155,118,84,0.06);
        pointer-events: none;
    }

    .revenue-card .revenue-bg-2 {
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(155,118,84,0.04);
        pointer-events: none;
    }

    .revenue-card .revenue-eyebrow {
        font-size: 10px;
        color: #918a82;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        font-weight: 600;
        position: relative;
        z-index: 1;
    }

    .revenue-card .revenue-amount {
        font-size: 32px;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
        margin-top: 4px;
        position: relative;
        z-index: 1;
    }

    .revenue-card .revenue-delta {
        font-size: 12px;
        color: #d3b06a;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
        position: relative;
        z-index: 1;
    }

    .revenue-card .revenue-meta {
        margin-top: 18px;
        display: flex;
        justify-content: space-between;
        border-top: 1px solid rgba(255,255,255,0.06);
        padding-top: 16px;
        position: relative;
        z-index: 1;
    }

    .revenue-card .revenue-meta-item { text-align: left; }

    .revenue-card .revenue-meta-label {
        font-size: 9px;
        color: #918a82;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .revenue-card .revenue-meta-value {
        font-size: 16px;
        font-weight: 700;
        margin-top: 2px;
    }

    /* ---- EMPTY STATE ---- */
    .empty-state {
        text-align: center;
        padding: 24px 10px;
        color: #817a72;
        font-size: 13px;
    }

    .empty-state a { color: #9b7654; font-weight: 600; text-decoration: none; }
    .empty-state a:hover { text-decoration: underline; }

    /* ---- TOAST ---- */
    .toast {
        position: fixed;
        right: 28px;
        bottom: 28px;
        background: #1a1410;
        color: #fff;
        padding: 14px 22px;
        border-radius: 12px;
        font-size: 12px;
        z-index: 50;
        opacity: 0;
        transform: translateY(16px);
        transition: all 0.4s ease;
        box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    }

    .toast.show {
        opacity: 1;
        transform: translateY(0);
    }

    /* ---- RESPONSIVE ---- */
    @media (max-width: 1024px) {
        .dashboard-grid { grid-template-columns: 1fr; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 640px) {
        .stats-grid { grid-template-columns: 1fr; }
        .quick-grid { grid-template-columns: 1fr; }
        .revenue-card .revenue-meta { flex-wrap: wrap; gap: 14px; }
    }
</style>

<!-- ============================================================ -->
<!-- HEADING -->
<!-- ============================================================ -->
<div style="margin-bottom:24px;">
    <div style="font-size:10px;text-transform:uppercase;letter-spacing:0.16em;color:#9b7654;font-weight:700;">Overview</div>
    <h1 style="font-size:30px;font-weight:500;font-family:'Playfair Display',serif;margin:4px 0 2px;color:#1a1410;">Dashboard</h1>
    <p style="font-size:13px;color:#817a72;margin:0;">Ringkasan data toko Anti Fashion.</p>
</div>

<!-- ============================================================ -->
<!-- STATS -->
<!-- ============================================================ -->
<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-icon">▦</span>
        <div class="stat-number">{{ $total_products ?? 0 }}</div>
        <div class="stat-label">Total Produk</div>
        <span class="stat-change up">↑ 12% bulan ini</span>
        <div class="stat-bar"></div>
    </div>
    <div class="stat-card">
        <span class="stat-icon">◫</span>
        <div class="stat-number">{{ $total_orders ?? 0 }}</div>
        <div class="stat-label">Total Pesanan</div>
        <span class="stat-change up">↑ 8% bulan ini</span>
        <div class="stat-bar"></div>
    </div>
    <div class="stat-card">
        <span class="stat-icon">♙</span>
        <div class="stat-number">{{ $total_users ?? 0 }}</div>
        <div class="stat-label">Total Pengguna</div>
        <span class="stat-change up">↑ 5% bulan ini</span>
        <div class="stat-bar"></div>
    </div>
    <div class="stat-card">
        <span class="stat-icon">◈</span>
        <div class="stat-number">{{ $total_categories ?? 0 }}</div>
        <div class="stat-label">Total Kategori</div>
        <span class="stat-change neutral">– Stabil</span>
        <div class="stat-bar"></div>
    </div>
</div>

<!-- ============================================================ -->
<!-- DASHBOARD GRID -->
<!-- ============================================================ -->
<div class="dashboard-grid">

    <!-- ===== KOLOM KIRI ===== -->
    <div>

        <!-- PESANAN TERBARU -->
        <div class="card">
            <div class="card-header">
                <span class="card-title">Pesanan Terbaru</span>
                <a href="{{ route('admin.orders.index') }}" class="card-link">
                    Lihat Semua <span class="arrow">→</span>
                </a>
            </div>
            @php
                $orders = \App\Models\Order::with('user')->latest()->take(5)->get();
            @endphp
            @if($orders->count() > 0)
                @foreach($orders as $order)
                <div class="order-item">
                    <div class="order-info">
                        <div class="order-avatar">{{ strtoupper(substr($order->user->name ?? 'U', 0, 2)) }}</div>
                        <div>
                            <div class="order-name">{{ $order->user->name ?? 'Unknown' }}</div>
                            <div class="order-date">{{ $order->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    <div style="text-align:right;">
                        <div class="order-amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                        <span class="status-badge {{ $order->status }}">{{ $order->status }}</span>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state">Belum ada pesanan.</div>
            @endif
        </div>

        <!-- PRODUK TERBARU -->
        <div class="card" style="margin-top:20px;">
            <div class="card-header">
                <span class="card-title">Produk Terbaru</span>
                <a href="{{ route('admin.products.index') }}" class="card-link">
                    Lihat Semua <span class="arrow">→</span>
                </a>
            </div>
            <div class="recent-products">
                @php
                    $recentProducts = \App\Models\Product::with('category')->latest()->take(4)->get();
                @endphp
                @forelse($recentProducts as $product)
                <div class="product-item">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="product-img" alt="{{ $product->name }}">
                    @else
                        <div class="product-img placeholder">◈</div>
                    @endif
                    <div>
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    </div>
                    <div class="product-stock">{{ $product->stock }} pcs</div>
                </div>
                @empty
                <div class="empty-state">
                    Belum ada produk. <a href="{{ route('admin.products.create') }}">Tambah sekarang</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- ===== KOLOM KANAN ===== -->
    <div>

        <!-- AKTIVITAS -->
        <div class="card">
            <div class="card-header">
                <span class="card-title">Aktivitas Terbaru</span>
            </div>
            @php
                $activities = [];
                $latestProduct = \App\Models\Product::latest()->first();
                if ($latestProduct) {
                    $activities[] = [
                        'text' => '<strong>System</strong> menambahkan produk <strong>' . $latestProduct->name . '</strong>',
                        'time' => $latestProduct->created_at->diffForHumans(),
                        'dot' => 'green'
                    ];
                }
                $latestOrder = \App\Models\Order::latest()->first();
                if ($latestOrder) {
                    $activities[] = [
                        'text' => '<strong>System</strong> pesanan baru <strong>#' . $latestOrder->order_number . '</strong>',
                        'time' => $latestOrder->created_at->diffForHumans(),
                        'dot' => 'blue'
                    ];
                }
                if (empty($activities)) {
                    $activities = [
                        ['text' => '<strong>System</strong> mulai berjalan', 'time' => 'Baru saja', 'dot' => 'green'],
                        ['text' => '<strong>Admin</strong> siap mengelola', 'time' => 'Baru saja', 'dot' => 'gold'],
                    ];
                }
            @endphp
            @foreach($activities as $activity)
            <div class="activity-item">
                <div class="activity-dot {{ $activity['dot'] }}"></div>
                <div>
                    <div class="activity-text">{!! $activity['text'] !!}</div>
                    <div class="activity-time">{{ $activity['time'] }}</div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- QUICK ACTION -->
        <div class="card" style="margin-top:20px;">
            <div class="card-header">
                <span class="card-title">Aksi Cepat</span>
            </div>
            <div class="quick-grid">
                <a href="{{ route('admin.products.create') }}" class="quick-btn">
                    <span class="icon-wrap">+</span>
                    <span class="label">Tambah Produk</span>
                </a>
                <a href="{{ route('admin.categories.create') }}" class="quick-btn">
                    <span class="icon-wrap">◈</span>
                    <span class="label">Tambah Kategori</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="quick-btn">
                    <span class="icon-wrap">♙</span>
                    <span class="label">Kelola User</span>
                </a>
     <a href="#" class="quick-btn">
            <span class="icon-wrap">$</span>
            <span class="label">Laporan</span>
        </a>
            </div>
        </div>

        <!-- REVENUE -->
        <div class="card revenue-card">
            <div class="revenue-bg"></div>
            <div class="revenue-bg-2"></div>
            @php
                $totalRevenue = \App\Models\Order::whereMonth('created_at', date('m'))
                    ->whereYear('created_at', date('Y'))
                    ->sum('total_amount');
                $totalOrders = \App\Models\Order::whereMonth('created_at', date('m'))
                    ->whereYear('created_at', date('Y'))
                    ->count();
                $avgOrder = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
                $uniqueCustomers = \App\Models\Order::whereMonth('created_at', date('m'))
                    ->whereYear('created_at', date('Y'))
                    ->distinct('user_id')
                    ->count('user_id');
            @endphp
            <div class="revenue-eyebrow">Pendapatan Bulan Ini</div>
            <div class="revenue-amount">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <div class="revenue-delta">↑ Dari {{ $totalOrders }} pesanan</div>

            <div class="revenue-meta">
                <div class="revenue-meta-item">
                    <div class="revenue-meta-label">Pesanan</div>
                    <div class="revenue-meta-value">{{ $totalOrders }}</div>
                </div>
                <div class="revenue-meta-item">
                    <div class="revenue-meta-label">Rata-rata</div>
                    <div class="revenue-meta-value">Rp {{ number_format($avgOrder, 0, ',', '.') }}</div>
                </div>
                <div class="revenue-meta-item">
                    <div class="revenue-meta-label">Pelanggan</div>
                    <div class="revenue-meta-value">{{ $uniqueCustomers }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- TOAST -->
<!-- ============================================================ -->
<div class="toast" id="toast"></div>

<script>
function showToast(message) {
    let toast = document.getElementById('toast');
    toast.textContent = message;
    toast.classList.add('show');
    setTimeout(() => {
        toast.classList.remove('show');
    }, 2800);
}

@if(session('success'))
    showToast('{{ session('success') }}');
@endif
</script>
@endsection
