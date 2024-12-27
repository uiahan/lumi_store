<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function Kategori() {
        return $this->belongsTo(Kategori::class);
    }

    public function Pesanan() {
        return $this->hasMany(Pesanan::class);
    }
}
