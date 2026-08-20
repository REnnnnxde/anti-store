@extends('layouts.admin')

@section('content')
<style>
    /* ---- BADGE ---- */
    .role-badge {
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.04em;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .role-badge .dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; flex-shrink: 0; }
    .role-badge.admin { background: #e8edf5; color: #3b6ea5; }
    .role-badge.customer { background: #f0edea; color: #817a72; }

    .status-badge {
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.04em;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .status-badge .dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; flex-shrink: 0; }
    .status-badge.active { background: #e6f0ea; color: #2d7a5a; }
    .status-badge.pending { background: #fff0d9; color: #986723; }
    .status-badge.processing { background: #e8edf5; color: #3b6ea5; }
    .status-badge.shipped { background: #e6f0ea; color: #2d7a5a; }
    .status-badge.delivered { background: #e6f0ea; color: #2d7a5a; }
    .status-badge.cancelled { background: #f7e3e2; color: #a64d47; }

    /* ---- CARD ---- */
    .detail-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #f0edea;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .detail-card:hover {
        border-color: #e7e1d9;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .detail-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #817a72;
        margin-bottom: 4px;
    }

    .detail-value {
        font-size: 14px;
        font-weight: 600;
        color: #1a1410;
    }

    .detail-value-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-value-row svg {
        width: 14px;
        height: 14px;
        color: #b3aa9e;
        flex-shrink: 0;
    }

    /* ---- HEADING ---- */
    .heading-premium {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .heading-premium .left .eyebrow {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.16em;
        color: #9b7654;
        font-weight: 700;
    }

    .heading-premium .left h1 {
        font-size: 28px;
        font-weight: 500;
        font-family: 'Playfair Display', serif;
        margin: 4px 0 2px;
        color: #1a1410;
    }

    .heading-premium .left p {
        font-size: 13px;
        color: #817a72;
        margin: 0;
    }

    .back-btn {
        border: 1px solid #e7e1d9;
        background: #fff;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        color: #1a1410;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .back-btn:hover {
        background: #f6f3ee;
        border-color: #9b7654;
    }

    /* ---- PROFILE ---- */
    .profile-header {
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 24px;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 32px;
        flex-shrink: 0;
        background: #f1e9df;
        color: #9b7654;
    }

    .profile-info h2 {
        font-size: 24px;
        font-weight: 600;
        margin: 0;
        color: #1a1410;
        font-family: 'Playfair Display', serif;
    }

    .profile-info .email {
        color: #817a72;
        font-size: 14px;
    }

    /* ---- SUMMARY ---- */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }

    .summary-item {
        position: relative;
        overflow: hidden;
        background: #fff;
        border-radius: 14px;
        padding: 18px 20px;
        border: 1px solid #f0edea;
        transition: all 0.3s ease;
    }

    .summary-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.04);
    }

    .summary-item::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
    }

    .summary-item:nth-child(1)::before { background: #3b6ea5; }
    .summary-item:nth-child(2)::before { background: #9b7654; }
    .summary-item:nth-child(3)::before { background: #b8954a; }
    .summary-item:nth-child(4)::before { background: #7a5a9e; }

    .summary-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }

    .summary-icon svg { width: 16px; height: 16px; }

    .summary-item:nth-child(1) .summary-icon { background: #e8edf5; color: #3b6ea5; }
    .summary-item:nth-child(2) .summary-icon { background: #f1e9df; color: #9b7654; }
    .summary-item:nth-child(3) .summary-icon { background: #f5efe5; color: #b8954a; }
    .summary-item:nth-child(4) .summary-icon { background: #efeaf5; color: #7a5a9e; }

    .summary-number {
        font-size: 20px;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
        color: #1a1410;
        line-height: 1.2;
    }

    .summary-label {
        font-size: 11px;
        color: #817a72;
        margin-top: 3px;
    }

    /* ---- ORDER MINI ---- */
    .order-mini {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 10px;
        border-bottom: 1px solid #f6f3ee;
        border-radius: 8px;
        transition: background 0.2s ease;
        text-decoration: none;
        color: inherit;
        gap: 10px;
    }

    .order-mini:hover {
        background: #faf8f5;
    }

    .order-mini:last-child {
        border-bottom: none;
    }

    .order-mini .order-number {
        font-weight: 600;
        font-size: 13px;
        color: #1a1410;
    }

    .order-mini .order-date {
        font-size: 11px;
        color: #817a72;
    }

    .order-mini .order-amount {
        font-weight: 700;
        color: #9b7654;
        white-space: nowrap;
    }

    .order-mini .chevron {
        color: #c9c0b4;
        flex-shrink: 0;
    }

    .order-mini .chevron svg { width: 15px; height: 15px; }

    /* ---- EMPTY ---- */
    .empty-orders {
        text-align: center;
        padding: 26px 0;
        color: #817a72;
        font-size: 13px;
    }

    /* ---- RESPONSIVE ---- */
    @media (max-width: 768px) {
        .detail-grid { grid-template-columns: 1fr; }
        .summary-grid { grid-template-columns: repeat(2, 1fr); }
        .profile-header { flex-direction: column; text-align: center; }
        .heading-premium { flex-direction: column; align-items: flex-start; }
        .order-mini { flex-wrap: wrap; }
    }

    @media (max-width: 480px) {
        .summary-grid { grid-template-columns: 1fr; }
    }
</style>

<!-- HEADING -->
<div class="heading-premium">
    <div class="left">
        <div class="eyebrow">Customer Detail</div>
        <h1>{{ $user->name }}</h1>
        <p>Detail lengkap data pelanggan.</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="back-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 6l-6 6 6 6"/></svg>
        Kembali
    </a>
</div>

<!-- PROFILE -->
<div class="detail-card">
    <div class="profile-header">
        <div class="profile-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
        <div class="profile-info">
            <h2>{{ $user->name }}</h2>
            <div class="email">{{ $user->email }}</div>
            <div style="margin-top:8px;display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
                <span class="role-badge {{ $user->is_admin ? 'admin' : 'customer' }}">
                    <span class="dot"></span>
                    {{ $user->is_admin ? 'Admin' : 'Customer' }}
                </span>
                <span class="status-badge active">
                    <span class="dot"></span>
                    Aktif
                </span>
                <span style="font-size:12px;color:#817a72;">
                    Bergabung {{ $user->created_at->format('d M Y') }}
                </span>
            </div>
        </div>
    </div>

    <div class="detail-grid">
        <div>
            <div class="detail-label">Telepon</div>
            <div class="detail-value-row">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L14 13l5 2v4a2 2 0 0 1-2 2A15 15 0 0 1 4 6a2 2 0 0 1 0-2Z"/></svg>
                <span class="detail-value">{{ $user->phone ?? '-' }}</span>
            </div>
        </div>
        <div>
            <div class="detail-label">Email</div>
            <div class="detail-value-row">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg>
                <span class="detail-value" style="font-size:13px;">{{ $user->email }}</span>
            </div>
        </div>
        <div>
            <div class="detail-label">Alamat</div>
            <div class="detail-value-row" style="align-items:flex-start;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="margin-top:2px;"><path d="M12 21s7-6.1 7-11.5A7 7 0 0 0 5 9.5C5 14.9 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.3"/></svg>
                <span class="detail-value" style="font-size:13px;font-weight:400;line-height:1.5;">
                    {{ $user->address ?? 'Belum diisi' }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- SUMMARY -->
@php
    $totalOrders = $user->orders->count();
    $totalSpent = $user->orders->sum('total_amount');
    $avgOrder = $totalOrders > 0 ? $totalSpent / $totalOrders : 0;
    $lastOrder = $user->orders->sortByDesc('created_at')->first();
@endphp

<div class="summary-grid">
    <div class="summary-item">
        <div class="summary-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 4h2l2.4 12.2a2 2 0 0 0 2 1.6h7.6a2 2 0 0 0 2-1.6L21 8H6"/><circle cx="9.5" cy="20" r="1.4"/><circle cx="17" cy="20" r="1.4"/></svg>
        </div>
        <div class="summary-number">{{ $totalOrders }}</div>
        <div class="summary-label">Total Pesanan</div>
    </div>
    <div class="summary-item">
        <div class="summary-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="6" width="20" height="13" rx="2"/><path d="M2 10h20"/><path d="M6 15h4"/></svg>
        </div>
        <div class="summary-number">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
        <div class="summary-label">Total Belanja</div>
    </div>
    <div class="summary-item">
        <div class="summary-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19V10M12 19V4M20 19v-7"/></svg>
        </div>
        <div class="summary-number">Rp {{ number_format($avgOrder, 0, ',', '.') }}</div>
        <div class="summary-label">Rata-rata Order</div>
    </div>
    <div class="summary-item">
        <div class="summary-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        </div>
        <div class="summary-number">{{ $lastOrder ? $lastOrder->created_at->format('d M Y') : '-' }}</div>
        <div class="summary-label">Pesanan Terakhir</div>
    </div>
</div>

<!-- ORDER HISTORY -->
<div class="detail-card">
    <div style="font-weight:600;font-size:13px;margin-bottom:12px;">Riwayat Pesanan</div>
    @if($user->orders->count() > 0)
        @foreach($user->orders->sortByDesc('created_at') as $order)
        <a href="{{ route('admin.orders.show', $order->id) }}" class="order-mini">
            <div>
                <div class="order-number">{{ $order->order_number }}</div>
                <div class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</div>
            </div>
            <span class="status-badge {{ $order->status }}" style="font-size:9px;padding:2px 10px;">
                <span class="dot"></span>{{ $order->status }}
            </span>
            <div class="order-amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
            <span class="chevron">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 6 6 6-6 6"/></svg>
            </span>
        </a>
        @endforeach
    @else
        <div class="empty-orders">
            Belum ada pesanan dari pelanggan ini.
        </div>
    @endif
</div>
@endsection
