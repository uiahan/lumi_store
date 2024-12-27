@extends('layout.master')
@section('title', 'Invoice')
@section('content')
    @include('components.navbar-second')

    <section class="invoice-section pt-5" style="background-color: #f8f8f8">
        <div class="container">
            <!-- Invoice Header -->
            <div class="invoice-header card border-0 shadow p-4">

                <h3 class="fw-bold">Invoice Pembayaran</h3>
                <p class="text-muted">Kode Pesanan : {{ $transaksi->kode_pesanan }}</p>
                <hr>
                <div class="row">
                    <h5 class="fw-bold">Detail Pesanan:</h5>

                    <div class="table-responsive pb-2">
                        <table class="table table-bordered" id="example">
                            <thead style="background-color: #f2f2f2">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Produk</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Total Harga</th>
                                </tr>
                            </thead>
                            <tbody style="background-color: #f8f8f8">
                                @forelse ($pesanan as $item)
                                    <tr>
                                        <td style="vertical-align: middle;" scope="row">{{ $loop->iteration }}</td>
                                        <td style="vertical-align: middle;">{{ $item->produk->nama }}</td>
                                        <td style="vertical-align: middle;">{{ $item->jumlah }}x</td>
                                        <td style="vertical-align: middle;">
                                            Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="background-color: #f2f2f2;">
                                    <td colspan="3" class="text-end text-primary">Total Harga Keseluruhan :</td>
                                    <td colspan="1" class=" text-primary">
                                        Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                </tr>
                                <tr style="background-color: #f2f2f2;">
                                    <td colspan="3" class="text-end text-success">Total Pembayaran :</td>
                                    <td colspan="1" class=" text-success">
                                        Rp{{ number_format($transaksi->total_pembayaran, 0, ',', '.') }}</td>
                                </tr>
                                <tr style="background-color: #f2f2f2;">
                                    <td colspan="3" class="text-end">Diskon :</td>
                                    <td colspan="1">{{ $transaksi->diskon }}%</td>
                                </tr>
                                <tr style="background-color: #f2f2f2;">
                                    <td colspan="3" class="text-end">Kembalian :</td>
                                    <td colspan="1">Rp{{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div>
                        <a href="{{ route('selesai', ['id' => $transaksi->id]) }}" 
                            class="btn btn-success" 
                            id="btn-download"
                            target="_blank">Selesai</a>
                        <a href="{{ route('cetakStruk', ['id' => $transaksi->id]) }}" class="btn btn-success"
                            target="_blank">Cetak Struk</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .invoice-section {
            padding: 20px;
            background-color: #f9f9f9;
        }

        .invoice-header {
            margin-bottom: 30px;
        }

        .invoice-header h3 {
            font-size: 1.8em;
        }

        .invoice-body .table th,
        .invoice-body .table td {
            padding: 15px;
            text-align: center;
        }

        .invoice-footer {
            margin-top: 30px;
        }
    </style>
    <script>
         document.getElementById('btn-download').addEventListener('click', function () {
        setTimeout(function () {
            window.location.href = "{{ route('pembelian') }}";
        }, 3000); // Redirect setelah 3 detik (cukup waktu untuk unduh selesai)
    });
    </script>
@endsection
