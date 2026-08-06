<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lupa Password - Dinas Pendidikan Kabupaten Sumenep</title>
    <link rel="icon" type="image/png" href="{{ asset('admin-assets/img/Logo1.png') }}">

    <link href="{{ asset('admin-assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('admin-assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0B1F3A 0%, #162F55 60%, #1E3F70 100%);
            min-height: 100vh;
        }
        .btn-primary {
            background-color: #162F55 !important;
            border-color: #162F55 !important;
        }
        .btn-primary:hover {
            background-color: #162F55 !important;
            border-color: #162F55 !important;
        }
        .forgot-card {
            margin-top: 110px;
            border-radius: 0.9rem;
            overflow: hidden;
        }
        .forgot-logo {
            width: 76px;
            height: 76px;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="card o-hidden border-0 shadow-lg forgot-card">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <img class="forgot-logo mb-3" src="{{ asset('admin-assets/img/Logo1.png') }}" alt="Logo Dinas Pendidikan">
                            <h1 class="h4 text-gray-900 mb-2">Lupa Password</h1>
                            <p class="text-muted small mb-4">Hubungi administrator utama untuk reset password akun admin.</p>
                        </div>
                        <a href="{{ route('login') }}" class="btn btn-primary btn-user btn-block">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin-assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('admin-assets/js/sb-admin-2.min.js') }}"></script>
</body>
</html>