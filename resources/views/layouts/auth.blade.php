<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Sistem Arsip & Laporan</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}"> -->

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            /* Pastikan path bg-img.jpg benar dan gambar ada di folder public Anda */
            background: url("{{ asset('bg-disnaker.png') }}") no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column; /* Tambahkan ini agar footer login bisa di bawah login-box */
            margin: 0; /* Pastikan tidak ada margin default */
        }

        .login-box {
            width: 400px;
            margin: 0 auto; /* Tengah secara horizontal */
            padding: 20px; /* Sedikit padding agar tidak terlalu mepet tepi */

        }

        .card {
            border-radius: 20px;
            background:hsla(0, 100.00%, 99.80%, 0.13);
            box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.19); /* Shadow yang lebih halus */
            border: none;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 20px; /* Atur jarak bawah */
            color: #fff; /*Pastikan teks logo putih*/
            /* text-shadow: 1px 1px 3px rgba(0,0,0,0.5); Tambahkan shadow agar lebih terlihat */
        }

        .login-logo img {
            max-height: 80px;
            margin-bottom: 10px;
            /* border-radius: 50%; Jika logo bulat */
            /* background-color: rgba(255, 255, 255, 0.2); Sedikit background agar logo lebih menonjol */
            padding: 5px;
        }

        .login-logo h4 {
            font-weight: 600;
            /* Warna teks sudah diatur di .login-logo */
        }

        .form-control {
            border-radius: 10px; /* Input dengan sudut sedikit membulat */
            padding: 10px 15px;
        }
        .label_card{
            background: rgba(255, 255, 255, 0.64);
            border-radius: 10px;
            text-align: center;;
            padding: 10px;
        }
        .form-control:focus {
            border-color: #00c292;
            box-shadow: 0 0 8px rgba(0, 194, 146, 0.5);
        }

        .input-group-text {
            border-radius: 0 10px 10px 0; /* Sudut membulat di kanan */
            background-color:rgba(0,0,0,0);
            border-left: none; /* Hilangkan garis di kiri */
        }


        .input-group .form-control:first-child {
            border-radius: 10px; /* Sudut membulat di kiri */
            background: rgba(0, 0, 0, 0);
        }

        .btn-primary {
            background-color:rgb(101, 6, 179);
            color: #fff;
            /* border-color: #00c292; */
            font-weight: 300;
            height: 30px;
            margin: 15px ;
            width: 100px !important;
            border-radius:5px !important;
            border: none !important;
        }

        .btn-primary:hover {
            background-color:rgb(74, 6, 131);
            /* border-color: #009e82; */
            transform: translateY(-2px); /* Efek sedikit naik saat hover */
            /* box-shadow: 0 4px 8px rgba(0,194,146,0.3); */
        }

        .invalid-feedback {
            display: block;
            margin-top: 5px;
        }

        .login-box-msg {
            font-size: 14px;
            font-weight: 400;
            color: #555;
            text-align: center;
            margin-bottom: 20px; /* Tambah jarak bawah */
        }

        /* Hapus .text-white di sini karena sudah diatur di .login-logo */
        /* .text-white {
            color: #fff !important;
        } */

        .rounded-pill {
            border-radius: 50rem !important; /* Gunakan !important untuk memastikan override */
            padding: 10px 20px; /* Perbesar padding agar tombol lebih besar */
            font-size: 1.1rem; /* Perbesar ukuran font tombol */
            /* background:hsla(0, 100.00%, 99.80%, 0.13) */
        }

        @media (max-width: 480px) {
            .login-box {
                width: 90%;
                padding: 10px;
            }
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #fff;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5); /* Shadow agar teks footer terlihat */
        }
    </style>
</head>
<body>

    {{-- Hapus div.login-box di sini karena sudah ada di login.blade.php yang di @yield --}}
    {{-- Dan Anda sudah mengatur flexbox di body --}}
    @yield('content')

    {{-- Letakkan footer di luar yield agar bisa dikontrol oleh auth.blade.php --}}
    <div class="login-footer">
        &copy; {{ date('Y') }} Sistem Arsip & Laporan
    </div>

    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
