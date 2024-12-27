<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\PhpWord;
use Illuminate\Support\Facades\Session;
use PhpOffice\PhpWord\IOFactory;

class PembelianController extends Controller
{
    public function pembelian(Request $request)
    {
        $user = Auth::user();
        $kategori = Kategori::all();
        $pesanan = Pesanan::where('status', 'pending')->with('produk')->get();

        $totalHargaKeseluruhan = $pesanan->sum('total_harga');

        $kategori_id = $request->get('kategori');
        $search = $request->get('search');

        $produk = Produk::with('kategori')
            ->when($kategori_id, function ($query) use ($kategori_id) {
                return $query->where('kategori_id', $kategori_id);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where('nama', 'like', '%' . $search . '%');
            })
            ->get();

        return view('pages.kasir.pembelian.index', compact('produk', 'kategori', 'pesanan', 'totalHargaKeseluruhan', 'user'));
    }

    public function postPembelian(Request $request)
    {
        $validated = $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|integer',
        ]);

        // Ambil produk berdasarkan ID
        $produk = Produk::find($validated['produk_id']);

        // Cek apakah stok produk mencukupi
        if ($produk->stok <= 0) {
            return redirect()->back()->with('error', 'Stok produk tidak tersedia.');
        }

        // Cek apakah jumlah yang dipesan melebihi stok
        if ($produk->stok < $validated['jumlah']) {
            return redirect()->back()->with('error', 'Jumlah yang dipesan melebihi stok yang tersedia.');
        }

        // Hitung total harga
        $totalHarga = $validated['harga'] * $validated['jumlah'];

        // Buat pesanan
        Pesanan::create([
            'produk_id' => $validated['produk_id'],
            'jumlah' => $validated['jumlah'],
            'total_harga' => $totalHarga,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil ditambahkan');
    }

    public function postPembayaran(Request $request)
    {
        // Validasi input
        $request->validate([
            'total_pembayaran' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0',
            'kembalian' => 'required|numeric|min:0',
        ]);

        // Hitung total harga keseluruhan dari pesanan yang statusnya 'pending'
        $totalHargaKeseluruhan = Pesanan::where('status', 'pending')->sum('total_harga');

        // Hitung harga setelah diskon
        $diskon = $request->diskon ?? 0;
        $hargaSetelahDiskon = $totalHargaKeseluruhan - ($totalHargaKeseluruhan * ($diskon / 100));

        // Hitung kembalian
        $kembalian = $request->total_pembayaran - $hargaSetelahDiskon;

        // Simpan data transaksi
        $transaksi = Transaksi::create([
            'kode_pesanan' => strtoupper(Str::random(8)), // Generate 8 huruf kapital
            'total_harga' => $totalHargaKeseluruhan,
            'total_pembayaran' => $request->total_pembayaran,
            'diskon' => $diskon,
            'kembalian' => $kembalian,
        ]);

        // Ambil semua pesanan yang statusnya 'pending'
        $pesananList = Pesanan::where('status', 'pending')->get();

        // Loop melalui pesanan dan kurangi stok produk
        foreach ($pesananList as $pesanan) {
            $produk = $pesanan->produk; // Mendapatkan produk terkait dengan pesanan
            $produk->stok -= $pesanan->jumlah; // Kurangi stok produk sesuai jumlah yang dipesan
            $produk->save(); // Simpan perubahan stok
        }

        // Ubah status pada tabel Pesanan menjadi "pembayaran"
        Pesanan::where('status', 'pending')->update(['status' => 'pembayaran']);

        return redirect()->route('invoice', ['transaksi' => $transaksi->id])->with('success', 'Pembayaran berhasil diproses!');
    }

    public function invoice($transaksiId)
    {
        // Ambil data transaksi dan pesanan dengan status 'pembayaran'
        $transaksi = Transaksi::findOrFail($transaksiId);
        $pesanan = Pesanan::where('status', 'pembayaran')->get();

        return view('pages.kasir.pembelian.invoice', compact('transaksi', 'pesanan'));
    }

    public function cetakStruk($id)
    {
        // Ambil data transaksi berdasarkan ID
        $transaksi = Transaksi::findOrFail($id);
        $pesanans = Pesanan::where('status', 'pembayaran')->get();

        // Buat objek PhpWord
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Judul Invoice
        $section->addText('Lumi Store', [
            'bold' => true,
            'size' => 16,
            'alignment' => 'center'
        ]);
        $section->addText('Invoice Pembayaran', [
            'bold' => true,
            'size' => 16,
            'alignment' => 'center'
        ]);
        $section->addTextBreak(1);

        // Informasi Transaksi
        $section->addText('Kode Pesanan: ' . $transaksi->kode_pesanan, ['bold' => true]);
        $section->addText('Tanggal: ' . $transaksi->created_at->format('d-m-Y H:i:s'));
        $section->addTextBreak(1);

        // Detail Pesanan (Tabel)
        $table = $section->addTable();

        // Header Tabel
        $table->addRow();
        $table->addCell(2000)->addText('No', ['bold' => true]);
        $table->addCell(4000)->addText('Produk', ['bold' => true]);
        $table->addCell(2000)->addText('Jumlah', ['bold' => true]);
        $table->addCell(2000)->addText('Total Harga', ['bold' => true]);

        // Data Pesanan
        foreach ($pesanans as $index => $pesanan) {
            $table->addRow();
            $table->addCell(2000)->addText($index + 1);
            $table->addCell(4000)->addText($pesanan->produk->nama);
            $table->addCell(2000)->addText($pesanan->jumlah . 'x');
            $table->addCell(2000)->addText('Rp' . number_format($pesanan->total_harga, 0, ',', '.'));
        }

        $section->addTextBreak(1);

        // Ringkasan Pembayaran
        $section->addText('Ringkasan Pembayaran:', ['bold' => true, 'size' => 14]);
        $section->addText('Total Harga Keseluruhan: Rp' . number_format($transaksi->total_harga, 0, ',', '.'));
        $section->addText('Total Pembayaran: Rp' . number_format($transaksi->total_pembayaran, 0, ',', '.'));
        $section->addText('Diskon: ' . $transaksi->diskon . '%');
        $section->addText('Kembalian: Rp' . number_format($transaksi->kembalian, 0, ',', '.'));

        // Footer
        $section->addTextBreak(2);
        $section->addText('Terima kasih telah berbelanja di toko kami.', ['italic' => true, 'size' => 12]);

        // Simpan sebagai file Word ke public/invoice
        $fileName = 'invoice-' . $transaksi->kode_pesanan . '.docx';
        $filePath = public_path('invoice/' . $fileName);
        $phpWord->save($filePath, 'Word2007');

        Transaksi::where('id', $transaksi->id)->update(['invoice' => $fileName]);

        // Ubah status pada tabel Pesanan menjadi "pembayaran"
        Pesanan::where('status', 'pembayaran')->update(['status' => 'selesai']);
        // Return file download response
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function selesai($id)
    {
        // Ambil data transaksi berdasarkan ID
        $transaksi = Transaksi::findOrFail($id);
        $pesanans = Pesanan::where('status', 'pembayaran')->get();

        // Buat objek PhpWord
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Judul Invoice
        $section->addText('Lumi Store', [
            'bold' => true,
            'size' => 16,
            'alignment' => 'center'
        ]);
        $section->addText('Invoice Pembayaran', [
            'bold' => true,
            'size' => 16,
            'alignment' => 'center'
        ]);
        $section->addTextBreak(1);

        // Informasi Transaksi
        $section->addText('Kode Pesanan: ' . $transaksi->kode_pesanan, ['bold' => true]);
        $section->addText('Tanggal: ' . $transaksi->created_at->format('d-m-Y H:i:s'));
        $section->addTextBreak(1);

        // Detail Pesanan (Tabel)
        $table = $section->addTable();

        // Header Tabel
        $table->addRow();
        $table->addCell(2000)->addText('No', ['bold' => true]);
        $table->addCell(4000)->addText('Produk', ['bold' => true]);
        $table->addCell(2000)->addText('Jumlah', ['bold' => true]);
        $table->addCell(2000)->addText('Total Harga', ['bold' => true]);

        // Data Pesanan
        foreach ($pesanans as $index => $pesanan) {
            $table->addRow();
            $table->addCell(2000)->addText($index + 1);
            $table->addCell(4000)->addText($pesanan->produk->nama);
            $table->addCell(2000)->addText($pesanan->jumlah . 'x');
            $table->addCell(2000)->addText('Rp' . number_format($pesanan->total_harga, 0, ',', '.'));
        }

        $section->addTextBreak(1);

        // Ringkasan Pembayaran
        $section->addText('Ringkasan Pembayaran:', ['bold' => true, 'size' => 14]);
        $section->addText('Total Harga Keseluruhan: Rp' . number_format($transaksi->total_harga, 0, ',', '.'));
        $section->addText('Total Pembayaran: Rp' . number_format($transaksi->total_pembayaran, 0, ',', '.'));
        $section->addText('Diskon: ' . $transaksi->diskon . '%');
        $section->addText('Kembalian: Rp' . number_format($transaksi->kembalian, 0, ',', '.'));

        // Footer
        $section->addTextBreak(2);
        $section->addText('Terima kasih telah berbelanja di toko kami.', ['italic' => true, 'size' => 12]);

        // Simpan sebagai file Word ke public/invoice
        $fileName = 'invoice-' . $transaksi->kode_pesanan . '.docx';
        $filePath = public_path('invoice/' . $fileName);
        $phpWord->save($filePath, 'Word2007');

        Transaksi::where('id', $transaksi->id)->update(['invoice' => $fileName]);


        // Ubah status pada tabel Pesanan menjadi "selesai"
        Pesanan::where('status', 'pembayaran')->update(['status' => 'selesai']);

        // Tambahkan session untuk redirect
        session()->flash('redirect_after_download', route('pembelian'));

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function hapusPesanan($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        return redirect()->back()->with('success', 'Pesanan berhasil dihapus');
    }

    public function editPesanan(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'pesanan_id' => 'required|exists:pesanans,id', // Pastikan pesanan ada
            'jumlah' => 'required|integer|min:1', // Pastikan jumlah yang dimasukkan adalah angka yang valid
        ]);

        // Cari pesanan berdasarkan ID
        $pesanan = Pesanan::findOrFail($request->pesanan_id);

        // Ambil produk terkait
        $produk = $pesanan->produk;

        // Cek apakah jumlah yang diubah melebihi stok produk
        if ($request->jumlah > $produk->stok) {
            // Jika jumlah melebihi stok, kirim pesan error
            return redirect()->back()->with('error', 'Jumlah yang dimasukkan melebihi stok produk yang tersedia.');
        }

        // Jika jumlah valid, update pesanan
        $pesanan->jumlah = $request->jumlah;
        $pesanan->total_harga = $produk->harga * $request->jumlah; // Update total harga
        $pesanan->save();

        // Kirimkan pesan sukses
        return redirect()->back()->with('success', 'Pesanan berhasil diperbarui');
    }
}
