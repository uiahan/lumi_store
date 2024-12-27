@extends('layout.master')
@section('title', 'Produk')
@section('content')
    @include('components.navbar')

    <section class="riwayat-section" style="background-color: #f2f2f2">
        <div class="container py-5">
            <div class="p-4 shadow card border-0">
                <div class="row">
                    <div class="col-12">
                        <h3 class="fw-bold text-secondary">Produk</h3>
                    </div>
                    <div class="col-12">
                        <p class="text-muted text-secondary">Kelola produk di toko anda</p>
                    </div>
                </div>
            </div>

            <div class="card border-0 mt-4 p-4 shadow">
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="me-auto text-secondary">Tabel Produk</h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end d-none d-xl-block">
                        <div class="d-flex justify-content-end">
                            <button class="btn ms-2 rounded-4 text-white btn-kuning" style="background-color: #2E5077"
                                data-bs-toggle="modal" data-bs-target="#tambahModal">
                                <i class="me-1 fa-solid fa-plus"></i> Tambah produk
                            </button>
                        </div>
                    </div>
                    <div class="col-md-8 d-block d-xl-none">
                        <div>
                            <button class="btn ms-2 rounded-4 text-white btn-kuning" style="background-color: #2E5077"
                                data-bs-toggle="modal" data-bs-target="#tambahmodal">
                                <i class="me-1 fa-solid fa-plus"></i> Tambah produk
                            </button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="table-responsive pb-2">
                    <table class="table" id="example">
                        <thead style="background-color: #f2f2f2">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Gambar</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #f2f2f2">
                            @foreach ($produk as $item)
                                <tr>
                                    <td style="vertical-align: middle;" scope="row">{{ $loop->iteration }}</td>
                                    <td style="vertical-align: middle;"><img width="50" src="{{ asset($item->photo) }}"
                                            alt=""></td>
                                    <td style="vertical-align: middle;">{{ $item->nama }}</td>
                                    <td style="vertical-align: middle;">{{ $item->stok }}</td>
                                    <td style="vertical-align: middle;">Rp{{ number_format($item->harga, 0, ',', '.') }}
                                    </td>
                                    <td style="vertical-align: middle;">{{ Str::limit($item->deskripsi, 30) }}</td>
                                    <td style="vertical-align: middle;">{{ $item->kategori->nama }}</td>
                                    <td style="vertical-align: middle;">
                                        <div class="d-flex">
                                            <button class="btn btn-success ms-1 edit-btn" style="padding: 12px 15px;"
                                                data-bs-toggle="modal" data-bs-target="#editModal"
                                                data-id="{{ $item->id }}" data-nama="{{ $item->nama }}"
                                                data-stok="{{ $item->stok }}" data-harga="{{ $item->harga }}"
                                                data-deskripsi="{{ $item->deskripsi }}"
                                                data-kategori_id="{{ $item->kategori_id }}"
                                                data-photo="{{ asset($item->photo) }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <a href="{{ route('hapusProduk', $item->id) }}"
                                                class="btn text-white ms-1 btn-merah"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
                                                style="padding: 12px 15px; background-color:#d9261c;">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('editBarang', '') }}" method="POST" enctype="multipart/form-data" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Input untuk Nama Produk -->
                        <div class="mb-3">
                            <label for="editNama" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" style="background-color: #f3f3f3" id="editNama" name="nama" required>
                        </div>
    
                        <!-- Input untuk Stok Produk -->
                        <div class="mb-3">
                            <label for="editStok" class="form-label">Stok</label>
                            <input type="number" class="form-control" style="background-color: #f3f3f3" id="editStok" name="stok" required>
                        </div>
    
                        <!-- Input untuk Harga Produk -->
                        <div class="mb-3">
                            <label for="editHarga" class="form-label">Harga</label>
                            <input type="number" class="form-control" style="background-color: #f3f3f3" id="editHarga" name="harga" required>
                        </div>
    
                        <!-- Input untuk Deskripsi Produk -->
                        <div class="mb-3">
                            <label for="editDeskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" style="background-color: #f3f3f3" id="editDeskripsi" name="deskripsi" required></textarea>
                        </div>
    
                        <!-- Input untuk Kategori Produk -->
                        <div class="mb-3">
                            <label for="editKategori" class="form-label">Kategori</label>
                            <select class="form-control" id="editKategori" name="kategori_id" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                        </div>
    
                        <!-- Input untuk Foto Produk -->
                        <div class="mb-3">
                            <label for="editPhoto" class="form-label">Foto Produk</label>
                            <input type="file" class="form-control" id="editPhoto" name="photo" style="background-color: #f3f3f3">
                            <img id="editPhotoPreview" src="" alt="Preview" width="100" class="mt-2" style="display:none;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn text-white" style="background-color: #2E5077">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    <!-- Modal Tambah Produk -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tambahProduk') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Nama Produk -->
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" style="background-color: #f3f3f3" id="nama" name="nama" required>
                    </div>
                    
                    <!-- Stok Produk -->
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok Produk</label>
                        <input type="number" class="form-control" style="background-color: #f3f3f3" id="stok" name="stok" required>
                    </div>
                    
                    <!-- Harga Produk -->
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga Produk</label>
                        <input type="number" class="form-control" style="background-color: #f3f3f3" id="harga" name="harga" required>
                    </div>
                    
                    <!-- Deskripsi Produk -->
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                        <textarea class="form-control" style="background-color: #f3f3f3" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                    </div>
                    
                    <!-- Kategori Produk -->
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori Produk</label>
                        <select class="form-control" id="kategori_id" name="kategori_id" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Foto Produk -->
                    <div class="mb-3">
                        <label for="photo" class="form-label">Foto Produk</label>
                        <input type="file" class="form-control" id="photo" name="photo" style="background-color: #f3f3f3" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn text-white" style="background-color: #2E5077">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <!-- Required scripts -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.css">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.js"></script>

    <script>
        // Initialize DataTable
        new DataTable('#example');

        // Handle Edit Button Click
        $(document).on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const photo = $(this).data('photo');

            // Set the action of the form to the correct route with the id
            $('#editForm').attr('action', '/kategori/' + id);

            // Populate the fields in the modal
            $('#editNama').val(nama);
            $('#editPhotoPreview').attr('src', photo).show();

            // Handle photo preview if a new file is selected
            $('#editPhoto').on('change', function() {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#editPhotoPreview').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(this.files[0]);
            });
        });

        $('#addPhoto').on('change', function() {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#addPhotoPreview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(this.files[0]);
        });

        $(document).on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const stok = $(this).data('stok');
            const harga = $(this).data('harga');
            const deskripsi = $(this).data('deskripsi');
            const kategori_id = $(this).data('kategori_id');
            const photo = $(this).data('photo');

            // Set form action untuk mengarah ke produk yang akan diupdate
            $('#editForm').attr('action', '/editBarang/' + id);

            // Isi form dengan data produk
            $('#editNama').val(nama);
            $('#editStok').val(stok);
            $('#editHarga').val(harga);
            $('#editDeskripsi').val(deskripsi);
            $('#editKategori').val(kategori_id); // Isi dropdown dengan kategori_id
            $('#editPhotoPreview').attr('src', photo).show();

            // Menampilkan pratinjau foto jika ada perubahan foto
            $('#editPhoto').on('change', function() {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#editPhotoPreview').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endsection
