<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <title>Lumi Store | @yield('title')</title>
</head>
<body style="background-color: #f2f2f2">
    @yield('content')

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
        // Inisialisasi toastr dengan progress bar dan waktu 3 detik
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true, // Mengaktifkan progress bar
            "positionClass": "toast-top-right", // Posisi notifikasi
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300", // Durasi tampil notifikasi
            "hideDuration": "300", // Durasi menghilang notifikasi
            "timeOut": "3000", // Durasi tampil total (dalam milidetik, 3000ms = 3 detik)
            "extendedTimeOut": "1000", // Durasi perpanjangan timeout ketika mouse berada di atas
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        @if(session('success'))
            toastr.success("{{ session('success') }}", 'Success');
        @endif
        
        @if(session('error'))
            toastr.error("{{ session('error') }}", 'Error');
        @endif
    </script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</body>
</html>
