@extends('layouts.admin')

@section('content')
<style>
    /* ============================================================
       PREMIUM STYLING - ANTI FASHION
    ============================================================ */
    .filter-section {
        background: #fff;
        border-radius: 14px;
        padding: 20px 24px;
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

    .filter-section .filter-right .btn-add {
        padding: 10px 24px;
        border: none;
        border-radius: 10px;
        background: #1a1410;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-family: inherit;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-section .filter-right .btn-add:hover {
        background: #3a342f;
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(26,20,16,0.15);
    }

    /* Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 24px;
        margin-top: 0;
    }

    .product-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #f0edea;
        transition: all 0.4s ease;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 60px rgba(26,20,16,0.08);
        border-color: #e7e1d9;
    }

    .product-card .image-wrap {
        position: relative;
        height: 200px;
        overflow: hidden;
        background: #f6f3ee;
    }

    .product-card .image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .product-card:hover .image-wrap img {
        transform: scale(1.04);
    }

    .product-card .image-wrap .no-img {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #c9c0b4;
        font-size: 13px;
        background: #f6f3ee;
    }

    .product-card .image-wrap .badge-top {
        position: absolute;
        top: 12px;
        left: 12px;
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .product-card .image-wrap .badge-top .badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(8px);
        color: #1a1410;
        border: 1px solid rgba(255,255,255,0.3);
    }

    .product-card .image-wrap .badge-top .badge.featured {
        background: #b8954a;
        color: #fff;
        border: none;
    }

    .product-card .image-wrap .badge-top .badge.inactive {
        background: #a64d47;
        color: #fff;
        border: none;
    }

    .product-card .image-wrap .actions-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 16px;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        background: linear-gradient(0deg, rgba(26,20,16,0.4) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product-card:hover .image-wrap .actions-overlay {
        opacity: 1;
    }

    .product-card .image-wrap .actions-overlay .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: none;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(8px);
        color: #1a1410;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        text-decoration: none;
    }

    .product-card .image-wrap .actions-overlay .btn-icon:hover {
        background: #fff;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .product-card .image-wrap .actions-overlay .btn-icon.danger:hover {
        background: #a64d47;
        color: #fff;
    }

    .product-card .info {
        padding: 16px 18px 18px;
    }

    .product-card .info .category {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #817a72;
        font-weight: 600;
    }

    .product-card .info .name {
        font-size: 15px;
        font-weight: 600;
        color: #1a1410;
        margin: 4px 0 2px;
        font-family: 'Playfair Display', serif;
    }

    .product-card .info .slug {
        font-size: 11px;
        color: #b3aa9e;
        margin-bottom: 8px;
    }

    .product-card .info .price-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 10px;
        border-top: 1px solid #f0edea;
    }

    .product-card .info .price {
        font-size: 17px;
        font-weight: 700;
        color: #1a1410;
    }

    .product-card .info .stock {
        font-size: 12px;
        font-weight: 500;
        padding: 3px 12px;
        border-radius: 20px;
        background: #f0edea;
    }

    .product-card .info .stock.in-stock { background: #e6f0ea; color: #2d7a5a; }
    .product-card .info .stock.low-stock { background: #fff0d9; color: #986723; }
    .product-card .info .stock.out-stock { background: #f7e3e2; color: #a64d47; }

    .product-card .info .meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 11px;
        color: #817a72;
        margin-top: 8px;
    }

    .product-card .info .meta .dot {
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: #d4c9be;
    }

    /* Stats */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    .stat-item {
        background: #fff;
        border-radius: 14px;
        padding: 18px 22px;
        border: 1px solid #f0edea;
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.04);
    }

    .stat-item .stat-number {
        font-size: 24px;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
        color: #1a1410;
        line-height: 1.2;
    }

    .stat-item .stat-label {
        font-size: 12px;
        color: #817a72;
        margin-top: 4px;
    }

    .stat-item .stat-icon {
        font-size: 18px;
        color: #b3aa9e;
        float: right;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #817a72;
        grid-column: 1/-1;
    }

    .empty-state .icon { font-size: 48px; color: #d4c9be; margin-bottom: 16px; }
    .empty-state h3 { font-size: 18px; font-weight: 500; color: #1a1410; margin: 0 0 4px; font-family: 'Playfair Display', serif; }
    .empty-state p { font-size: 13px; margin: 0; }

    /* Modal */
    .modal-bg{position:fixed;inset:0;background:#1814117a;backdrop-filter:blur(8px);z-index:20;display:none}
    .modal-bg.show{display:block}
    .modal{position:fixed;z-index:21;left:50%;top:50%;transform:translate(-50%,-50%);width:min(700px,calc(100% - 30px));max-height:90vh;overflow:auto;background:#fff;border-radius:20px;padding:32px;display:none;box-shadow:0 40px 100px rgba(0,0,0,0.15)}
    .modal.show{display:block}
    .modal-head{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px}
    .modal h2{font:500 28px "Playfair Display";margin:0 0 4px;color:#1a1410}
    .modal-sub{font-size:12px;color:#817a72}
    .close{border:0;background:#f4f0eb;width:36px;height:36px;border-radius:50%;font-size:20px;cursor:pointer;transition:.3s;display:flex;align-items:center;justify-content:center}
    .close:hover{background:#e5ddd5}
    .form{display:grid;grid-template-columns:1fr 1fr;gap:18px}
    .field{display:flex;flex-direction:column;gap:6px}
    .field.full{grid-column:1/-1}
    .field label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#817a72}
    .field input,.field select,.field textarea{border:1px solid #e7e1d9;border-radius:10px;padding:12px 14px;background:#faf8f5;outline:0;font-size:13px;width:100%;font-family:inherit;transition:.3s}
    .field input:focus,.field select:focus,.field textarea:focus{border-color:#9b7654;box-shadow:0 0 0 3px rgba(155,118,84,0.08)}
    .field textarea{min-height:80px;resize:vertical}
    .modal-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:24px;padding-top:20px;border-top:1px solid #f0edea}
    .secondary{border:1px solid #e7e1d9;background:#fff;padding:12px 24px;border-radius:10px;font-size:12px;font-weight:600;cursor:pointer;transition:.3s;color:#1a1410}
    .secondary:hover{background:#f6f3ee}
    .primary{border:0;background:#1a1410;color:#fff;padding:12px 28px;border-radius:10px;font-size:12px;font-weight:600;cursor:pointer;transition:.3s}
    .primary:hover{background:#3a342f}

    .toggle-wrap{display:flex;align-items:center;gap:14px;padding-top:4px}
    .toggle-wrap label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#817a72;margin:0}
    .toggle{position:relative;display:inline-block;width:48px;height:26px;cursor:pointer;flex-shrink:0}
    .toggle input{opacity:0;width:0;height:0}
    .toggle .slider{position:absolute;inset:0;background:#d4c9be;border-radius:26px;transition:.3s}
    .toggle .slider:before{content:'';position:absolute;height:20px;width:20px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:.3s}
    .toggle input:checked + .slider{background:#9b7654}
    .toggle input:checked + .slider:before{transform:translateX(22px)}
    .toggle-label{font-size:12px;color:#817a72}

    .toast{position:fixed;right:28px;bottom:28px;background:#1a1410;color:#fff;padding:14px 22px;border-radius:12px;font-size:12px;z-index:50;opacity:0;transform:translateY(16px);transition:.4s ease}
    .toast.show{opacity:1;transform:translateY(0)}

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .product-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .filter-section { flex-direction: column; align-items: stretch; padding: 16px; }
        .filter-section .filter-left { flex-direction: column; }
        .filter-section .filter-left .search-box input { width: 100%; }
        .filter-section .filter-left select { width: 100%; }
        .filter-section .filter-right .btn-add { width: 100%; justify-content: center; }
        .form { grid-template-columns: 1fr; }
    }

    @media (max-width: 480px) {
        .product-grid { grid-template-columns: 1fr; }
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>

<!-- HEADING -->
<div class="heading-premium" style="margin-bottom:24px;">
    <div style="font-size:10px;text-transform:uppercase;letter-spacing:0.16em;color:#9b7654;font-weight:700;">Product Management</div>
    <h1 style="font-size:30px;font-weight:500;font-family:'Playfair Display',serif;margin:4px 0 2px;color:#1a1410;">Produk</h1>
    <p style="font-size:13px;color:#817a72;margin:0;">Kelola katalog produk Anti Fashion.</p>
</div>

<!-- STATS -->
<div class="stats-grid">
    <div class="stat-item">
        <span class="stat-icon">▦</span>
        <div class="stat-number">{{ $products->count() }}</div>
        <div class="stat-label">Total Produk</div>
    </div>
    <div class="stat-item">
        <span class="stat-icon">✓</span>
        <div class="stat-number">{{ $products->where('status', 'active')->count() }}</div>
        <div class="stat-label">Produk Aktif</div>
    </div>
    <div class="stat-item">
        <span class="stat-icon">★</span>
        <div class="stat-number">{{ $products->where('is_featured', true)->count() }}</div>
        <div class="stat-label">Featured</div>
    </div>
    <div class="stat-item">
        <span class="stat-icon">◈</span>
        <div class="stat-number">{{ $products->sum(function($p) { return $p->galleries->count() + 1; }) }}</div>
        <div class="stat-label">Total Gambar</div>
    </div>
</div>

<!-- FILTER SECTION -->
<div class="filter-section">
    <div class="filter-left">
        <div class="search-box">
            <span class="icon">⌕</span>
            <input id="search" placeholder="Cari produk...">
        </div>
        <select id="categoryFilter">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
        <select id="statusFilter">
            <option value="">Semua Status</option>
            <option value="active">Aktif</option>
            <option value="inactive">Tidak Aktif</option>
        </select>
        <select id="featuredFilter">
            <option value="">Semua</option>
            <option value="1">Featured</option>
            <option value="0">Non-Featured</option>
        </select>
        <button class="btn-reset" id="resetBtn">↻ Reset</button>
    </div>
    <div class="filter-right">
        <button class="btn-add" id="addBtn">+ Tambah Produk</button>
    </div>
</div>

<!-- PRODUCT GRID -->
<div class="product-grid" id="productGrid">
    @forelse($products as $product)
    <div class="product-card" data-category="{{ $product->category_id }}" data-status="{{ $product->status }}" data-featured="{{ $product->is_featured ? '1' : '0' }}">
        <div class="image-wrap">
            @if($product->image_base64)
                <img src="{{ $product->image_base64 }}" alt="{{ $product->name }}">
            @else
                <div class="no-img">No image</div>
            @endif
            <div class="badge-top">
                @if($product->is_featured)
                    <span class="badge featured">★ Featured</span>
                @endif
                @if($product->status === 'inactive')
                    <span class="badge inactive">Tidak Aktif</span>
                @endif
            </div>
            <div class="actions-overlay">
                <a href="{{ route('admin.products.show', $product->id) }}" class="btn-icon" title="Detail">◈</a>
                <button class="btn-icon editBtn"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-category="{{ $product->category_id }}"
                    data-price="{{ $product->price }}"
                    data-stock="{{ $product->stock }}"
                    data-status="{{ $product->status }}"
                    data-description="{{ $product->description }}"
                    data-image="{{ $product->image }}"
                    data-featured="{{ $product->is_featured ? '1' : '0' }}"
                    title="Edit">✎</button>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus {{ $product->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-icon danger" title="Hapus">✕</button>
                </form>
            </div>
        </div>
        <div class="info">
            <div class="category">{{ $product->category->name ?? 'Uncategorized' }}</div>
            <div class="name">{{ $product->name }}</div>
            <div class="slug">{{ $product->slug ?? '' }}</div>
            <div class="price-row">
                <span class="price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                <span class="stock
                    @if($product->stock > 10) in-stock
                    @elseif($product->stock > 0 && $product->stock <= 10) low-stock
                    @else out-stock @endif">
                    @if($product->stock > 10) {{ $product->stock }} pcs
                    @elseif($product->stock > 0 && $product->stock <= 10) {{ $product->stock }} pcs
                    @else Habis @endif
                </span>
            </div>
            <div class="meta">
                <span>{{ $product->galleries->count() + 1 }} gambar</span>
                <span class="dot"></span>
                <span>{{ $product->galleries->count() }} gallery</span>
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <div class="icon">📦</div>
        <h3>Belum ada produk</h3>
        <p>Klik "Tambah Produk" untuk memulai.</p>
    </div>
    @endforelse
</div>

<!-- MODAL (SAMA SEPERTI SEBELUMNYA) -->
<div class="modal-bg" id="modalBg"></div>
<div class="modal" id="modal">
    <div class="modal-head">
        <div>
            <h2 id="modalTitle">Tambah Produk</h2>
            <div class="modal-sub">Lengkapi informasi produk.</div>
        </div>
        <button class="close" id="closeBtn">×</button>
    </div>
    <form id="productForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="editId" name="edit_id" value="">
        <div class="form">
            <div class="field full">
                <label>Nama Produk <span style="color:#a64d47;">*</span></label>
                <input id="prodName" name="name" required placeholder="Contoh: Casual Jacket">
            </div>
            <div class="field">
                <label>Kategori <span style="color:#a64d47;">*</span></label>
                <select id="prodCategory" name="category_id" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label>Harga (Rp) <span style="color:#a64d47;">*</span></label>
                <input id="prodPrice" name="price" type="number" min="0" required placeholder="0">
            </div>
            <div class="field">
                <label>Stok <span style="color:#a64d47;">*</span></label>
                <input id="prodStock" name="stock" type="number" min="0" required placeholder="0">
            </div>
            <div class="field">
                <label>Status <span style="color:#a64d47;">*</span></label>
                <select id="prodStatus" name="status" required>
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
            </div>
            <div class="field">
                <div class="toggle-wrap">
                    <label>Featured</label>
                    <label class="toggle">
                        <input id="prodFeatured" name="is_featured" type="checkbox" value="1">
                        <span class="slider"></span>
                    </label>
                    <span class="toggle-label" id="featuredLabel">Tidak</span>
                </div>
            </div>
            <div class="field full">
                <label>Deskripsi</label>
                <textarea id="prodDescription" name="description" placeholder="Deskripsi produk..." rows="3"></textarea>
            </div>
            <div class="field full">
                <label>Gambar Produk (Max 3)</label>
                <div id="currentImage" style="display:none;margin-bottom:12px;">
                    <img id="imagePreview" style="width:80px;height:80px;object-fit:cover;border-radius:10px;border:1px solid #e7e1d9;">
                    <div style="font-size:10px;color:#817a72;margin-top:4px;">Gambar utama saat ini</div>
                </div>
                <div id="imagePreviewContainer" style="display:none;margin-bottom:10px;display:flex;gap:10px;flex-wrap:wrap;"></div>
                <input id="prodImages" name="images[]" type="file" accept="image/*,.avif" multiple>
                <small style="font-size:10px;color:#817a72;display:block;margin-top:4px;">Maksimal 3 gambar (jpg, png, gif, avif, webp) — Max 4MB per file</small>
            </div>
        </div>
        <div class="modal-actions">
            <button type="button" class="secondary" id="cancelBtn">Batal</button>
            <button type="submit" class="primary" id="saveBtn">Simpan Produk</button>
        </div>
    </form>
</div>

<!-- TOAST -->
<div class="toast" id="toast"></div>

<script>
// Filter
function filterProducts() {
    let search = document.getElementById('search').value.toLowerCase();
    let category = document.getElementById('categoryFilter').value;
    let status = document.getElementById('statusFilter').value;
    let featured = document.getElementById('featuredFilter').value;
    let cards = document.querySelectorAll('#productGrid .product-card');
    let count = 0;

    cards.forEach(card => {
        let text = card.textContent.toLowerCase();
        let catId = card.dataset.category || '';
        let statusText = card.dataset.status || '';
        let featuredText = card.dataset.featured || '';

        let show = true;
        if (search && !text.includes(search)) show = false;
        if (category && catId != category) show = false;
        if (status && statusText != status) show = false;
        if (featured && featuredText != featured) show = false;

        card.style.display = show ? '' : 'none';
        if (show) count++;
    });
}

document.getElementById('search').addEventListener('keyup', filterProducts);
document.getElementById('categoryFilter').addEventListener('change', filterProducts);
document.getElementById('statusFilter').addEventListener('change', filterProducts);
document.getElementById('featuredFilter').addEventListener('change', filterProducts);

document.getElementById('resetBtn').addEventListener('click', function() {
    document.getElementById('search').value = '';
    document.getElementById('categoryFilter').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('featuredFilter').value = '';
    filterProducts();
});

// Toggle Featured
document.getElementById('prodFeatured').addEventListener('change', function() {
    let label = document.getElementById('featuredLabel');
    label.textContent = this.checked ? 'Ya' : 'Tidak';
    label.style.color = this.checked ? '#9b7654' : '#817a72';
});

// Modal
const modalBg = document.getElementById('modalBg');
const modal = document.getElementById('modal');
const modalTitle = document.getElementById('modalTitle');
const form = document.getElementById('productForm');
const editId = document.getElementById('editId');

// Preview Images
document.getElementById('prodImages').addEventListener('change', function() {
    const files = this.files;
    const container = document.getElementById('imagePreviewContainer');
    container.innerHTML = '';
    if (files.length === 0) { container.style.display = 'none'; return; }
    if (files.length > 3) { alert('Maksimal 3 gambar!'); this.value = ''; container.style.display = 'none'; return; }
    const maxSize = 4 * 1024 * 1024;
    for (let i = 0; i < files.length; i++) {
        if (files[i].size > maxSize) { alert('File ' + files[i].name + ' melebihi 4MB!'); this.value = ''; container.style.display = 'none'; return; }
    }
    container.style.display = 'flex';
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.style.cssText = 'position:relative;width:80px;height:80px;border-radius:10px;overflow:hidden;border:1px solid #e7e1d9;';
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width:100%;height:100%;object-fit:cover;';
            const info = document.createElement('div');
            info.style.cssText = 'position:absolute;bottom:0;left:0;right:0;background:rgba(0,0,0,0.6);color:#fff;font-size:7px;text-align:center;padding:2px;';
            info.textContent = (i+1) + '/' + files.length + ' ' + (file.size/1024).toFixed(0) + 'KB';
            div.appendChild(img); div.appendChild(info); container.appendChild(div);
        };
        reader.readAsDataURL(file);
    }
});

function openModal(title, data = null) {
    modalTitle.textContent = title;
    form.reset();
    document.getElementById('currentImage').style.display = 'none';
    document.getElementById('editId').value = '';
    document.getElementById('prodFeatured').checked = false;
    document.getElementById('featuredLabel').textContent = 'Tidak';
    document.getElementById('featuredLabel').style.color = '#817a72';
    document.getElementById('prodImages').value = '';
    document.getElementById('imagePreviewContainer').innerHTML = '';
    document.getElementById('imagePreviewContainer').style.display = 'none';
    form.action = '{{ route("admin.products.store") }}';
    let methodInput = document.querySelector('input[name="_method"]');
    if (methodInput) methodInput.remove();
    if (data) {
        editId.value = data.id;
        document.getElementById('prodName').value = data.name;
        document.getElementById('prodCategory').value = data.category;
        document.getElementById('prodPrice').value = data.price;
        document.getElementById('prodStock').value = data.stock;
        document.getElementById('prodStatus').value = data.status;
        document.getElementById('prodDescription').value = data.description || '';
        if (data.featured == '1') { document.getElementById('prodFeatured').checked = true; document.getElementById('featuredLabel').textContent = 'Ya'; document.getElementById('featuredLabel').style.color = '#9b7654'; }
        if (data.image) { document.getElementById('currentImage').style.display = 'block'; document.getElementById('imagePreview').src = '{{ asset("storage") }}/' + data.image; }
        form.action = '{{ url("admin/products") }}/' + data.id;
        let methodInput = document.createElement('input');
        methodInput.type = 'hidden'; methodInput.name = '_method'; methodInput.value = 'PUT';
        form.appendChild(methodInput);
    }
    modalBg.classList.add('show');
    modal.classList.add('show');
}

function closeModal() {
    modalBg.classList.remove('show');
    modal.classList.remove('show');
    document.getElementById('imagePreviewContainer').innerHTML = '';
    document.getElementById('imagePreviewContainer').style.display = 'none';
    document.getElementById('prodImages').value = '';
}

document.getElementById('addBtn').addEventListener('click', function() { openModal('Tambah Produk'); });

document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', function() {
        openModal('Edit Produk', {
            id: this.dataset.id, name: this.dataset.name, category: this.dataset.category,
            price: this.dataset.price, stock: this.dataset.stock, status: this.dataset.status,
            description: this.dataset.description, image: this.dataset.image || null,
            featured: this.dataset.featured || '0'
        });
    });
});

document.getElementById('closeBtn').addEventListener('click', closeModal);
document.getElementById('cancelBtn').addEventListener('click', closeModal);
modalBg.addEventListener('click', closeModal);

// Toast
function showToast(message) {
    let toast = document.getElementById('toast');
    toast.textContent = message;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 2500);
}
@if(session('success')) showToast('{{ session('success') }}'); @endif
</script>
@endsection
