@extends('layout.master')
@section('title', 'Laba Keuntungan')
@section('content')
    @include('components.navbar')

    <section class="container py-5">
        <div class="p-4 shadow card border-0">
            <div class="row">
                <div class="col-12">
                    <h3 class="fw-bold text-secondary">Laba keuntungan</h3>
                </div>
                <div class="col-12">
                    <p class="text-muted text-secondary">Laporan laba keuntungan perbulan</p>
                </div>
            </div>
        </div>
        
        <div class="card mt-4 border-0 shadow">
            <div class="card-body">
                <canvas id="profitChart"></canvas>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Ambil data dari Blade (PHP ke JavaScript)
        const data = @json($data);

        // Format bulan dan tahun menjadi label untuk grafik
        const months = data.map(item => `${item.month}-${item.year}`);
        const totalHarga = data.map(item => item.total_harga);
        const totalKeuntungan = data.map(item => item.total_keuntungan);

        // Membuat grafik menggunakan Chart.js
        const ctx = document.getElementById('profitChart').getContext('2d');
        const profitChart = new Chart(ctx, {
            type: 'line', // Jenis grafik (line chart)
            data: {
                labels: months, // Label sumbu X adalah bulan-tahun
                datasets: [
                    {
                        label: 'Total Harga (Rp)', // Grafik untuk total harga
                        data: totalHarga, // Data total harga
                        borderColor: 'rgba(75, 192, 192, 1)', // Warna garis
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna latar belakang
                        fill: true,
                        tension: 0.1
                    },
                    {
                        label: 'Keuntungan (Rp)', // Grafik untuk keuntungan
                        data: totalKeuntungan, // Data total keuntungan
                        borderColor: 'rgba(255, 99, 132, 1)', // Warna garis untuk keuntungan
                        backgroundColor: 'rgba(255, 99, 132, 0.2)', // Warna latar belakang untuk keuntungan
                        fill: true,
                        tension: 0.1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan-Tahun'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Harga / Keuntungan (Rp)'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
