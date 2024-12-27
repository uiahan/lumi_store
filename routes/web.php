<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LabaKeuntunganController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/postLogin', [AuthController::class, 'postLogin'])->name('postLogin');

Route::middleware('auth')->group(function () {
    Route::put('/editPesanan', [PembelianController::class, 'editPesanan'])->name('editPesanan');
    Route::get('/invoice/{transaksi}', [PembelianController::class, 'invoice'])->name('invoice');
    Route::get('/kategori', [KategoriController::class, 'kategori'])->name('kategori');
    Route::put('/kategori/{id}', [KategoriController::class, 'editKategori'])->name('kategori.update');
    Route::post('/tambahKategori', [KategoriController::class, 'tambahKategori'])->name('tambahKategori');
    Route::get('/labaKeuntungan', [LabaKeuntunganController::class, 'labaKeuntungan'])->name('labaKeuntungan');
    Route::post('/tambahProduk', [ProdukController::class, 'tambahProduk'])->name('tambahProduk');
    Route::get('/cetakStruk/{id}', [PembelianController::class, 'cetakStruk'])->name('cetakStruk');
    Route::get('/hapusProduk/{id}', [ProdukController::class, 'hapusProduk'])->name('hapusProduk');
    Route::put('/editBarang/{id}', [ProdukController::class, 'editBarang'])->name('editBarang');
    Route::get('/selesai/{id}', [PembelianController::class, 'selesai'])->name('selesai');
    Route::get('/hapusPesanan/{id}', [PembelianController::class, 'hapusPesanan'])->name('hapusPesanan');
    Route::get('/hapusKategori/{id}', [KategoriController::class, 'hapusKategori'])->name('hapusKategori');
    Route::get('/pembelian', [PembelianController::class, 'pembelian'])->name('pembelian');
    Route::get('/produk', [ProdukController::class, 'produk'])->name('produk');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/riwayat', [RiwayatController::class, 'riwayat'])->name('riwayat');
    Route::post('/postPembelian', [PembelianController::class, 'postPembelian'])->name('postPembelian');
    Route::post('/postPembayaran', [PembelianController::class, 'postPembayaran'])->name('postPembayaran');
});
