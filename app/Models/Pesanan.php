<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function Produk() {
        return $this->belongsTo(Produk::class);
    }

    public function Transaksi() {
        return $this->hasMany(Transaksi::class);
    }
}
