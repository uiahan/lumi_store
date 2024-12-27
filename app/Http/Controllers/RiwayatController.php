<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function riwayat(Request $request) {
        $user = Auth::user();
        $transaksi = Transaksi::orderBy('created_at', 'desc');
    
        // Menambahkan filter berdasarkan tanggal jika ada
        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $tanggal_awal = $request->input('tanggal_awal');
            $tanggal_akhir = $request->input('tanggal_akhir');
            
            // Memfilter transaksi berdasarkan rentang tanggal
            $transaksi = $transaksi->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir]);
        }
    
        // Mengambil data transaksi
        $transaksi = $transaksi->get();
    
        return view('pages.kasir.riwayat.index', compact('transaksi', 'user'));
    }
    
}
