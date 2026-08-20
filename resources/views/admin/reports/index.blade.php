@extends('layouts.admin')

@section('content')
<style>
    /* ============================================================
       PREMIUM REPORTS - ANTI FASHION
    ============================================================ */

    /* ---- HEADING ---- */
    .heading-premium {
        margin-bottom: 28px;
    }
    .heading-premium .eyebrow {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.16em;
        color: #9b7654;
        font-weight: 700;
    }
    .heading-premium h1 {
        font-size: 30px;
        font-weight: 500;
        font-family: 'Playfair Display', serif;
        margin: 4px 0 2px;
        color: #1a1410;
    }
    .heading-premium p {
        font-size: 13px;
        color: #817a72;
        margin: 0;
    }

    /* ---- STATS ---- */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 18px 22px;
        border: 1px solid #f0edea;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(26,20,16,0.05);
        border-color: #e7e1d9;
    }

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

    .stat-card .stat-icon { font-size: 18px; color: #b3aa9e; float: right; }
    .stat-card .stat-number {
        font-size: 24px;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
        color: #1a1410;
        line-height: 1.2;
    }
    .stat-card .stat-label {
        font-size: 12px;
        color: #817a72;
        margin-top: 4px;
    }

    /* ---- FILTER ---- */
    .filter-section {
        background: #fff;
        border-radius: 14px;
        padding: 18px 24px;
        margin-bottom: 28px;
        border: 1px solid #f0edea;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .filter-section .filter-left {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-section .filter-left select,
    .filter-section .filter-left input {
        padding: 9px 14px;
        border: 1px solid #e7e1d9;
        border-radius: 10px;
        font-size: 13px;
        background: #faf8f5;
        color: #1a1410;
        outline: none;
        font-family: inherit;
        transition: all 0.3s;
    }

    .filter-section .filter-left select:focus,
    .filter-section .filter-left input:focus {
        border-color: #9b7654;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(155,118,84,0.08);
    }

    .filter-section .filter-left select {
        min-width: 130px;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M6 8L1 3h10z' fill='%23817a72'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 36px;
    }

    .filter-section .filter-left input[type="date"] {
        min-width: 150px;
    }

    .filter-section .filter-left .btn-filter {
        padding: 9px 20px;
        border: none;
        border-radius: 10px;
        background: #1a1410;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-family: inherit;
    }

    .filter-section .filter-left .btn-filter:hover {
        background: #3a342f;
        transform: translateY(-1px);
    }

    .filter-section .filter-left .btn-reset {
        padding: 9px 18px;
        border: 1px solid #e7e1d9;
        border-radius: 10px;
        background: #faf8f5;
        font-size: 13px;
        font-weight: 500;
        color: #817a72;
        cursor: pointer;
        transition: all 0.3s;
        font-family: inherit;
    }

    .filter-section .filter-left .btn-reset:hover {
        background: #f6f3ee;
        border-color: #9b7654;
        color: #1a1410;
    }

    .filter-section .filter-right {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .filter-section .filter-right .btn-export {
        padding: 9px 20px;
        border: 1px solid #e7e1d9;
        border-radius: 10px;
        background: #fff;
        font-size: 13px;
        font-weight: 600;
        color: #1a1410;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        font-family: inherit;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .filter-section .filter-right .btn-export:hover {
        background: #f6f3ee;
        border-color: #9b7654;
    }

    /* ---- CHART ---- */
    .chart-container {
        background: #fff;
        border-radius: 14px;
        padding: 24px;
        border: 1px solid #f0edea;
        margin-bottom: 20px;
    }

    .chart-container .chart-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #817a72;
        margin-bottom: 16px;
    }

    .chart-bars {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        height: 180px;
        gap: 8px;
        padding-bottom: 28px;
        position: relative;
    }

    .chart-bars .bar-wrap {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
        justify-content: flex-end;
        gap: 6px;
    }

    .chart-bars .bar {
        width: 100%;
        max-width: 40px;
        border-radius: 6px 6px 0 0;
        background: #e7e1d9;
        transition: all 0.6s ease;
        position: relative;
        min-height: 4px;
    }

    .chart-bars .bar:hover {
        opacity: 0.8;
        transform: scaleY(1.02);
        transform-origin: bottom;
    }

    .chart-bars .bar-wrap .bar-value {
        font-size: 10px;
        font-weight: 600;
        color: #1a1410;
    }

    .chart-bars .bar-wrap .bar-label {
        font-size: 10px;
        color: #817a72;
        margin-top: 4px;
    }

    /* ---- GRID 2 KOLOM ---- */
    .reports-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .report-card {
        background: #fff;
        border-radius: 14px;
        padding: 20px 24px;
        border: 1px solid #f0edea;
        transition: all 0.3s ease;
    }

    .report-card:hover {
        border-color: #e7e1d9;
    }

    .report-card .card-title {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #817a72;
        margin-bottom: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .report-card .card-title .badge-count {
        font-size: 10px;
        background: #f1e9df;
        color: #9b7654;
        padding: 2px 10px;
        border-radius: 20px;
        font-weight: 600;
    }

    /* ---- STATUS STATS ---- */
    .status-stats {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
    }

    .status-item {
        text-align: center;
        padding: 12px 8px;
        border-radius: 10px;
        background: #faf8f5;
        border: 1px solid #f0edea;
        transition: all 0.3s ease;
    }

    .status-item:hover {
        background: #f6f3ee;
        border-color: #e7e1d9;
    }

    .status-item .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-bottom: 4px;
    }

    .status-item .status-dot.pending { background: #986723; }
    .status-item .status-dot.processing { background: #3b6ea5; }
    .status-item .status-dot.shipped { background: #2d7a5a; }
    .status-item .status-dot.delivered { background: #2d7a5a; }
    .status-item .status-dot.cancelled { background: #a64d47; }

    .status-item .status-count {
        font-size: 18px;
        font-weight: 700;
        color: #1a1410;
        font-family: 'Playfair Display', serif;
    }

    .status-item .status-label {
        font-size: 9px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #817a72;
        font-weight: 600;
    }

    /* ---- TOP PRODUCT ---- */
    .top-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f6f3ee;
    }

    .top-item:last-child {
        border-bottom: none;
    }

    .top-item .rank {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #f1e9df;
        color: #9b7654;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 11px;
        flex-shrink: 0;
    }

    .top-item .rank.gold { background: #f5efe5; color: #b8954a; }
    .top-item .rank.silver { background: #f0edea; color: #817a72; }
    .top-item .rank.bronze { background: #f5e8e6; color: #a64d47; }

    .top-item .top-img {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        object-fit: cover;
        background: #f0edea;
        flex-shrink: 0;
    }

    .top-item .top-img.placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d4c9be;
        font-size: 16px;
    }

    .top-item .top-info {
        flex: 1;
    }

    .top-item .top-info .top-name {
        font-weight: 600;
        font-size: 13px;
        color: #1a1410;
    }

    .top-item .top-info .top-meta {
        font-size: 11px;
        color: #817a72;
    }

    .top-item .top-value {
        text-align: right;
    }

    .top-item .top-value .top-number {
        font-weight: 700;
        font-size: 14px;
        color: #1a1410;
    }

    .top-item .top-value .top-label {
        font-size: 10px;
        color: #817a72;
    }

    /* ---- TABLE ---- */
    .table-wrap {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #f0edea;
        overflow: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 700px;
    }

    th {
        text-align: left;
        padding: 12px 18px;
        background: #fbf9f6;
        color: #817a72;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 700;
    }

    td {
        padding: 12px 18px;
        border-top: 1px solid #f6f3ee;
        font-size: 13px;
        vertical-align: middle;
    }

    .footer-table {
        padding: 14px 18px;
        display: flex;
        justify-content: space-between;
        color: #817a72;
        font-size: 11px;
        border-top: 1px solid #f6f3ee;
    }

    .badge-status {
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: inline-block;
    }

    .badge-status.pending { background: #fff0d9; color: #986723; }
    .badge-status.processing { background: #e8edf5; color: #3b6ea5; }
    .badge-status.shipped { background: #e6f0ea; color: #2d7a5a; }
    .badge-status.delivered { background: #e6f0ea; color: #2d7a5a; }
    .badge-status.cancelled { background: #f7e3e2; color: #a64d47; }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #817a72;
    }

    .empty-state .icon { font-size: 40px; color: #d4c9be; margin-bottom: 12px; }
    .empty-state h3 { font-size: 17px; font-weight: 500; color: #1a1410; margin: 0 0 4px; font-family: 'Playfair Display', serif; }
    .empty-state p { font-size: 13px; margin: 0; }

    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .reports-grid { grid-template-columns: 1fr; }
        .status-stats { grid-template-columns: repeat(3, 1fr); }
    }

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .filter-section { flex-direction: column; align-items: stretch; }
        .filter-section .filter-left { flex-direction: column; }
        .filter-section .filter-left select,
        .filter-section .filter-left input { width: 100%; }
        .filter-section .filter-right { justify-content: stretch; }
        .filter-section .filter-right .btn-export { flex: 1; justify-content: center; }
        .chart-bars { height: 120px; }
        .status-stats { grid-template-columns: repeat(2, 1fr); }
        th, td { padding: 8px 12px; font-size: 12px; }
    }
</style>

<!-- ============================================================ -->
<!-- HEADING -->
<!-- ============================================================ -->
<div class="heading-premium">
    <div class="eyebrow">Analytics & Reports</div>
    <h1>Laporan</h1>
    <p>Analisis lengkap data penjualan dan performa toko.</p>
</div>

<!-- ============================================================ -->
<!-- STATS -->
<!-- ============================================================ -->
<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-icon">◫</span>
        <div class="stat-number">{{ number_format($totalOrders) }}</div>
        <div class="stat-label">Total Pesanan</div>
        <div class="stat-bar"></div>
    </div>
    <div class="stat-card">
        <span class="stat-icon">$</span>
        <div class="stat-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <div class="stat-label">Total Pendapatan</div>
        <div class="stat-bar"></div>
    </div>
    <div class="stat-card">
        <span class="stat-icon">◉</span>
        <div class="stat-number">Rp {{ number_format($averageOrder, 0, ',', '.') }}</div>
        <div class="stat-label">Rata-rata Pesanan</div>
        <div class="stat-bar"></div>
    </div>
    <div class="stat-card">
        <span class="stat-icon">♙</span>
        <div class="stat-number">{{ $totalCustomers }}</div>
        <div class="stat-label">Pelanggan Unik</div>
        <div class="stat-bar"></div>
    </div>
</div>

<!-- ============================================================ -->
<!-- FILTER -->
<!-- ============================================================ -->
<div class="filter-section">
    <div class="filter-left">
        <form action="{{ route('admin.reports.index') }}" method="GET" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
            <select name="period">
                <option value="today" {{ $period == 'today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="this_week" {{ $period == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="this_month" {{ $period == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="last_month" {{ $period == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
                <option value="this_year" {{ $period == 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
                <option value="custom" {{ $period == 'custom' ? 'selected' : '' }}>Custom</option>
            </select>
            <input type="date" name="start_date" value="{{ $startDate }}" placeholder="Tgl Mulai">
            <input type="date" name="end_date" value="{{ $endDate }}" placeholder="Tgl Akhir">
            <select name="status">
                <option value="">Semua Status</option>
                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $status == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ $status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ $status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="btn-filter">Filter</button>
        </form>
        <a href="{{ route('admin.reports.index') }}" class="btn-reset">↻ Reset</a>
    </div>
    <div class="filter-right">
        <a href="{{ route('admin.reports.export') }}" class="btn-export">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M8 15l4 4 4-4"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
            Export CSV
        </a>
    </div>
</div>

<!-- ============================================================ -->
<!-- GRAFIK -->
<!-- ============================================================ -->
<div class="chart-container">
    <div class="chart-title">Grafik Penjualan 7 Hari Terakhir</div>
    @if($dailyStats->count() > 0)
        <div class="chart-bars">
            @foreach($dailyStats as $index => $stat)
                @php
                    $maxRevenue = $dailyStats->max('revenue') ?: 1;
                    $height = ($stat->revenue / $maxRevenue) * 100;
                @endphp
                <div class="bar-wrap">
                    <div class="bar" style="height: {{ max($height, 4) }}%; background: {{ $stat->revenue > 0 ? '#9b7654' : '#e7e1d9' }};"></div>
                    <div class="bar-value">Rp {{ number_format($stat->revenue / 1000, 0) }}K</div>
                    <div class="bar-label">{{ \Carbon\Carbon::parse($stat->date)->format('d M') }}</div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="icon">◉</div>
            <h3>Belum ada data</h3>
            <p>Belum ada pesanan dalam periode ini.</p>
        </div>
    @endif
</div>

<!-- ============================================================ -->
<!-- GRID 2 KOLOM -->
<!-- ============================================================ -->
<div class="reports-grid">

    <!-- STATUS STATS -->
    <div class="report-card">
        <div class="card-title">
            <span>Status Pesanan</span>
            <span class="badge-count">{{ $totalOrders }} total</span>
        </div>
        <div class="status-stats">
            <div class="status-item">
                <div class="status-dot pending"></div>
                <div class="status-count">{{ $statusStats['pending'] }}</div>
                <div class="status-label">Pending</div>
            </div>
            <div class="status-item">
                <div class="status-dot processing"></div>
                <div class="status-count">{{ $statusStats['processing'] }}</div>
                <div class="status-label">Processing</div>
            </div>
            <div class="status-item">
                <div class="status-dot shipped"></div>
                <div class="status-count">{{ $statusStats['shipped'] }}</div>
                <div class="status-label">Shipped</div>
            </div>
            <div class="status-item">
                <div class="status-dot delivered"></div>
                <div class="status-count">{{ $statusStats['delivered'] }}</div>
                <div class="status-label">Delivered</div>
            </div>
            <div class="status-item">
                <div class="status-dot cancelled"></div>
                <div class="status-count">{{ $statusStats['cancelled'] }}</div>
                <div class="status-label">Cancelled</div>
            </div>
        </div>
    </div>

    <!-- TOP 5 PRODUK -->
    <div class="report-card">
        <div class="card-title">
            <span>Produk Terlaris</span>
            <span class="badge-count">Top 5</span>
        </div>
        @if($topProducts->count() > 0)
            @foreach($topProducts as $index => $product)
            <div class="top-item">
                <div class="rank {{ $index === 0 ? 'gold' : ($index === 1 ? 'silver' : ($index === 2 ? 'bronze' : '')) }}">{{ $index + 1 }}</div>
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="top-img" alt="{{ $product->name }}">
                @else
                    <div class="top-img placeholder">◈</div>
                @endif
                <div class="top-info">
                    <div class="top-name">{{ $product->name }}</div>
                    <div class="top-meta">{{ $product->total_sold }} terjual</div>
                </div>
                <div class="top-value">
                    <div class="top-number">Rp {{ number_format($product->total_revenue / 1000, 0) }}K</div>
                    <div class="top-label">pendapatan</div>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty-state" style="padding:20px 0;">
                <p>Belum ada data produk terjual.</p>
            </div>
        @endif
    </div>
</div>

<!-- ============================================================ -->
<!-- TABEL PESANAN -->
<!-- ============================================================ -->
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>No. Order</th>
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Status</th>
                <th>Pembayaran</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td><b>{{ $order->order_number }}</b></td>
                <td>{{ $order->user->name ?? 'Unknown' }}</td>
                <td><b>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</b></td>
                <td>
                    <span class="badge-status {{ $order->status }}">{{ $order->status }}</span>
                </td>
                <td>
                    <span class="badge-status {{ $order->payment_status }}">{{ $order->payment_status }}</span>
                </td>
                <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;padding:40px 0;color:#999;">
                    <div style="font-size:40px;color:#d4c9be;margin-bottom:12px;">◉</div>
                    <div style="font-size:16px;font-weight:500;color:#1a1410;font-family:'Playfair Display',serif;">Tidak ada pesanan</div>
                    <div style="font-size:13px;margin:0;">Belum ada pesanan dalam periode ini.</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer-table">
        <span>Menampilkan {{ $orders->count() }} pesanan</span>
    </div>
</div>
@endsection
