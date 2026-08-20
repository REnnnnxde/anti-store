@extends('layouts.admin')

@section('content')
<style>
    .product-detail {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
        background: #fff;
        border-radius: 16px;
        padding: 32px;
        border: 1px solid #f0edea;
    }

    .product-detail .gallery {
        position: relative;
    }

    .product-detail .gallery .main-image {
        width: 100%;
        height: 400px;
        border-radius: 12px;
        overflow: hidden;
        background: #f6f3ee;
        border: 1px solid #f0edea;
    }

    .product-detail .gallery .main-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-detail .gallery .main-image .no-img {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #c9c0b4;
        font-size: 14px;
    }

    .product-detail .gallery .thumbnails {
        display: flex;
        gap: 10px;
        margin-top: 14px;
        flex-wrap: wrap;
    }

    .product-detail .gallery .thumbnails .thumb {
        width: 70px;
        height: 70px;
        border-radius: 10px;
        overflow: hidden;
        border: 2px solid #f0edea;
        cursor: pointer;
        transition: all 0.3s;
        background: #f6f3ee;
    }

    .product-detail .gallery .thumbnails .thumb:hover,
    .product-detail .gallery .thumbnails .thumb.active {
        border-color: #9b7654;
    }

    .product-detail .gallery .thumbnails .thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-detail .gallery .thumbnails .thumb .no-img-small {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 8px;
        color: #c9c0b4;
    }

    .product-detail .info-section {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .product-detail .info-section .category {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #9b7654;
        font-weight: 600;
    }

    .product-detail .info-section .name {
        font-size: 28px;
        font-weight: 500;
        font-family: 'Playfair Display', serif;
        color: #1a1410;
        margin: 0;
        line-height: 1.2;
    }

    .product-detail .info-section .slug {
        font-size: 13px;
        color: #b3aa9e;
        margin-top: -4px;
    }

    .product-detail .info-section .price {
        font-size: 24px;
        font-weight: 700;
        color: #1a1410;
        padding: 12px 0;
        border-top: 1px solid #f0edea;
        border-bottom: 1px solid #f0edea;
    }

    .product-detail .info-section .price small {
        font-size: 14px;
        font-weight: 400;
        color: #817a72;
    }

    .product-detail .info-section .meta-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .product-detail .info-section .meta-grid .meta-item {
        background: #faf8f5;
        padding: 14px 16px;
        border-radius: 10px;
        border: 1px solid #f0edea;
    }

    .product-detail .info-section .meta-grid .meta-item .label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #817a72;
        font-weight: 600;
    }

    .product-detail .info-section .meta-grid .meta-item .value {
        font-size: 16px;
        font-weight: 600;
        color: #1a1410;
        margin-top: 2px;
    }

    .product-detail .info-section .meta-grid .meta-item .value .badge-status {
        font-size: 12px;
        font-weight: 600;
        padding: 4px 14px;
        border-radius: 20px;
        display: inline-block;
    }

    .product-detail .info-section .meta-grid .meta-item .value .badge-status.active { background: #e6f0ea; color: #2d7a5a; }
    .product-detail .info-section .meta-grid .meta-item .value .badge-status.inactive { background: #f7e3e2; color: #a64d47; }
    .product-detail .info-section .meta-grid .meta-item .value .badge-status.featured { background: #f5efe5; color: #b8954a; }

    .product-detail .info-section .description {
        margin-top: 8px;
    }

    .product-detail .info-section .description .label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #817a72;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .product-detail .info-section .description p {
        font-size: 14px;
        line-height: 1.7;
        color: #4a4038;
        margin: 0;
    }

    .product-detail .info-section .actions {
        display: flex;
        gap: 10px;
        margin-top: 8px;
        padding-top: 16px;
        border-top: 1px solid #f0edea;
    }

    .product-detail .info-section .actions .btn-edit {
        padding: 10px 24px;
        border: 1px solid #1a1410;
        border-radius: 10px;
        background: #1a1410;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .product-detail .info-section .actions .btn-edit:hover {
        background: #3a342f;
        border-color: #3a342f;
    }

    .product-detail .info-section .actions .btn-back {
        padding: 10px 24px;
        border: 1px solid #e7e1d9;
        border-radius: 10px;
        background: #fff;
        color: #1a1410;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .product-detail .info-section .actions .btn-back:hover {
        background: #f6f3ee;
        border-color: #9b7654;
    }

    .gallery-section-title {
        font-size: 12px;
        font-weight: 600;
        color: #817a72;
        margin-bottom: 12px;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    @media (max-width: 768px) {
        .product-detail {
            grid-template-columns: 1fr;
            padding: 20px;
        }
        .product-detail .gallery .main-image {
            height: 280px;
        }
        .product-detail .info-section .name {
            font-size: 22px;
        }
        .product-detail .info-section .meta-grid {
            grid-template-columns: 1fr;
        }
        .product-detail .info-section .actions {
            flex-direction: column;
        }
        .product-detail .info-section .actions .btn-edit,
        .product-detail .info-section .actions .btn-back {
            justify-content: center;
        }
    }
</style>

<div style="margin-bottom:24px;">
    <div style="font-size:10px;text-transform:uppercase;letter-spacing:0.16em;color:#9b7654;font-weight:700;">Product Detail</div>
    <h1 style="font-size:30px;font-weight:500;font-family:'Playfair Display',serif;margin:4px 0 2px;color:#1a1410;">{{ $product->name }}</h1>
    <p style="font-size:13px;color:#817a72;margin:0;">Detail lengkap produk.</p>
</div>

<div class="product-detail">
    <!-- GALLERY -->
    <div class="gallery">
        <div class="main-image">
            @if($product->image_base64)
                <img src="{{ $product->image_base64 }}" alt="{{ $product->name }}" id="mainImage">
            @else
                <div class="no-img">No image available</div>
            @endif
        </div>
        @if($product->galleries->count() > 0 || $product->image)
        <div>
            <div class="gallery-section-title">Gallery</div>
            <div class="thumbnails" id="thumbnails">
                @if($product->image)
                    <div class="thumb active" onclick="changeImage(this, '{{ $product->image_base64 ?? '' }}')">
                        @if($product->image_base64)
                            <img src="{{ $product->image_base64 }}" alt="Main">
                        @else
                            <div class="no-img-small">No img</div>
                        @endif
                    </div>
                @endif
                @foreach($product->galleries as $gallery)
                    @php
                        $path = storage_path('app/public/' . $gallery->image);
                        $base64 = null;
                        if (file_exists($path)) {
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            $data = file_get_contents($path);
                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        }
                    @endphp
                    @if($base64)
                        <div class="thumb" onclick="changeImage(this, '{{ $base64 }}')">
                            <img src="{{ $base64 }}" alt="Gallery">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- INFO -->
    <div class="info-section">
        <div>
            <div class="category">{{ $product->category->name ?? 'Uncategorized' }}</div>
            <div class="name">{{ $product->name }}</div>
            <div class="slug">{{ $product->slug ?? '' }}</div>
        </div>

        <div class="price">Rp {{ number_format($product->price, 0, ',', '.') }} <small>IDR</small></div>

        <div class="meta-grid">
            <div class="meta-item">
                <div class="label">Stok</div>
                <div class="value">{{ $product->stock }} pcs</div>
            </div>
            <div class="meta-item">
                <div class="label">Status</div>
                <div class="value">
                    <span class="badge-status {{ $product->status }}">
                        {{ $product->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
            </div>
            <div class="meta-item">
                <div class="label">Featured</div>
                <div class="value">
                    <span class="badge-status {{ $product->is_featured ? 'featured' : '' }}">
                        {{ $product->is_featured ? '★ Featured' : '☆ Non-Featured' }}
                    </span>
                </div>
            </div>
            <div class="meta-item">
                <div class="label">Total Gambar</div>
                <div class="value">{{ $product->galleries->count() + 1 }} file</div>
            </div>
        </div>

        @if($product->description)
        <div class="description">
            <div class="label">Deskripsi</div>
            <p>{{ $product->description }}</p>
        </div>
        @endif

        <div class="actions">
            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-edit">✎ Edit Produk</a>
            <a href="{{ route('admin.products.index') }}" class="btn-back">← Kembali</a>
        </div>
    </div>
</div>

<script>
function changeImage(element, src) {
    // Update main image
    document.getElementById('mainImage').src = src;

    // Update active state
    document.querySelectorAll('#thumbnails .thumb').forEach(el => {
        el.classList.remove('active');
    });
    element.classList.add('active');
}
</script>
@endsection
