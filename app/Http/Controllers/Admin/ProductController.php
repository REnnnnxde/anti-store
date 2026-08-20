<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'galleries'])->get();
        $categories = Category::all();

        // Konversi gambar ke base64 untuk bypass 403
        foreach ($products as $product) {
            $product->image_base64 = $this->getImageBase64($product->image);
        }

        return view('admin.products.index', compact('products', 'categories'));
    }

    private function getImageBase64($path)
    {
        if (!$path) {
            return null;
        }

        // Cek apakah file ada di storage
        $fullPath = storage_path('app/public/' . $path);
        if (!file_exists($fullPath)) {
            Log::warning("Gambar tidak ditemukan: " . $fullPath);
            return null;
        }

        // Tentukan mime type berdasarkan ekstensi
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $mimeMap = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'avif' => 'image/avif',
            'webp' => 'image/webp',
        ];

        $mime = $mimeMap[$extension] ?? 'image/jpeg';
        $data = file_get_contents($fullPath);

        return 'data:' . $mime . ';base64,' . base64_encode($data);
    }

    private function saveImage($file, $index = 1)
    {
        // Buat nama file UNIK dengan timestamp
        $extension = $file->getClientOriginalExtension();
        $imageName = time() . '_' . $index . '_' . uniqid() . '.' . $extension;

        // Simpan ke storage/app/public/products/
        $path = $file->storeAs('products', $imageName, 'public');

        if (!$path) {
            Log::error("Gagal menyimpan gambar: " . $imageName);
            return null;
        }

        return $path; // contoh: "products/169999_1_abc.jpg"
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'images' => 'nullable|array|max:3',
            'images.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,avif,webp|max:4096', // MAX 4 MB
        ]);

        $data = $request->only([
            'name', 'category_id', 'price', 'stock', 'status', 'description'
        ]);
        $data['slug'] = Str::slug($request->name);
        $data['is_featured'] = $request->has('is_featured') ? true : false;

        $product = Product::create($data);

        // Proses upload gambar
        if ($request->hasFile('images')) {
            $files = $request->file('images');

            foreach ($files as $index => $file) {
                $path = $this->saveImage($file, $index + 1);

                if (!$path) {
                    continue;
                }

                if ($index === 0) {
                    // Gambar pertama = image utama
                    $product->image = $path;
                    $product->save();
                } else {
                    // Gambar berikutnya = gallery
                    ProductGallery::create([
                        'product_id' => $product->id,
                        'image' => $path,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk "' . $product->name . '" berhasil ditambahkan!');
    }
    public function show($id)
{
    $product = Product::with(['category', 'galleries'])->findOrFail($id);

    // Konversi gambar ke base64
    if ($product->image) {
        $path = storage_path('app/public/' . $product->image);
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $product->image_base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    }

    return view('admin.products.show', compact('product'));
}

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'images' => 'nullable|array|max:3',
            'images.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,avif,webp|max:4096', // MAX 4 MB
        ]);

        $data = $request->only([
            'name', 'category_id', 'price', 'stock', 'status', 'description'
        ]);
        $data['slug'] = Str::slug($request->name);
        $data['is_featured'] = $request->has('is_featured') ? true : false;

        $product->update($data);

        // Proses upload gambar baru (jika ada)
        if ($request->hasFile('images')) {
            // Hapus gambar utama lama
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Hapus gallery lama
            foreach ($product->galleries as $gallery) {
                Storage::disk('public')->delete($gallery->image);
                $gallery->delete();
            }

            $files = $request->file('images');

            foreach ($files as $index => $file) {
                $path = $this->saveImage($file, $index + 1);

                if (!$path) {
                    continue;
                }

                if ($index === 0) {
                    $product->image = $path;
                    $product->save();
                } else {
                    ProductGallery::create([
                        'product_id' => $product->id,
                        'image' => $path,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk "' . $product->name . '" berhasil diupdate!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar utama
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Hapus gallery
        foreach ($product->galleries as $gallery) {
            Storage::disk('public')->delete($gallery->image);
            $gallery->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
