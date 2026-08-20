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

    $steps = ['pending' => 'Pending', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered'];
    $stepKeys = array_keys($steps);
    $currentIndex = array_search($order->status, $stepKeys);
    $isCancelled = $order->status === 'cancelled';
@endphp

<style>
    /* ============================================================
       PREMIUM ORDER DETAIL - ANTI FASHION
    ============================================================ */

    /* ---- BADGE ---- */
    .badge-status {
        padding: 4px 16px 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .badge-status .dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; flex-shrink: 0; }

    .badge-status.pending { background: #fff0d9; color: #986723; }
    .badge-status.processing { background: #e8edf5; color: #3b6ea5; }
    .badge-status.shipped { background: #e6f0ea; color: #2d7a5a; }
    .badge-status.delivered { background: #e6f0ea; color: #2d7a5a; }
    .badge-status.cancelled { background: #f7e3e2; color: #a64d47; }
    .badge-status.paid { background: #e6f0ea; color: #2d7a5a; }
    .badge-status.failed { background: #f7e3e2; color: #a64d47; }

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

    .heading-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 10px 20px;
        border: 1px solid #e7e1d9;
        border-radius: 10px;
        background: #fff;
        font-size: 12px;
        font-weight: 600;
        color: #1a1410;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action:hover {
        background: #f6f3ee;
        border-color: #9b7654;
    }

    .btn-action svg { width: 14px; height: 14px; }

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

    .detail-card-title {
        font-weight: 600;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
        color: #1a1410;
    }

    .detail-card-title svg { width: 16px; height: 16px; color: #9b7654; }

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

    /* ---- TIMELINE ---- */
    .timeline {
        display: flex;
        align-items: flex-start;
        margin-top: 12px;
        position: relative;
    }

    .timeline-step {
        flex: 1;
        text-align: center;
        position: relative;
    }

    .timeline-step .line {
        position: absolute;
        top: 17px;
        left: 50%;
        width: 100%;
        height: 2px;
        background: #e7e1d9;
        z-index: 0;
    }

    .timeline-step:last-child .line { display: none; }
    .timeline-step.completed .line { background: #9b7654; }

    .timeline-icon {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #f0edea;
        color: #b3aa9e;
        border: 2px solid #f0edea;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        position: relative;
        z-index: 1;
    }

    .timeline-icon svg { width: 16px; height: 16px; }

    .timeline-step.completed .timeline-icon {
        background: #9b7654;
        border-color: #9b7654;
        color: #fff;
    }

    .timeline-step.current .timeline-icon {
        background: #fff;
        border-color: #9b7654;
        color: #9b7654;
        box-shadow: 0 0 0 4px rgba(155,118,84,0.12);
    }

    .timeline-label {
        font-size: 11px;
        font-weight: 600;
        color: #817a72;
    }

    .timeline-step.completed .timeline-label,
    .timeline-step.current .timeline-label { color: #1a1410; }

    .cancelled-banner {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f7e3e2;
        color: #a64d47;
        padding: 14px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        margin-top: 16px;
    }

    .cancelled-banner svg { width: 20px; height: 20px; flex-shrink: 0; }

    /* ---- STATUS FORM ---- */
    .status-form {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-top: 12px;
        flex-wrap: wrap;
    }

    .status-form select {
        padding: 10px 16px;
        border: 1px solid #e7e1d9;
        border-radius: 10px;
        font-size: 13px;
        background: #faf8f5;
        color: #1a1410;
        outline: none;
        cursor: pointer;
        font-family: inherit;
        min-width: 160px;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath d='M6 8L1 3h10z' fill='%23817a72'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 40px;
        transition: all 0.3s;
    }

    .status-form select:focus {
        border-color: #9b7654;
        box-shadow: 0 0 0 3px rgba(155,118,84,0.08);
    }

    .btn-update {
        padding: 10px 24px;
        border: none;
        border-radius: 10px;
        background: #1a1410;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-update:hover {
        background: #3a342f;
    }

    /* ---- CUSTOMER ---- */
    .customer-head {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 18px;
    }

    .customer-avatar-lg {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #f1e9df;
        color: #9b7654;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
    }

    .customer-name-lg {
        font-size: 18px;
        font-weight: 600;
        color: #1a1410;
    }

    .customer-email {
        font-size: 13px;
        color: #817a72;
    }

    .copy-btn {
        border: 1px solid #e7e1d9;
        background: #faf8f5;
        border-radius: 8px;
        padding: 5px 12px;
        font-size: 10px;
        font-weight: 600;
        color: #9b7654;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 8px;
        transition: all .2s ease;
    }

    .copy-btn:hover {
        background: #f1e9df;
        border-color: #9b7654;
    }

    .copy-btn svg { width: 12px; height: 12px; }

    /* ---- ITEM TABLE ---- */
    .item-table {
        width: 100%;
        border-collapse: collapse;
    }

    .item-table th {
        text-align: left;
        padding: 10px 14px;
        background: #fbf9f6;
        color: #817a72;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .08em;
        font-weight: 700;
    }

    .item-table td {
        padding: 12px 14px;
        border-top: 1px solid #f6f3ee;
        font-size: 13px;
        vertical-align: middle;
    }

    .item-table .total-row td {
        font-weight: 700;
        font-size: 15px;
        border-top: 2px solid #e7e1d9;
    }

    .product-cell {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .product-img {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #e7e1d9;
        background: #f0edea;
        flex-shrink: 0;
    }

    .product-img-placeholder {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        background: #f0edea;
        border: 1px solid #e7e1d9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #b3aa9e;
        flex-shrink: 0;
    }

    .product-img-placeholder svg { width: 19px; height: 19px; }

    .product-name {
        font-weight: 500;
        color: #1a1410;
    }

    .product-sku {
        font-size: 11px;
        color: #817a72;
    }

    /* ---- PAYMENT PROOF ---- */
    .proof-container {
        border: 1px solid #f0edea;
        border-radius: 10px;
        overflow: hidden;
        max-width: 320px;
        position: relative;
        background: #faf8f5;
    }

    .proof-container img {
        width: 100%;
        height: auto;
        display: block;
    }

    .proof-container .proof-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .proof-container .proof-badge.verified {
        background: #e6f0ea;
        color: #2d7a5a;
    }

    .proof-container .proof-badge.rejected {
        background: #f7e3e2;
        color: #a64d47;
    }

    .proof-container .proof-badge.pending {
        background: #fff0d9;
        color: #986723;
    }

    /* ---- VERIFICATION FORM ---- */
    .verification-form {
        border-top: 1px solid #f0edea;
        padding-top: 16px;
        margin-top: 16px;
    }

    .verification-form .form-row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
    }

    .verification-form select {
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

    .verification-form select:focus {
        border-color: #9b7654;
        box-shadow: 0 0 0 3px rgba(155,118,84,0.08);
    }

    .verification-form input[type="text"] {
        flex: 1;
        min-width: 200px;
        padding: 10px 16px;
        border: 1px solid #e7e1d9;
        border-radius: 10px;
        font-size: 13px;
        background: #faf8f5;
        outline: none;
        font-family: inherit;
        transition: all 0.3s;
    }

    .verification-form input[type="text"]:focus {
        border-color: #9b7654;
        box-shadow: 0 0 0 3px rgba(155,118,84,0.08);
    }

    .btn-verify {
        padding: 10px 28px;
        border: none;
        border-radius: 10px;
        background: #2d7a5a;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-verify:hover {
        background: #1f5a3f;
    }

    .btn-reject {
        padding: 10px 28px;
        border: none;
        border-radius: 10px;
        background: #a64d47;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-reject:hover {
        background: #8a3d38;
    }

    .alert-warning {
        padding: 12px 16px;
        background: #fff0d9;
        border-radius: 10px;
        color: #986723;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-warning svg { width: 18px; height: 18px; flex-shrink: 0; }

    .alert-success {
        padding: 12px 16px;
        background: #e6f0ea;
        border-radius: 10px;
        color: #2d7a5a;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success svg { width: 18px; height: 18px; flex-shrink: 0; }

    /* ---- RESPONSIVE ---- */
    @media (max-width: 768px) {
        .detail-grid { grid-template-columns: 1fr; }
        .status-form { flex-direction: column; align-items: stretch; }
        .heading-premium { flex-direction: column; align-items: flex-start; }
        .item-table { font-size: 12px; }
        .product-img, .product-img-placeholder { width: 36px; height: 36px; }
        .timeline-label { font-size: 9px; }
        .customer-head { flex-direction: column; text-align: center; }
        .verification-form .form-row { flex-direction: column; align-items: stretch; }
        .proof-container { max-width: 100%; }
    }

    @media print {
        .heading-actions, .status-form, .btn-update, .copy-btn, .verification-form { display: none !important; }
    }
</style>

<!-- ============================================================ -->
<!-- HEADING -->
<!-- ============================================================ -->
<div class="heading-premium">
    <div class="left">
        <div class="eyebrow">Order Detail</div>
        <h1>#{{ $order->order_number }}</h1>
        <p>Detail pesanan pelanggan.</p>
    </div>
    <div class="heading-actions">
        <button type="button" class="btn-action" onclick="window.print()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M6 9V3h12v6"/>
                <path d="M6 18H4a1 1 0 0 1-1-1v-6a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-2"/>
                <path d="M6 14h12v7H6z"/>
            </svg>
            Cetak
        </button>
        <a href="{{ route('admin.orders.index') }}" class="btn-action">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 6l-6 6 6 6"/></svg>
            Kembali
        </a>
    </div>
</div>

<!-- ============================================================ -->
<!-- STATUS -->
<!-- ============================================================ -->
<div class="detail-card">
    <div class="detail-grid" style="margin-bottom:20px;">
        <div>
            <div class="detail-label">Status Pesanan</div>
            <div class="detail-value">
                <span class="badge-status {{ $order->status }}"><span class="dot"></span>{{ $order->status }}</span>
            </div>
        </div>
        <div>
            <div class="detail-label">Status Pembayaran</div>
            <div class="detail-value">
                <span class="badge-status {{ $order->payment_status }}"><span class="dot"></span>{{ $order->payment_status }}</span>
            </div>
        </div>
        <div>
            <div class="detail-label">Total</div>
            <div class="detail-value" style="font-size:22px;color:#9b7654;">
                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
            </div>
        </div>
    </div>

    @if($isCancelled)
        <div class="cancelled-banner">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="m9 9 6 6M15 9l-6 6"/></svg>
            <div>Pesanan ini telah dibatalkan. Tahapan pemrosesan tidak dilanjutkan.</div>
        </div>
    @else
        <div class="timeline">
            @foreach($steps as $key => $label)
                @php
                    $index = array_search($key, $stepKeys);
                    $isCompleted = $index < $currentIndex;
                    $isCurrent = $index === $currentIndex;
                @endphp
                <div class="timeline-step {{ $isCompleted ? 'completed' : '' }} {{ $isCurrent ? 'current' : '' }}">
                    <div class="line"></div>
                    <div class="timeline-icon">
                        @if($isCompleted)
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12l5 5L20 7"/></svg>
                        @elseif($key === 'pending')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg>
                        @elseif($key === 'processing')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3a9 9 0 1 0 9 9"/><path d="M12 3v5l4-2.5"/></svg>
                        @elseif($key === 'shipped')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 8h11v8H2z"/><path d="M13 11h4l4 3.2V16h-8"/><circle cx="6" cy="18.5" r="1.5"/><circle cx="17" cy="18.5" r="1.5"/></svg>
                        @else
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20 7 12 3 4 7v10l8 4 8-4V7Z"/><path d="M4 7l8 4 8-4M12 11v10"/></svg>
                        @endif
                    </div>
                    <div class="timeline-label">{{ $label }}</div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- ============================================================ -->
<!-- UPDATE STATUS -->
<!-- ============================================================ -->
<div class="detail-card">
    <div class="detail-card-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 20a8 8 0 1 0-8-8"/><path d="M4 12H2m2.6-5.4L3.2 5.2M12 4V2"/><path d="M12 12l3 2"/></svg>
        Update Status
    </div>
    <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="status-form">
        @csrf
        @method('PUT')
        <select name="status">
            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <button type="submit" class="btn-update">Update Status</button>
    </form>
</div>

<!-- ============================================================ -->
<!-- VERIFIKASI PEMBAYARAN -->
<!-- ============================================================ -->
<div class="detail-card">
    <div class="detail-card-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M12 2l8 4v6c0 5-3.4 8.6-8 10-4.6-1.4-8-5-8-10V6z"/>
            <path d="M9 12l2 2 4-4"/>
        </svg>
        Verifikasi Pembayaran
    </div>

    <!-- Status Verifikasi -->
    <div class="detail-grid" style="margin-bottom:16px;">
        <div>
            <div class="detail-label">Status Verifikasi</div>
            <div class="detail-value">
                @if($order->payment_verification === 'verified')
                    <span style="color:#2d7a5a;font-weight:700;">✓ Terverifikasi</span>
                @elseif($order->payment_verification === 'rejected')
                    <span style="color:#a64d47;font-weight:700;">✗ Ditolak</span>
                @else
                    <span style="color:#986723;font-weight:700;">◉ Menunggu Verifikasi</span>
                @endif
            </div>
        </div>
        <div>
            <div class="detail-label">Status Pembayaran</div>
            <div class="detail-value">
                <span class="badge-status {{ $order->payment_status }}">
                    <span class="dot"></span>{{ $order->payment_status }}
                </span>
            </div>
        </div>
        <div>
            <div class="detail-label">Diverifikasi Pada</div>
            <div class="detail-value">
                {{ $order->payment_verified_at ? $order->payment_verified_at->format('d M Y, H:i') : '-' }}
            </div>
        </div>
    </div>

    <!-- Bukti Pembayaran -->
    @if($order->payment_proof)
        <div style="margin-bottom:16px;">
            <div class="detail-label" style="margin-bottom:6px;">Bukti Pembayaran</div>
            <div class="proof-container">
                <img src="{{ asset('storage/' . $order->payment_proof) }}"
                     alt="Bukti Pembayaran"
                     onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22320%22 height=%22200%22%3E%3Crect width=%22320%22 height=%22200%22 fill=%22%23f6f3ee%22/%3E%3Ctext x=%2250%22 y=%22100%22 fill=%22%23b3aa9e%22 font-size=%2214%22%3EBukti tidak ditemukan%3C/text%3E%3C/svg%3E'">
                @if($order->payment_verification === 'verified')
                    <span class="proof-badge verified">✓ Terverifikasi</span>
                @elseif($order->payment_verification === 'rejected')
                    <span class="proof-badge rejected">✗ Ditolak</span>
                @else
                    <span class="proof-badge pending">◉ Menunggu</span>
                @endif
            </div>
            <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" style="font-size:12px;color:#9b7654;margin-top:8px;display:inline-block;font-weight:600;">
                Lihat full gambar →
            </a>
        </div>
    @else
        <div class="alert-warning">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 8v4M12 16h.01"/></svg>
            Belum ada bukti pembayaran diupload oleh pelanggan.
        </div>
    @endif

    <!-- Catatan Verifikasi -->
    @if($order->payment_notes)
        <div style="margin-bottom:16px;">
            <div class="detail-label">Catatan Verifikasi</div>
            <div style="font-size:13px;color:#4a4038;background:#faf8f5;padding:12px 16px;border-radius:8px;border:1px solid #f0edea;">
                {{ $order->payment_notes }}
            </div>
        </div>
    @endif

    <!-- Form Verifikasi -->
    @if($order->payment_verification === 'pending' && $order->payment_proof)
        <div class="verification-form">
            <form action="{{ route('admin.orders.verify-payment', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <select name="action" required>
                        <option value="verify">✓ Verifikasi</option>
                        <option value="reject">✗ Tolak</option>
                    </select>
                    <input type="text" name="notes" placeholder="Catatan (opsional)">
                    <button type="submit" class="btn-verify">Proses Verifikasi</button>
                </div>
            </form>
        </div>
    @elseif($order->payment_verification === 'pending' && !$order->payment_proof)
        <div class="alert-warning">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 8v4M12 16h.01"/></svg>
            Menunggu pelanggan mengupload bukti pembayaran.
        </div>
    @elseif($order->payment_verification === 'verified')
        <div class="alert-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12l5 5L20 7"/></svg>
            Pembayaran telah diverifikasi pada {{ $order->payment_verified_at ? $order->payment_verified_at->format('d M Y, H:i') : '-' }}
        </div>
    @elseif($order->payment_verification === 'rejected')
        <div class="alert-warning">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="m9 9 6 6M15 9l-6 6"/></svg>
            Pembayaran ditolak. {{ $order->payment_notes ? 'Catatan: ' . $order->payment_notes : '' }}
        </div>
    @endif
</div>

<!-- ============================================================ -->
<!-- CUSTOMER -->
<!-- ============================================================ -->
<div class="detail-card">
    <div class="customer-head">
        <div class="customer-avatar-lg">{{ strtoupper(substr($order->user->name ?? 'U', 0, 2)) }}</div>
        <div>
            <div class="customer-name-lg">{{ $order->user->name ?? 'Unknown' }}</div>
            <div class="customer-email">{{ $order->user->email ?? '-' }}</div>
        </div>
    </div>

    <div class="detail-grid">
        <div>
            <div class="detail-label">Nama</div>
            <div class="detail-value-row">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="3.6"/><path d="M4.5 20c1.4-4 4-6 7.5-6s6.1 2 7.5 6"/></svg>
                <span class="detail-value">{{ $order->user->name ?? 'Unknown' }}</span>
            </div>
        </div>
        <div>
            <div class="detail-label">Email</div>
            <div class="detail-value-row">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg>
                <span class="detail-value">{{ $order->user->email ?? '-' }}</span>
            </div>
        </div>
        <div>
            <div class="detail-label">Alamat Pengiriman</div>
            <div class="detail-value-row" style="align-items:flex-start;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="margin-top:2px;"><path d="M12 21s7-6.1 7-11.5A7 7 0 0 0 5 9.5C5 14.9 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.3"/></svg>
                <span id="shipAddress" class="detail-value" style="font-size:13px;font-weight:400;line-height:1.5;">{{ $order->shipping_address }}</span>
            </div>
            <button type="button" class="copy-btn" onclick="copyAddress()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="9" y="9" width="12" height="12" rx="2"/><path d="M5 15V5a2 2 0 0 1 2-2h10"/></svg>
                <span id="copyLabel">Salin alamat</span>
            </button>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- PRODUK -->
<!-- ============================================================ -->
<div class="detail-card">
    <div class="detail-card-title">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 7.5 12 3l9 4.5-9 4.5-9-4.5Z"/><path d="M3 7.5v9L12 21l9-4.5v-9"/><path d="M12 12v9"/></svg>
        Produk
    </div>
    <table class="item-table">
        <thead>
            <tr>
                <th>Produk</th>
                <th style="text-align:center;">Qty</th>
                <th style="text-align:right;">Harga</th>
                <th style="text-align:right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            @php $src = $item->product ? $adminImgSrc($item->product->image) : null; @endphp
            <tr>
                <td>
                    <div class="product-cell">
                        @if($src)
                            <img src="{{ $src }}" class="product-img" alt="{{ $item->product->name }}">
                        @else
                            <div class="product-img-placeholder">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 3.5a1.8 1.8 0 1 1 1.8 1.8"/><path d="M12 5.3v2.2"/><path d="M12 7.5 3 13.8a1.4 1.4 0 0 0 .8 2.5h16.4a1.4 1.4 0 0 0 .8-2.5L12 7.5Z"/></svg>
                            </div>
                        @endif
                        <div>
                            <div class="product-name">{{ $item->product->name ?? 'Produk tidak ditemukan' }}</div>
                            @if($item->product)
                                <div class="product-sku">SKU: {{ $item->product->slug ?? '-' }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td style="text-align:center;font-weight:600;">{{ $item->quantity }}</td>
                <td style="text-align:right;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td style="text-align:right;font-weight:600;">
                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3" style="text-align:right;">Total</td>
                <td style="text-align:right;font-size:18px;color:#9b7654;">
                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- ============================================================ -->
<!-- SCRIPT -->
<!-- ============================================================ -->
<script>
function copyAddress() {
    const text = document.getElementById('shipAddress').innerText;
    navigator.clipboard.writeText(text).then(function() {
        const label = document.getElementById('copyLabel');
        const original = label.textContent;
        label.textContent = 'Tersalin!';
        setTimeout(() => { label.textContent = original; }, 1800);
    });
}
</script>
@endsection
