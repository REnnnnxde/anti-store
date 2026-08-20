@extends('layouts.admin')

@section('content')
<style>
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

    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
    }

    .category-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #f0edea;
        transition: all 0.4s ease;
        position: relative;
    }

    .category-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 60px rgba(26,20,16,0.08);
        border-color: #e7e1d9;
    }

    .category-card .image-wrap {
        height: 140px;
        overflow: hidden;
        background: #f6f3ee;
        position: relative;
    }

    .category-card .image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .category-card:hover .image-wrap img {
        transform: scale(1.04);
    }

    .category-card .image-wrap .no-img {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        color: #d4c9be;
    }

    .category-card .image-wrap .category-count {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(8px);
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        color: #1a1410;
    }

    .category-card .info {
        padding: 14px 16px 16px;
    }

    .category-card .info .name {
        font-size: 16px;
        font-weight: 600;
        font-family: 'Playfair Display', serif;
        color: #1a1410;
        margin: 0;
    }

    .category-card .info .slug {
        font-size: 11px;
        color: #b3aa9e;
        margin-top: 1px;
    }

    .category-card .info .desc {
        font-size: 12px;
        color: #4a4038;
        margin-top: 6px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .category-card .info .actions {
        display: flex;
        gap: 8px;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #f0edea;
    }

    .category-card .info .actions .btn-icon {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 1px solid #e7e1d9;
        background: #fff;
        color: #1a1410;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
    }

    .category-card .info .actions .btn-icon:hover {
        background: #f6f3ee;
        border-color: #9b7654;
    }

    .category-card .info .actions .btn-icon.danger:hover {
        background: #f7e3e2;
        border-color: #a64d47;
        color: #a64d47;
    }

    .category-card .info .actions form {
        display: inline;
        margin: 0;
        padding: 0;
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
    .modal{position:fixed;z-index:21;left:50%;top:50%;transform:translate(-50%,-50%);width:min(600px,calc(100% - 30px));max-height:90vh;overflow:auto;background:#fff;border-radius:20px;padding:32px;display:none;box-shadow:0 40px 100px rgba(0,0,0,0.15)}
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

    .preview-img {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid #e7e1d9;
        margin-bottom: 10px;
    }

    .toast{position:fixed;right:28px;bottom:28px;background:#1a1410;color:#fff;padding:14px 22px;border-radius:12px;font-size:12px;z-index:50;opacity:0;transform:translateY(16px);transition:.4s ease}
    .toast.show{opacity:1;transform:translateY(0)}

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .category-grid { grid-template-columns: 1fr 1fr; gap: 16px; }
        .filter-section { flex-direction: column; align-items: stretch; padding: 16px; }
        .filter-section .filter-left { flex-direction: column; }
        .filter-section .filter-left .search-box input { width: 100%; }
        .filter-section .filter-right .btn-add { width: 100%; justify-content: center; }
        .form { grid-template-columns: 1fr; }
        .modal { padding: 20px; }
    }

    @media (max-width: 480px) {
        .category-grid { grid-template-columns: 1fr; }
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>

<!-- HEADING -->
<div style="margin-bottom:24px;">
    <div style="font-size:10px;text-transform:uppercase;letter-spacing:0.16em;color:#9b7654;font-weight:700;">Category Management</div>
    <h1 style="font-size:30px;font-weight:500;font-family:'Playfair Display',serif;margin:4px 0 2px;color:#1a1410;">Kategori</h1>
    <p style="font-size:13px;color:#817a72;margin:0;">Kelola kategori produk Anti Fashion.</p>
</div>

<!-- STATS -->
<div class="stats-grid">
    <div class="stat-item">
        <span class="stat-icon">◈</span>
        <div class="stat-number">{{ $categories->count() }}</div>
        <div class="stat-label">Total Kategori</div>
    </div>
    <div class="stat-item">
        <span class="stat-icon">▦</span>
        <div class="stat-number">{{ $categories->sum('products_count') }}</div>
        <div class="stat-label">Total Produk</div>
    </div>
    <div class="stat-item">
        <span class="stat-icon">★</span>
        <div class="stat-number">{{ $categories->where('products_count', '>', 0)->count() }}</div>
        <div class="stat-label">Kategori Terisi</div>
    </div>
    <div class="stat-item">
        <span class="stat-icon">◌</span>
        <div class="stat-number">{{ $categories->where('products_count', 0)->count() }}</div>
        <div class="stat-label">Kategori Kosong</div>
    </div>
</div>

<!-- FILTER SECTION -->
<div class="filter-section">
    <div class="filter-left">
        <div class="search-box">
            <span class="icon">⌕</span>
            <input id="search" placeholder="Cari kategori...">
        </div>
        <button class="btn-reset" id="resetBtn">↻ Reset</button>
    </div>
    <div class="filter-right">
        <button class="btn-add" id="addBtn">+ Tambah Kategori</button>
    </div>
</div>

<!-- CATEGORY GRID -->
<div class="category-grid" id="categoryGrid">
    @forelse($categories as $category)
    <div class="category-card">
        <div class="image-wrap">
            @if($category->image_base64)
                <img src="{{ $category->image_base64 }}" alt="{{ $category->name }}">
            @else
                <div class="no-img">◈</div>
            @endif
            <span class="category-count">{{ $category->products_count ?? 0 }} produk</span>
        </div>
        <div class="info">
            <div class="name">{{ $category->name }}</div>
            <div class="slug">{{ $category->slug }}</div>
            @if($category->description)
                <div class="desc">{{ $category->description }}</div>
            @endif
            <div class="actions">
                <button class="btn-icon editBtn"
                    data-id="{{ $category->id }}"
                    data-name="{{ $category->name }}"
                    data-desc="{{ $category->description }}"
                    data-image="{{ $category->image }}">✎</button>
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori {{ $category->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-icon danger">✕</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <div class="icon">◈</div>
        <h3>Belum ada kategori</h3>
        <p>Klik "Tambah Kategori" untuk memulai.</p>
    </div>
    @endforelse
</div>

<!-- MODAL -->
<div class="modal-bg" id="modalBg"></div>
<div class="modal" id="modal">
    <div class="modal-head">
        <div>
            <h2 id="modalTitle">Tambah Kategori</h2>
            <div class="modal-sub">Lengkapi informasi kategori.</div>
        </div>
        <button class="close" id="closeBtn">×</button>
    </div>
    <form id="categoryForm" action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="editId" name="edit_id" value="">
        <div class="form">
            <div class="field full">
                <label>Nama Kategori <span style="color:#a64d47;">*</span></label>
                <input id="catName" name="name" required placeholder="Contoh: Women, Men, Accessories">
            </div>
            <div class="field full">
                <label>Deskripsi</label>
                <textarea id="catDesc" name="description" placeholder="Deskripsi kategori..." rows="3"></textarea>
            </div>
            <div class="field full">
                <label>Gambar Kategori</label>
                <div id="currentImage" style="display:none;margin-bottom:10px;">
                    <img id="imagePreview" class="preview-img" alt="Current image">
                    <div style="font-size:10px;color:#817a72;">Gambar saat ini</div>
                </div>
                <input id="catImage" name="image" type="file" accept="image/*">
                <small style="font-size:10px;color:#817a72;display:block;margin-top:4px;">Format: jpg, png, gif, avif, webp — Max 2MB</small>
            </div>
        </div>
        <div class="modal-actions">
            <button type="button" class="secondary" id="cancelBtn">Batal</button>
            <button type="submit" class="primary" id="saveBtn">Simpan Kategori</button>
        </div>
    </form>
</div>

<!-- TOAST -->
<div class="toast" id="toast"></div>

<script>
// ============ FILTER SEARCH ============
function filterCategories() {
    let input = document.getElementById('search');
    let filter = input.value.toLowerCase();
    let cards = document.querySelectorAll('#categoryGrid .category-card');
    let count = 0;

    cards.forEach(card => {
        let text = card.textContent.toLowerCase();
        if (text.includes(filter)) {
            card.style.display = '';
            count++;
        } else {
            card.style.display = 'none';
        }
    });
}

document.getElementById('search').addEventListener('keyup', filterCategories);

document.getElementById('resetBtn').addEventListener('click', function() {
    document.getElementById('search').value = '';
    filterCategories();
});

// ============ MODAL ============
const modalBg = document.getElementById('modalBg');
const modal = document.getElementById('modal');
const modalTitle = document.getElementById('modalTitle');
const form = document.getElementById('categoryForm');
const editId = document.getElementById('editId');
const catName = document.getElementById('catName');
const catDesc = document.getElementById('catDesc');
const catImage = document.getElementById('catImage');

function openModal(title, data = null) {
    modalTitle.textContent = title;
    form.reset();
    document.getElementById('currentImage').style.display = 'none';
    document.getElementById('editId').value = '';
    catImage.value = '';
    form.action = '{{ route("admin.categories.store") }}';

    let methodInput = document.querySelector('input[name="_method"]');
    if (methodInput) methodInput.remove();

    if (data) {
        editId.value = data.id;
        catName.value = data.name;
        catDesc.value = data.desc || '';

        if (data.image) {
            document.getElementById('currentImage').style.display = 'block';
            document.getElementById('imagePreview').src = '{{ asset("storage") }}/' + data.image;
            document.getElementById('imagePreview').onerror = function() {
                this.parentElement.style.display = 'none';
            };
        }

        form.action = '{{ url("admin/categories") }}/' + data.id;
        let methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);
    }

    modalBg.classList.add('show');
    modal.classList.add('show');
}

function closeModal() {
    modalBg.classList.remove('show');
    modal.classList.remove('show');
}

document.getElementById('addBtn').addEventListener('click', function() {
    openModal('Tambah Kategori');
});

document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', function() {
        openModal('Edit Kategori', {
            id: this.dataset.id,
            name: this.dataset.name,
            desc: this.dataset.desc || '',
            image: this.dataset.image || null
        });
    });
});

document.getElementById('closeBtn').addEventListener('click', closeModal);
document.getElementById('cancelBtn').addEventListener('click', closeModal);
modalBg.addEventListener('click', closeModal);

// ============ PREVIEW IMAGE ============
catImage.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('currentImage').style.display = 'block';
            document.getElementById('imagePreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// ============ TOAST ============
function showToast(message) {
    let toast = document.getElementById('toast');
    toast.textContent = message;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 2500);
}

@if(session('success'))
    showToast('{{ session('success') }}');
@endif
</script>
@endsection
