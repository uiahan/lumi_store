<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function Produk()
    {
        $kategoris = Kategori::all();
        $user = Auth::user();
        $produk = Produk::with('kategori')->get();
        return view('pages.admin.produk.index', compact('produk', 'user', 'kategoris'));
    }

    public function tambahProduk(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer',
            'harga' => 'required|integer',
            'deskripsi' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Menyimpan Foto
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = 'image/' . strtolower(str_replace(' ', '-', $request->input('nama'))) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('image'), $photoPath);
        }

        // Menyimpan Produk Baru
        $produk = new Produk();
        $produk->nama = $request->input('nama');
        $produk->stok = $request->input('stok');
        $produk->harga = $request->input('harga');
        $produk->deskripsi = $request->input('deskripsi');
        $produk->kategori_id = $request->input('kategori_id');
        $produk->photo = $photoPath;
        $produk->save();

        return redirect()->route('produk')->with('success', 'Produk berhasil ditambahkan!');
    }


    public function editBarang(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer',
            'harga' => 'required|integer',
            'deskripsi' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->nama = $request->input('nama');
        $produk->stok = $request->input('stok');
        $produk->harga = $request->input('harga');
        $produk->deskripsi = $request->input('deskripsi');
        $produk->kategori_id = $request->input('kategori_id');

        // Mengupdate foto jika ada foto baru
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = 'image/' . strtolower(str_replace(' ', '-', $produk->nama)) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('image'), $photoPath);
            $produk->photo = $photoPath;
        }

        $produk->save();

        return redirect()->back()->with('success', 'Produk berhasil diperbarui!');
    }

    public function hapusProduk($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->back()->with('success', 'Pesanan berhasil dihapus');
    }
}
