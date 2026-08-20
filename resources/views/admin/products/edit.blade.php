@extends('layouts.admin')

@section('breadcrumb')
    Admin / <a href="{{ route('admin.products.index') }}">Produk</a> / <b>Edit</b>
@endsection

@section('content')
<div class="heading">
    <div>
        <div class="eyebrow">Product Management</div>
        <h1>Edit Produk</h1>
        <p>Update informasi produk.</p>
    </div>
</div>

<div style="background:#fff;border:1px solid var(--line);border-radius:15px;padding:28px;max-width:800px;">
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;">
            <div style="grid-column:1/-1;">
                <label style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;display:block;margin-bottom:5px;">Nama Produk</label>
                <input type="text" name="name" class="form-control" style="width:100%;border:1px solid var(--line);border-radius:9px;padding:11px 12px;background:#faf8f5;outline:0;font-size:12px;" value="{{ old('name', $product->name) }}" required>
                @error('name') <small style="color:red;">{{ $message }}</small> @enderror
            </div>

            <div>
                <label style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;display:block;margin-bottom:5px;">Kategori</label>
                <select name="category_id" style="width:100%;border:1px solid var(--line);border-radius:9px;padding:11px 12px;background:#faf8f5;outline:0;font-size:12px;" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <small style="color:red;">{{ $message }}</small> @enderror
            </div>

            <div>
                <label style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;display:block;margin-bottom:5px;">Harga (Rp)</label>
                <input type="number" name="price" class="form-control" style="width:100%;border:1px solid var(--line);border-radius:9px;padding:11px 12px;background:#faf8f5;outline:0;font-size:12px;" min="0" value="{{ old('price', $product->price) }}" required>
                @error('price') <small style="color:red;">{{ $message }}</small> @enderror
            </div>

            <div>
                <label style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;display:block;margin-bottom:5px;">Stok</label>
                <input type="number" name="stock" class="form-control" style="width:100%;border:1px solid var(--line);border-radius:9px;padding:11px 12px;background:#faf8f5;outline:0;font-size:12px;" min="0" value="{{ old('stock', $product->stock) }}" required>
                @error('stock') <small style="color:red;">{{ $message }}</small> @enderror
            </div>

            <div>
                <label style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;display:block;margin-bottom:5px;">Status</label>
                <select name="status" style="width:100%;border:1px solid var(--line);border-radius:9px;padding:11px 12px;background:#faf8f5;outline:0;font-size:12px;" required>
                    <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status') <small style="color:red;">{{ $message }}</small> @enderror
            </div>

            <div>
                <label style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;display:block;margin-bottom:5px;">Featured</label>
                <input type="checkbox" name="is_featured" value="1" style="width:20px;height:20px;" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
            </div>

            <div style="grid-column:1/-1;">
                <label style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;display:block;margin-bottom:5px;">Deskripsi</label>
                <textarea name="description" style="width:100%;border:1px solid var(--line);border-radius:9px;padding:11px 12px;background:#faf8f5;outline:0;font-size:12px;min-height:80px;">{{ old('description', $product->description) }}</textarea>
            </div>

            <div style="grid-column:1/-1;">
                <label style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;display:block;margin-bottom:5px;">Gambar Produk</label>
                @if($product->image)
                    <div style="margin-bottom:10px;">
                        <img src="{{ asset('storage/' . $product->image) }}" style="width:80px;height:80px;object-fit:cover;border-radius:8px;">
                    </div>
                @endif
                <input type="file" name="image" style="width:100%;border:1px solid var(--line);border-radius:9px;padding:11px 12px;background:#faf8f5;outline:0;font-size:12px;" accept="image/*">
            </div>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:9px;margin-top:22px;">
            <a href="{{ route('admin.products.index') }}" class="secondary" style="border:1px solid var(--line);background:#fff;padding:12px 17px;border-radius:10px;font-size:11px;text-decoration:none;color:var(--ink);">Batal</a>
            <button type="submit" class="primary" style="border:0;background:var(--dark);color:#fff;border-radius:11px;padding:13px 18px;font-size:12px;font-weight:700;">Update Produk</button>
        </div>
    </form>
</div>
@endsection
