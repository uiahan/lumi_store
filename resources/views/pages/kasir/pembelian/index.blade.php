@extends('layout.master')
@section('title', 'Pembelian')
@section('content')

    <section class="pembelian-section pb-5" style="background-color: #f8f8f8">
        @include('components.navbar')
        <div class="container">
            {{-- carousel --}}
            <div id="carouselExampleIndicators" class="carousel slide mt-5 shadow rounded-4">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner rounded-4" style="height: 20rem">
                    <div class="carousel-item active">
                        <img src="{{ asset('image/carousel-3.jpg') }}" style="object-fit: cover" class="d-block w-100"
                            alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('image/carousel-1.jpg') }}" style="object-fit: cover" class="d-block w-100"
                            alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('image/carousel-2.png') }}" style="object-fit: cover" class="d-block w-100"
                            alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            {{-- category --}}
            <div class="card mt-5 p-4 shadow border-0">
                <h5 class="fw-bold">Kategori</h5>
                <p class="text-secondary">Pilih barang sesuai kategori yang diinginkan</p>
                <div>
                    <a href="{{ route('pembelian') }}" class="btn border rounded-4 me-1">semua</a>
                    @foreach ($kategori as $item)
                        <a href="{{ route('pembelian', ['kategori' => $item->id]) }}" class="btn border rounded-4 me-1"><img
                                src="{{ asset($item->photo) }}" width="23" alt=""> {{ $item->nama }}</a>
                    @endforeach
                </div>
            </div>

            {{-- search bar --}}
            <div class="row mt-4">
                <div class="col-12">
                    <form action="{{ route('pembelian') }}" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control shadow py-2 border-0" name="search"
                                placeholder="Cari produk..." value="{{ request('search') }}">
                            <button class="btn text-white" style="background-color: #2E5077" type="submit"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- card product --}}
            <div class="row mt-4 mb-5">
                @forelse ($produk as $item)
                    <div class="col-3 mt-4">
                        <div class="card border-0 shadow">
                            <img src="{{ asset($item->photo) }}" alt="" class=" rounded-top" height="220"
                                style="object-fit: cover">
                            <span class="badge text-white position-absolute top-0 end-0 m-2 rounded-3"
                                style="background-color: #2E5077">{{ $item->kategori->nama }}</span>
                            <div class="card-body">
                                <h5 class="fw-bold text-center">{{ $item->nama }}</h5>
                                <small
                                    class="text-secondary d-block text-center">{{ Str::limit($item->deskripsi, 30) }}</small>
                                <p class="text-center mt-2 fw-bold" style="color: #2E5077">
                                    Rp{{ number_format($item->harga, 0, ',', '.') }}</p>
                                <button type="button"
                                    class="btn w-100 text-white fw-bold mt-2 px-4 d-flex justify-content-center"
                                    style="background-color: #2E5077" data-bs-toggle="modal" data-bs-target="#purchaseModal"
                                    data-id="{{ $item->id }}" data-nama="{{ $item->nama }}"
                                    data-harga="{{ $item->harga }}">
                                    Beli sekarang
                                </button>
                                <div class="mt-3 row">
                                    <div class="col-6 d-flex align-items-center">
                                        <small class="text-secondary"><i class="fa-solid fa-box"></i> Stok :
                                            {{ $item->stok }}</small>
                                    </div>
                                    <div class="d-flex col-6 justify-content-end">
                                        <a href="#" class="btn rounded-circle btn-custom-border btn-detail"
                                            data-bs-toggle="modal" data-bs-target="#productDetailModal"
                                            data-nama="{{ $item->nama }}" data-deskripsi="{{ $item->deskripsi }}"
                                            data-harga="{{ $item->harga }}" data-stok="{{ $item->stok }}"
                                            data-kategori="{{ $item->kategori->nama }}"
                                            data-photo="{{ asset($item->photo) }}">
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 mt-5">
                        <p class="text-center text-secondary">Produk tidak ditemukan untuk kategori ini.</p>
                    </div>
                @endforelse
            </div>

            <a href="#pembayaran" class="btn fw-bold shadow text-white" id="fixedButton" style="background-color: #2E5077"><i class="fa-solid fa-arrow-down me-2"></i>Pembayaran</a>

            <!-- modal untuk Pembelian -->
            <div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="purchaseModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="purchaseModalLabel">Masukan Jumlah</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form id="purchaseForm" action="{{ route('postPembelian') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="produk_id" id="produk_id">
                                <input type="hidden" name="harga" id="harga">
                                <p><strong id="produk_nama"></strong></p>
                                <label for="jumlah">Jumlah:</label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control" min="1"
                                    required>
                                <p>Total Harga: <span id="total_harga"></span></p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn text-white"
                                    style="background-color: #2E5077">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- modal detail --}}
            <div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header shadow" style="background-color: #fff; color: black;">
                            <h5 class="modal-title fw-bold" id="productDetailModalLabel">Detail Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="background-color: #f8f8f8">
                            <div class="row">
                                <div class="col-md-5">
                                    <img id="modalProductImage" src="" class="img-fluid rounded"
                                        alt="Produk Image">
                                </div>
                                <div class="col-md-7">
                                    <h4 class="fw-bold text-center" id="modalProductName"></h4>
                                    <hr>
                                    <p class="text-secondary" id="modalProductDescription"></p>
                                    <ul class="list-unstyled text-secondary mt-2">
                                        <li class="d-flex justify-content-start mb-1">
                                            <span class="me-2" style="min-width: 90px;"><i
                                                    class="fa-solid fa-money-check-dollar"></i> Harga</span>
                                            <span id="modalProductPrice"></span>
                                        </li>
                                        <li class="d-flex justify-content-start mb-1">
                                            <span class="me-2" style="min-width: 90px;"><i class="fa-solid fa-box"></i>
                                                Stok</span>
                                            <span id="modalProductStock"></span>
                                        </li>
                                        <li class="d-flex justify-content-start">
                                            <span class="me-2" style="min-width: 90px;"><i class="fa-solid fa-tag"></i>
                                                Kategori</span>
                                            <span id="modalProductCategory"></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- pay section --}}
            <hr>
            <div class="card mt-5 p-4 shadow border-0" id="pembayaran">
                <h5 class="fw-bold">Pembayaran</h5>
                <p class="text-secondary">Lakukan transaksi pembayaran di sini</p>
                <hr>
                <div class="table-responsive pb-2">
                    <table class="table" id="example">
                        <thead style="background-color: #f2f2f2">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Gambar</th>
                                <th scope="col">Produk</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Total Harga</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #f2f2f2">
                            @forelse ($pesanan as $item)
                                <tr>
                                    <td style="vertical-align: middle;" scope="row">{{ $loop->iteration }}</td>
                                    <td style="vertical-align: middle;" scope="row">
                                        <img src="{{ asset($item->produk->photo) }}" width="50" class="rounded-2"
                                            alt="">
                                    </td>
                                    <td style="vertical-align: middle;">{{ $item->produk->nama }}</td>
                                    <td style="vertical-align: middle;">{{ $item->jumlah }}x</td>
                                    <td style="vertical-align: middle;">
                                        Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                    <td style="vertical-align: middle;">
                                        <div class="d-flex">
                                            <a href="#" class="btn btn-success ms-1" style="padding: 12px 15px;"
                                                data-bs-toggle="modal" data-bs-target="#editModal"
                                                data-jumlah="{{ $item->jumlah }}"
                                                onclick="setEditData({{ $item->id }}, {{ $item->jumlah }})">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="{{ route('hapusPesanan', $item->id) }}"
                                                class="btn text-white ms-1 btn-merah"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
                                                style="padding: 12px 15px; background-color:#d9261c;">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-secondary fw-bold py-3">
                                        Belum ada pesanan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if ($pesanan->isNotEmpty())
                            <tfoot>
                                <tr style="background-color: #e9ecef;">
                                    <td colspan="4" class="text-end fw-bold">Total Harga Keseluruhan:</td>
                                    <td colspan="2" class="fw-bold">
                                        Rp{{ number_format($totalHargaKeseluruhan, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
                @if ($pesanan->isNotEmpty())
                    <div>
                        <form action="{{ route('postPembayaran') }}" method="POST" class="form-group">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <label for="totalPembayaran">Total Pembayaran</label>
                                    <input type="number" name="total_pembayaran" id="totalPembayaran"
                                        style="background-color: #f2f2f2" class="form-control"
                                        oninput="hitungKembalian()" required>
                                </div>

                                <div class="col-4">
                                    <label for="diskon">Diskon (%)</label>
                                    <input type="number" name="diskon" id="diskon" min="0" max="100"
                                        style="background-color: #f2f2f2" class="form-control"
                                        oninput="hitungKembalian()">
                                </div>
                                <div class="col-4">
                                    <label for="kembalian">Kembalian</label>
                                    <input type="number" name="kembalian" id="kembalian"
                                        style="background-color: #f2f2f2" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" id="submitBtn" class="btn text-white mt-3"
                                    style="background-color: #2E5077">
                                    Konfirmasi pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            {{-- modal edit pesanan --}}
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Jumlah Pesanan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="POST" action="{{ route('editPesanan') }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="pesanan_id" id="pesanan_id">
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah Pesanan</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah"
                                        min="1" value="{{ $item->jumlah }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <style>
        #fixedButton {
            position: fixed;
            bottom: 20px;
            /* Menempatkan tombol 20px dari bawah layar */
            right: 20px;
            /* Menempatkan tombol 20px dari sisi kanan layar */
            padding: 10px 20px;
            /* Ukuran tombol */
            text-align: center;
            /* Menyelaraskan teks di tengah */
            z-index: 9999;
            /* Memastikan tombol berada di atas elemen lainnya */
            font-size: 16px;
            /* Ukuran font */
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 3rem;
            height: 3rem;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
        }

        .carousel-control-prev {
            left: -1.5rem;
        }

        .carousel-control-next {
            right: -1.5rem;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(1);
            width: 1.5rem;
            height: 1.5rem;
        }

        .carousel-indicators [data-bs-target] {
            width: 0.8rem;
            height: 0.8rem;
            border-radius: 50%;
            background-color: white;
            border: 1px solid #000;
            opacity: 0.5;
        }

        .carousel-indicators .active {
            background-color: black;
            opacity: 1;
        }

        .btn-custom-border:hover {
            border: 2px solid #2E5077;
            color: #2E5077;
        }

        .btn-custom-border {
            background-color: #2E5077;
            color: #fff;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('productDetailModal');

            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // Tombol yang memicu modal

                // Ambil data dari atribut data-*
                const nama = button.getAttribute('data-nama');
                const deskripsi = button.getAttribute('data-deskripsi');
                const harga = button.getAttribute('data-harga');
                const stok = button.getAttribute('data-stok');
                const kategori = button.getAttribute('data-kategori');
                const photo = button.getAttribute('data-photo');

                // Batasi deskripsi maksimal 100 karakter
                const truncatedDescription = deskripsi.length > 100 ? deskripsi.substring(0, 280) + '...' :
                    deskripsi;

                // Isi data di dalam modal
                document.getElementById('modalProductName').innerText = nama;
                document.getElementById('modalProductDescription').innerText = truncatedDescription;
                document.getElementById('modalProductPrice').innerText = `Rp${harga}`;
                document.getElementById('modalProductStock').innerText = stok;
                document.getElementById('modalProductCategory').innerText = kategori;
                document.getElementById('modalProductImage').setAttribute('src', photo);
            });
        });

        var beliTombol = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#purchaseModal"]');

        beliTombol.forEach(function(tombol) {
            tombol.addEventListener('click', function() {

                var produkId = this.getAttribute('data-id');
                var produkNama = this.getAttribute('data-nama');
                var produkHarga = this.getAttribute('data-harga');

                document.getElementById('produk_id').value = produkId;
                document.getElementById('produk_nama').textContent = produkNama;
                document.getElementById('harga').value = produkHarga;

                var inputJumlah = document.getElementById('jumlah');
                inputJumlah.addEventListener('input', function() {
                    var jumlah = inputJumlah.value;
                    var totalHarga = jumlah * produkHarga;
                    document.getElementById('total_harga').textContent = 'Rp' + totalHarga
                        .toLocaleString();
                });
            });
        });

        window.onload = function() {
            // Pastikan tombol submit dinonaktifkan saat halaman pertama kali dimuat
            document.getElementById('submitBtn').disabled = true;
        };

        function hitungKembalian() {
            const totalHargaKeseluruhan = {{ $totalHargaKeseluruhan }};
            let totalPembayaran = parseFloat(document.getElementById('totalPembayaran').value) || 0;
            let diskon = parseFloat(document.getElementById('diskon').value) || 0;

            // Validasi: Pastikan total pembayaran tidak bisa minus
            if (totalPembayaran < 0) {
                document.getElementById('totalPembayaran').value = 0; // Set ke 0 jika lebih kecil dari 0
            }

            // Validasi: Pastikan diskon tidak lebih dari 100
            if (diskon > 100) {
                diskon = 100; // Set ke 100 jika lebih dari 100
                document.getElementById('diskon').value = diskon; // Update nilai di input diskon
            }

            // Hitung total harga setelah diskon
            const hargaSetelahDiskon = totalHargaKeseluruhan - (totalHargaKeseluruhan * (diskon / 100));

            // Hitung kembalian (pastikan kembalian tidak negatif)
            const kembalian = totalPembayaran - hargaSetelahDiskon;

            // Tampilkan hasil di input kembalian
            document.getElementById('kembalian').value = kembalian >= 0 ? kembalian.toFixed(0) : 0;

            // Validasi total pembayaran sebelum eksekusi route
            if (totalPembayaran < hargaSetelahDiskon) {
                document.getElementById('submitBtn').disabled = true; // Disable tombol submit
            } else {
                document.getElementById('submitBtn').disabled = false; // Enable tombol submit
            }
        }

        function setEditData(id, jumlah) {
            // Isi ID dan jumlah pesanan ke dalam form modal
            document.getElementById('pesanan_id').value = id;
            document.getElementById('jumlah').value = jumlah;
        }
    </script>

@endsection
