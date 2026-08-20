@extends('layouts.admin')

@section('content')
@php
    $adminImgSrc = function ($path) {
        if (!$path) return null;
        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) return null;
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $mime = match ($ext) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'avif' => 'image/avif',
            'webp' => 'image/webp',
            default => null,
        };
        if (!$mime) return null;
        return 'data:' . $mime . ';base64,' . base64_encode(\Illuminate\Support\Facades\Storage::disk('public')->get($path));
    };
@endphp

<style>
    /* ============================================================
       PREMIUM ORDERS INDEX - ANTI FASHION
    ============================================================ */

    /* ---- BADGE ---- */
    .badge-status {
        padding: 4px 14px 4px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .badge-status .dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; flex-shrink: 0; }

    .badge-status.pending { background: #fff0d9; color: #986723; }
    .badge-status.processing { background: #e8edf5; color: #3b6ea5; }
    .badge-status.shipped { background: #e6f0ea; color: #2d7a5a; }
    .badge-status.delivered { background: #e6f0ea; color: #2d7a5a; }
    .badge-status.cancelled { background: #f7e3e2; color: #a64d47; }

    .badge-payment {
        padding: 3px 12px 3px 8px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .badge-payment .dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; flex-shrink: 0; }
    .badge-payment.pending { background: #fff0d9; color: #986723; }
    .badge-payment.paid { background: #e6f0ea; color: #2d7a5a; }
    .badge-payment.failed { background: #f7e3e2; color: #a64d47; }

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
    .stat-card:nth-child(2) .stat-bar { background: #b8954a; }
    .stat-card:nth-child(3) .stat-bar { background: #2d7a5a; }
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
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-section .filter-left .search-box {
        position: relative;
    }

    .filter-section .filter-left .search-box input {
        padding: 10px 16px 10px 40px;
        border: 1px solid #e7e1d9;
        border-radius: 10px;
        font-size: 13px;
        background: #faf8f5;
        width: 220px;
        outline: none;
        transition: all 0.3s;
        font-family: inherit;
        color: #1a1410;
    }

    .filter-section .filter-left .search-box input:focus {
        border-color: #9b7654;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(155,118,84,0.08);
    }

    .filter-section .filter-left .search-box input::placeholder {
        color: #b3aa9e;
    }

    .filter-section .filter-left .search-box .icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #b3aa9e;
        font-size: 14px;
    }

    .filter-section .filter-left select {
        padding: 10px 16px;
        border: 1px solid #e7e1d9;
        border-radius: 10px;
        font-size: 13px;
        background: #faf8f5;
        color: #1a1410;
        outline: none;
        cursor: pointer;
        font-family: inherit;
        min-width: 140px;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M6 8L1 3h10z' fill='%23817a72'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 40px;
        transition: all 0.3s;
    }

    .filter-section .filter-left select:focus {
        border-color: #9b7654;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(155,118,84,0.08);
    }

    .filter-section .filter-left .btn-reset {
        padding: 10px 18px;
        border: 1px solid #e7e1d9;
        border-radius: 10px;
        background: #faf8f5;
        font-size: 13px;
        font-weight: 500;
        color: #817a72;
        cursor: pointer;
        transition: all 0.3s;
        font-family: inherit;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .filter-section .filter-left .btn-reset:hover {
        background: #f6f3ee;
        border-color: #9b7654;
        color: #1a1410;
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
        min-width: 900px;
    }

    th {
        text-align: left;
        padding: 14px 18px;
        background: #fbf9f6;
        color: #817a72;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 700;
    }

    td {
        padding: 14px 18px;
        border-top: 1px solid #f6f3ee;
        font-size: 13px;
        vertical-align: middle;
    }

    .customer-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .customer-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #f1e9df;
        color: #9b7654;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 12px;
        flex-shrink: 0;
    }

    .customer-name {
        font-weight: 600;
        font-size: 13px;
        color: #1a1410;
    }

    .product-thumb-wrapper {
        display: flex;
        align-items: center;
    }

    .order-product-img,
    .order-product-placeholder {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 0 0 1px #e0e0e0;
        background: #f0edea;
        margin-left: -10px;
        transition: transform .2s ease;
    }

    .order-product-img:first-child,
    .order-product-placeholder:first-child { margin-left: 0; }
    .product-thumb-wrapper:hover .order-product-img,
    .product-thumb-wrapper:hover .order-product-placeholder { transform: translateX(2px); }

    .order-product-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #b3aa9e;
    }
    .order-product-placeholder svg { width: 14px; height: 14px; }

    .thumb-more {
        margin-left: 4px;
        font-size: 10px;
        color: #817a72;
        background: #f0edea;
        padding: 3px 9px;
        border-radius: 12px;
        font-weight: 600;
    }

    .order-actions {
        display: flex;
        gap: 5px;
        align-items: center;
    }

    .order-actions .action {
        width: 32px;
        height: 32px;
        border: 1px solid #e7e1d9;
        border-radius: 8px;
        background: #fff;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #1a1410;
        text-decoration: none;
    }

    .order-actions .action:hover {
        background: #f6f3ee;
        border-color: #9b7654;
    }

    .order-actions .action.danger {
        color: #a64d47;
    }

    .order-actions .action.danger:hover {
        background: #f7e3e2;
        border-color: #a64d47;
    }

    .order-actions .action svg {
        width: 14px;
        height: 14px;
    }

    .order-actions form {
        display: inline;
        margin: 0;
        padding: 0;
    }

    .footer-table {
        padding: 14px 18px;
        display: flex;
        justify-content: space-between;
        color: #817a72;
        font-size: 11px;
        border-top: 1px solid #f6f3ee;
    }

    /* ---- EMPTY ---- */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #817a72;
    }

    .empty-state .icon { font-size: 48px; color: #d4c9be; margin-bottom: 16px; }
    .empty-state h3 { font-size: 18px; font-weight: 500; color: #1a1410; margin: 0 0 4px; font-family: 'Playfair Display', serif; }
    .empty-state p { font-size: 13px; margin: 0; }

    /* ---- RESPONSIVE ---- */
    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .filter-section { flex-direction: column; align-items: stretch; padding: 16px; }
        .filter-section .filter-left { flex-direction: column; }
        .filter-section .filter-left .search-box input { width: 100%; }
        .filter-section .filter-left select { width: 100%; }
        th, td { padding: 10px 12px; font-size: 12px; }
    }

    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
        table { min-width: 700px; }
    }
</style>

<!-- HEADING -->
<div class="heading-premium">
    <div class="eyebrow">Order Management</div>
    <h1>Pesanan</h1>
    <p>Kelola semua pesanan pelanggan Anti Fashion.</p>
</div>

<!-- STATS -->
<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-icon">◫</span>
        <div class="stat-number">{{ $orders->count() }}</div>
        <div class="stat-label">Total Pesanan</div>
        <div class="stat-bar"></div>
    </div>
    <div class="stat-card">
        <span class="stat-icon">◉</span>
        <div class="stat-number">{{ $orders->where('status', 'pending')->count() }}</div>
        <div class="stat-label">Pending</div>
        <div class="stat-bar"></div>
    </div>
    <div class="stat-card">
        <span class="stat-icon">◉</span>
        <div class="stat-number">{{ $orders->where('status', 'processing')->count() }}</div>
        <div class="stat-label">Processing</div>
        <div class="stat-bar"></div>
    </div>
    <div class="stat-card">
        <span class="stat-icon">✓</span>
        <div class="stat-number">{{ $orders->whereIn('status', ['shipped', 'delivered'])->count() }}</div>
        <div class="stat-label">Selesai</div>
        <div class="stat-bar"></div>
    </div>
</div>

<!-- FILTER -->
<div class="filter-section">
    <div class="filter-left">
        <div class="search-box">
            <span class="icon">⌕</span>
            <input id="search" placeholder="Cari pesanan...">
        </div>
        <select id="statusFilter">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="processing">Processing</option>
            <option value="shipped">Shipped</option>
            <option value="delivered">Delivered</option>
            <option value="cancelled">Cancelled</option>
        </select>
        <select id="paymentFilter">
            <option value="">Semua Pembayaran</option>
            <option value="pending">Pending</option>
            <option value="paid">Paid</option>
            <option value="failed">Failed</option>
        </select>
        <button class="btn-reset" id="resetBtn">↻ Reset</button>
    </div>
</div>

<!-- TABLE -->
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>No. Order</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Total</th>
                <th>Status</th>
                <th>Pembayaran</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="orderTable">
            @forelse($orders as $order)
            <tr data-status="{{ $order->status }}" data-payment="{{ $order->payment_status }}">
                <td><b>{{ $order->order_number }}</b></td>
                <td>
                    <div class="customer-cell">
                        <div class="customer-avatar">{{ strtoupper(substr($order->user->name ?? 'U', 0, 2)) }}</div>
                        <span class="customer-name">{{ $order->user->name ?? 'Unknown' }}</span>
                    </div>
                </td>
                <td>
                    <div class="product-thumb-wrapper">
                        @forelse($order->items->take(3) as $item)
                            @php $src = $item->product ? $adminImgSrc($item->product->image) : null; @endphp
                            @if($src)
                                <img src="{{ $src }}" class="order-product-img" alt="{{ $item->product->name }}" title="{{ $item->product->name }}">
                            @else
                                <div class="order-product-placeholder" title="{{ $item->product->name ?? 'Produk dihapus' }}">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 3.5a1.8 1.8 0 1 1 1.8 1.8"/><path d="M12 5.3v2.2"/><path d="M12 7.5 3 13.8a1.4 1.4 0 0 0 .8 2.5h16.4a1.4 1.4 0 0 0 .8-2.5L12 7.5Z"/></svg>
                                </div>
                            @endif
                        @empty
                            <span style="font-size:11px;color:#999;">Tidak ada produk</span>
                        @endforelse
                        @if($order->items->count() > 3)
                            <span class="thumb-more">+{{ $order->items->count() - 3 }}</span>
                        @endif
                    </div>
                </td>
                <td><b>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</b></td>
                <td>
                    <span class="badge-status {{ $order->status }}">
                        <span class="dot"></span>{{ $order->status }}
                    </span>
                </td>
                <td>
                    <span class="badge-payment {{ $order->payment_status }}">
                        <span class="dot"></span>{{ $order->payment_status }}
                    </span>
                </td>
                <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                <td>
                    <div class="order-actions">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="action" title="Detail">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </a>
                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pesanan {{ $order->order_number }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action danger" title="Hapus">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 7h16"/><path d="M9 7V4.8c0-.4.4-.8.9-.8h4.2c.5 0 .9.4.9.8V7"/><path d="M6 7l1 12.5a2 2 0 0 0 2 1.9h6a2 2 0 0 0 2-1.9L18 7"/><path d="M10 11v6M14 11v6"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;padding:44px 0;color:#999;">
                    <div style="font-size:48px;color:#d4c9be;margin-bottom:16px;">◫</div>
                    <div style="font-size:18px;font-weight:500;color:#1a1410;font-family:'Playfair Display',serif;">Belum ada pesanan</div>
                    <div style="font-size:13px;margin:0;">Pesanan akan muncul setelah pelanggan melakukan checkout.</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="footer-table">
        <span id="resultText">Menampilkan {{ $orders->count() }} pesanan</span>
    </div>
</div>

<script>
function filterTable() {
    let search = document.getElementById('search').value.toLowerCase();
    let status = document.getElementById('statusFilter').value;
    let payment = document.getElementById('paymentFilter').value;
    let rows = document.querySelectorAll('#orderTable tr');
    let count = 0;

    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        let statusText = row.dataset.status || '';
        let paymentText = row.dataset.payment || '';

        let show = true;
        if (search && !text.includes(search)) show = false;
        if (status && statusText != status) show = false;
        if (payment && paymentText != payment) show = false;

        if (show) {
            row.style.display = '';
            count++;
        } else {
            row.style.display = 'none';
        }
    });

    document.getElementById('resultText').textContent = 'Menampilkan ' + count + ' pesanan';
}

document.getElementById('search').addEventListener('keyup', filterTable);
document.getElementById('statusFilter').addEventListener('change', filterTable);
document.getElementById('paymentFilter').addEventListener('change', filterTable);

document.getElementById('resetBtn').addEventListener('click', function() {
    document.getElementById('search').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('paymentFilter').value = '';
    filterTable();
});
</script>
@endsection
