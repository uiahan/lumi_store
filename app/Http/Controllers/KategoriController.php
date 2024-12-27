<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function kategori()
    {
        $user = Auth::user();
        $kategori = Kategori::all();
        return view('pages.admin.kategori.index', compact('kategori', 'user'));
    }

    public function editKategori(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategoriNama = strtolower(str_replace(' ', '-', $request->input('nama')));

        $kategori->nama = $request->input('nama');

        if ($request->hasFile('photo')) {
            if ($kategori->photo && file_exists(public_path($kategori->photo))) {
                unlink(public_path($kategori->photo));
            }

            $extension = $request->file('photo')->getClientOriginalExtension();
            $photoPath = 'image/' . $kategoriNama . '.' . $extension;
            $request->file('photo')->move(public_path('image'), $photoPath);
            $kategori->photo = $photoPath;
        }
        $kategori->save();

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function tambahKategori(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $kategori = new Kategori();
        $kategori->nama = $request->input('nama');

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = 'image/' . strtolower(str_replace(' ', '-', $kategori->nama)) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('image'), $photoPath);
            $kategori->photo = $photoPath;
        }

        $kategori->save();

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function hapusKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->back()->with('success', 'Pesanan berhasil dihapus');
    }
}
