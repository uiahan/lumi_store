@extends('layout.master')
@section('title', 'Login')
@section('content')

    <section class="login-section">
        <div class="row h-100">
            <div class="col-7 d-flex justify-content-center align-items-center" style="background-color: #2E5077">
                <div>
                    <div class="d-flex justify-content-center mb-5">
                        <img src="{{ asset('image/Screenshot_2024-12-25_074836-removebg-preview.png') }}" width="500" alt="">
                    </div>
                    <div class="text-white">
                        <h3 class="text-center fw-semibold">Selamat Datang di Lumi Store</h3>
                        <p class="text-center">Aplikasi ini dirancang untuk memudahkan Anda dalam mengelola dan <br> memantau perkembangan toko Lumi Store.</p>
                    </div>
                </div>
            </div>
            <div class="col-5 d-flex justify-content-center align-items-center" style="background-color: white">
                <div class="login-form">
                    <div>
                        <h2 class="fw-bold text-center" style="color: #666666">Lumi Store</h2>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-center" style="color: #777777">Hallo! Selamat Datang</h3>
                    </div>
                    <div class="mt-5">
                        <form action="{{ route('postLogin') }}" class="form-group" method="POST">
                            @csrf
                            <div>
                                <label for="username" class="text-secondary">Masukan username anda</label>
                                <input type="text" name="username" required class="form-control">
                            </div>
                            <div class="mt-3">
                                <label for="password" class="text-secondary">Password</label>
                                <input type="password" name="password" required class="form-control">
                            </div>
                            <div class="d-flex justify-content-end">
                                <a class="mt-2" style="font-size: 14px; text-decoration: none; color: #2E5077;">Ahan Production</a>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" class="btn btn-login py-2 rounded-5 text-white" style="background-color: #2E5077">Masuk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .login-section {
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .login-form {
            width: 60%;
        }

        .form-control {
            border: none;
            padding-left: 0;
            border-bottom: 2px solid #ccc;
            border-radius: 0;
            outline: none;
            font-size: 20px;
            box-shadow: none;
        }

        .form-control:focus {
            border-bottom: 2px solid #ccc;
            outline: none;
            box-shadow: none;
        }

        .btn-login {
            padding-left: 4rem;
            padding-right: 4rem;
        }
    </style>
@endsection
