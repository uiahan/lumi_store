<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabaKeuntunganController extends Controller
{
    public function labaKeuntungan()
    {
        $user = Auth::user();
        $data = Transaksi::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total_harga) as total_harga, SUM(total_harga - (total_harga * (diskon / 100))) as total_keuntungan')
                         ->groupByRaw('MONTH(created_at), YEAR(created_at)')
                         ->orderBy('year', 'desc')
                         ->orderBy('month', 'desc')
                         ->get();

        // Kirim data ke view
        return view('pages.owner.laba_keuntungan.index', compact('data', 'user'));
    }
}
