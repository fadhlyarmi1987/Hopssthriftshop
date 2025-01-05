<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('dashboard', compact('products'));
    }

    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'size' => 'nullable|string|max:50', // Validasi untuk ukuran
        'price' => 'required|numeric',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    // Simpan produk baru ke database
    $product = new Product;
    $product->name = $request->name;
    $product->category = $request->category;
    $product->size = $request->size; // Simpan ukuran
    $product->price = $request->price;
    $product->description = $request->description;

    // Cek apakah ada gambar yang diupload
    if ($request->hasFile('image')) {
        // Simpan gambar di folder storage/app/public/products
        $imagePath = $request->file('image')->store('products', 'public');
        $product->image = $imagePath; // Simpan path gambar ke database
    }

    $product->save();

    return redirect()->route('dashboard')->with('successadd', 'Produk berhasil ditambahkan');
}


    public function search(Request $request)
    {
        $query = $request->input('query');

        // Cari produk berdasarkan nama atau deskripsi
        $products = Product::where('name', 'like', '%' . $query . '%')
                           ->orWhere('description', 'like', '%' . $query . '%')
                           ->get();

        // Kembalikan hasil pencarian ke view
        return view('dashboard', compact('products'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->category = $request->category;
        $product->size = $request->size;
        $product->price = $request->price;
        $product->description = $request->description;

        // Jika ada gambar baru yang diupload
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('dashboard')->with('successupdate', 'Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Hapus produk dari database
        $product->delete();

        return redirect()->route('dashboard')->with('successhapus', 'Produk berhasil dihapus');
    }

    public function showKaos()
    {
        $kaos = Product::where('category', 'Kaos')->get(); 

        // Pass the 'kaos' variable to the Blade view
        return view('products.kaos', compact('kaos'));
    }

    public function showKemeja()
    {
        $kemeja = Product::where('category', 'Kemeja')->get(); 

        // Pass the 'kaos' variable to the Blade view
        return view('products.kemeja', compact('kemeja'));
    }

    public function showJaket()
    {
        $jaket = Product::where('category', 'Jaket')->get(); 

        // Pass the 'kaos' variable to the Blade view
        return view('products.jaket', compact('jaket'));
    }
}
