<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Admin - Dinas Pendidikan Kabupaten Sumenep</title>
    <link rel="icon" type="image/png" href="{{ asset('admin-assets/img/Logo1.png') }}">
    <link href="{{ asset('admin-assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('admin-assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #1E3F70 100%, #162F55 60%, #0B1F3A 0%);
            min-height: 100vh;
        }
        .btn-primary, .bg-gradient-primary {
            background-color: #162F55 !important;
            border-color: #162F55 !important;
            background-image: none !important;
        }
        .btn-primary:hover { background-color: #0B1F3A !important; border-color: #0B1F3A !important; }
        .login-card { margin-top: 90px; border-radius: 0.9rem; overflow: hidden; }
        .login-side {
            background: linear-gradient(160deg, #0B1F3A 0%, #162F55 100%);
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            color: #fff; padding: 40px 30px; text-align: center; height: 100%;
        }
        .login-side img { width: 90px; height: 90px; object-fit: contain; margin-bottom: 18px; background: #fff; border-radius: 50%; padding: 10px; }
        .login-side h5 { font-weight: 800; letter-spacing: 0.3px; }
        .login-side p { font-size: 0.85rem; color: rgba(255,255,255,0.85); margin-top: 8px; }
        .form-control-user:focus { border-color: #162F55; box-shadow: 0 0 0 0.2rem rgba(170,28,65,0.2); }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-11 col-md-11">
                <div class="card o-hidden border-0 shadow-lg login-card">
                    <div class="card-body p-0">
                        <div class="row no-gutters">
                            <div class="col-lg-5 d-none d-lg-flex">
                                <div class="login-side w-100">
                                    <img src="{{ asset('admin-assets/img/Logo1.png') }}" alt="Logo Dinas Pendidikan">
                                    <h5>DINAS PENDIDIKAN<br>KABUPATEN SUMENEP</h5>
                                    <p>Sistem Informasi Panel Admin</p>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-1">Selamat Datang Kembali</h1>
                                        <p class="text-muted small mb-4">Masuk untuk mengelola konten website dinas.</p>
                                    </div>

                                    @if ($errors->any())
                                        <div class="alert alert-danger py-2 small">
                                            @foreach ($errors->all() as $error)
                                                <div><i class="fas fa-exclamation-circle mr-1"></i> {{ $error }}</div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if (session('status'))
                                        <div class="alert alert-success py-2 small">{{ session('status') }}</div>
                                    @endif

                                    <form method="POST" action="{{ route('login') }}" class="user">
                                        @csrf
                                        <div class="form-group">
                                            <label class="small font-weight-bold text-gray-600">Email</label>
                                            <input type="email" class="form-control form-control-user"
                                                placeholder="admin@disdiksumenep.go.id" name="email"
                                                value="{{ old('email') }}" required autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label class="small font-weight-bold text-gray-600">Password</label>
                                            <input type="password" class="form-control form-control-user"
                                                placeholder="Masukkan password" name="password" required>
                                        </div>
                                        <div class="form-group d-flex justify-content-between align-items-center">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                                <label class="custom-control-label" for="remember">Ingat saya</label>
                                            </div>
                                            @if (Route::has('password.request'))
                                                <a class="small" href="{{ route('password.request') }}">Lupa password?</a>
                                            @endif
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
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