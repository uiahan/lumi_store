@extends('layout.master')
@section('title', 'Kategori')
@section('content')
    @include('components.navbar')

    <section class="riwayat-section" style="background-color: #f2f2f2">
        <div class="container py-5">
            <div class="p-4 shadow card border-0">
                <div class="row">
                    <div class="col-12">
                        <h3 class="fw-bold text-secondary">Kategori</h3>
                    </div>
                    <div class="col-12">
                        <p class="text-muted text-secondary">Kelola kategori yang anda inginkan</p>
                    </div>
                </div>
            </div>

            <div class="card border-0 mt-4 p-4 shadow">
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="me-auto text-secondary">Tabel Kategori</h4>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end d-none d-xl-block">
                        <div class="d-flex justify-content-end">
                            <button class="btn ms-2 rounded-4 text-white btn-kuning" 
                                    style="background-color: #2E5077" 
                                    data-bs-toggle="modal" data-bs-target="#addModal">
                                <i class="me-1 fa-solid fa-plus"></i> Tambah kategori
                            </button>
                        </div>
                    </div>
                    <div class="col-md-8 d-block d-xl-none">
                        <div>
                            <button class="btn ms-2 rounded-4 text-white btn-kuning" 
                                    style="background-color: #2E5077" 
                                    data-bs-toggle="modal" data-bs-target="#addModal">
                                <i class="me-1 fa-solid fa-plus"></i> Tambah kategori
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
                                <th scope="col">Icon/Gambar</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #f2f2f2">
                            @foreach ($kategori as $item)    
                            <tr>
                                <td style="vertical-align: middle;" scope="row">{{ $loop->iteration }}</td>
                                <td style="vertical-align: middle;"><img width="50" src="{{ asset($item->photo) }}" alt=""></td>
                                <td style="vertical-align: middle;">{{ $item->nama }}</td>
                                <td style="vertical-align: middle;">
                                    <div class="d-flex">
                                        <button class="btn btn-success ms-1 edit-btn" 
                                            style="padding: 12px 15px;" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal" 
                                            data-id="{{ $item->id }}" 
                                            data-nama="{{ $item->nama }}" 
                                            data-photo="{{ asset($item->photo) }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <a href="{{ route('hapusKategori', $item->id) }}" class="btn text-white ms-1 btn-merah" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
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

    <!-- Modal Edit Kategori -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kategori.update', '') }}" method="POST" enctype="multipart/form-data" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" style="background-color: #f3f3f3" id="editNama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Icon / Gambar</label>
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

     <!-- Modal Tambah Kategori -->
     <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tambahKategori') }}" method="POST" enctype="multipart/form-data" id="addForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" style="background-color: #f3f3f3" id="addNama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Icon / Gambar</label>
                            <input type="file" class="form-control" id="addPhoto" name="photo" style="background-color: #f3f3f3" required>
                            <img id="addPhotoPreview" src="" alt="Preview" width="100" class="mt-2" style="display:none;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn text-white" style="background-color: #2E5077">Simpan Kategori</button>
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
        $(document).on('click', '.edit-btn', function () {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const photo = $(this).data('photo');

            // Set the action of the form to the correct route with the id
            $('#editForm').attr('action', '/kategori/' + id);

            // Populate the fields in the modal
            $('#editNama').val(nama);
            $('#editPhotoPreview').attr('src', photo).show();

            // Handle photo preview if a new file is selected
            $('#editPhoto').on('change', function () {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#editPhotoPreview').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(this.files[0]);
            });
        });

        $('#addPhoto').on('change', function () {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#addPhotoPreview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection
