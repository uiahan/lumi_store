@extends('layout.master')
@section('title', 'Invoice')
@section('content')
    @include('components.navbar')

    <section class="riwayat-section" style="background-color: #f2f2f2">
        <div class="container py-5">
            <div class="p-4 shadow card border-0">
                <div class="row">
                    <div class="col-12">
                        <h3 class="fw-bold text-secondary">Riwayat</h3>
                    </div>
                    <div class="col-12">
                        <p class="text-muted text-secondary">Semua riwayat transaksi ada di sini</p>
                    </div>
                </div>
            </div>

            <div class="card border-0 mt-4 p-4 shadow">
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="me-auto text-secondary">Riwayat transaksi</h4>
                    </div>
                    <div class="col-md-8 text-end">
                        <form method="GET" action="{{ route('riwayat') }}">
                            <div class="d-flex">
                                <input type="date" name="tanggal_awal" class="form-control me-2" value="{{ request('tanggal_awal') }}">
                                <input type="date" name="tanggal_akhir" class="form-control me-2" value="{{ request('tanggal_akhir') }}">
                                <button type="submit" class="btn text-white" style="background-color: #2E5077">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="table-responsive pb-2">
                    <table class="table" id="example">
                        <thead style="background-color: #f2f2f2">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Kode pesanan</th>
                                <th scope="col">Total harga</th>
                                <th scope="col">Total pembayaran</th>
                                <th scope="col">Total diskon</th>
                                <th scope="col">Kembalian</th>
                                <th scope="col">Tanggal dan waktu</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #f2f2f2">
                            @foreach ($transaksi as $item)    
                            <tr>
                                <td style="vertical-align: middle;" scope="row">{{ $loop->iteration }}</td>
                                <td style="vertical-align: middle;">{{ $item->kode_pesanan }}</td>
                                <td class="text-primary" style="vertical-align: middle;">Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                <td class="text-success" style="vertical-align: middle;">Rp{{ number_format($item->total_pembayaran, 0, ',', '.') }}</td>
                                <td style="vertical-align: middle;">{{ $item->diskon }}%</td>
                                <td style="vertical-align: middle;">Rp{{ number_format($item->kembalian, 0, ',', '.') }}</td>
                                <td style="vertical-align: middle;">{{ $item->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </section>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.css">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.js"></script>
    <script>
        new DataTable('#example');
    </script>
@endsection
