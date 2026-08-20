<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();

        // Konversi gambar ke base64 untuk bypass 403 (SAMA SEPERTI PRODUK)
        foreach ($categories as $category) {
            $category->image_base64 = $this->getImageBase64($category->image);
        }

        return view('admin.categories.index', compact('categories'));
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

    private function saveImage($file)
    {
        // Buat nama file UNIK dengan timestamp
        $extension = $file->getClientOriginalExtension();
        $imageName = time() . '_' . uniqid() . '.' . $extension;

        // Simpan ke storage/app/public/categories/
        $path = $file->storeAs('categories', $imageName, 'public');

        if (!$path) {
            Log::error("Gagal menyimpan gambar: " . $imageName);
            return null;
        }

        return $path; // contoh: "categories/169999_abc.jpg"
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,avif,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ];

        // Proses upload gambar
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $this->saveImage($file);

            if ($path) {
                $data['image'] = $path;
            }
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori "' . $request->name . '" berhasil ditambahkan!');
    }

    public function show($id)
    {
        $category = Category::withCount('products')->findOrFail($id);

        // Konversi gambar ke base64
        if ($category->image) {
            $path = storage_path('app/public/' . $category->image);
            if (file_exists($path)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $category->image_base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
        }

        return view('admin.categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,avif,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ];

        // Proses upload gambar baru (jika ada)
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $file = $request->file('image');
            $path = $this->saveImage($file);

            if ($path) {
                $data['image'] = $path;
            }
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori "' . $category->name . '" berhasil diupdate!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Hapus gambar
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
