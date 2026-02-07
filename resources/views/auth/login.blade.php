<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login - SI Cagar Budaya Maluku</title>

    <link href="{{ asset('sbadmin/css/styles.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('sbadmin/assets/img/favicon.png') }}" />

    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous">
    </script>

    <style>
        /* Gradien Latar Belakang sesuai konsep gambar */
        .bg-gradient-custom {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e1b4b 100%);
            min-height: 100vh;
        }

        /* Center vertikal sempurna */
        .full-height-row {
            min-height: 100vh;
        }

        .login-card {
            border-radius: 1.25rem;
            border: none;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }

        .brand-text {
            color: white;
            text-shadow: 2px 4px 10px rgba(0, 0, 0, 0.3);
            line-height: 1.2;
        }

        .logo-pemprov {
            width: 90px;
            height: auto;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        /* Form styling */
        .form-control-solid {
            background-color: #f2f6fc !important;
            border: 1px solid #d4dae3 !important;
        }

        .form-control-solid:focus {
            background-color: #fff !important;
            border-color: #1e3a8a !important;
            box-shadow: 0 0 0 0.25rem rgba(30, 58, 138, 0.15) !important;
        }

        /* Badge gaya SB Admin Pro */
        .bg-white-soft {
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
        }
    </style>
</head>

<body class="bg-gradient-custom">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container-xl px-4">
                    <div class="row justify-content-center align-items-center full-height-row">

                        <div class="col-xl-6 col-lg-6 d-none d-lg-block text-white pe-lg-5">
                            <h1 class="display-3 fw-bold brand-text mb-3">Sistem Informasi Cagar Budaya Maluku</h1>
                            <p class="lead mb-4" style="opacity: 0.85; font-size: 1.25rem;">
                                Jendela Kekayaan Budaya Bumi Seribu Pulau. Platform terpadu pendataan,
                                pengelolaan, dan pelestarian aset sejarah dan budaya Maluku.
                            </p>
                            <div class="d-flex align-items-center">
                                <div class="badge bg-white-soft text-white p-3 rounded-pill shadow-sm">
                                    <i class="fas fa-landmark me-2"></i> Melestarikan Warisan Leluhur untuk Masa Depan
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-5 col-md-8 col-sm-11">
                            <div class="card login-card">
                                <div class="card-body p-5">
                                    <div class="text-center mb-4">
                                        <img src="{{ asset('sbadmin/assets/img/pemprov-maluku.png') }}"
                                            class="logo-pemprov mb-3" alt="Logo Maluku">

                                        <div class="mb-3">
                                            <h5 class="fw-bold mb-0"
                                                style="color: #1e3a8a; letter-spacing: 0.5px; font-size: 1.1rem;">
                                                DINAS PENDIDIKAN DAN KEBUDAYAAN
                                            </h5>
                                            <span class="small fw-700 text-uppercase text-muted"
                                                style="letter-spacing: 1px;">Provinsi Maluku</span>
                                        </div>

                                        <hr class="my-4 mx-5" style="opacity: 0.1;">

                                        <h4 class="fw-light mb-1">Masuk ke Akun Anda</h4>
                                        <p class="text-muted small">Gunakan email dan password terdaftar</p>
                                    </div>

                                    @if (session('status'))
                                        <div class="alert alert-success border-0 small mb-3" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="alert alert-danger border-0 small mb-3" role="alert">
                                            <ul class="mb-0 ps-3">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="mb-3">
                                            <label class="text-gray-600 small fw-bold mb-1" for="email">Alamat
                                                Email</label>
                                            <input class="form-control form-control-solid py-3" id="email"
                                                type="email" name="email" value="{{ old('email') }}" required
                                                autofocus placeholder="nama@instansi.go.id" />
                                        </div>

                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <label class="text-gray-600 small fw-bold mb-1" for="password">Kata
                                                    Sandi</label>
                                                @if (Route::has('password.request'))
                                                    <a class="small text-decoration-none"
                                                        href="{{ route('password.request') }}">Lupa?</a>
                                                @endif
                                            </div>
                                            <input class="form-control form-control-solid py-3" id="password"
                                                type="password" name="password" required autocomplete="current-password"
                                                placeholder="Masukkan password" />
                                        </div>

                                        <div class="mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input" id="remember_me" type="checkbox"
                                                    name="remember" />
                                                <label class="form-check-label small text-gray-600"
                                                    for="remember_me">Ingat Saya</label>
                                            </div>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit"
                                                class="btn btn-primary btn-block py-3 fw-bold shadow-sm"
                                                style="background-color: #1e3a8a; border: none;">
                                                Masuk ke Dashboard
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="card-footer bg-light px-5 py-3 text-center border-top-0">
                                    <div class="small text-muted">&copy; 2026 Pemerintah Provinsi Maluku</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('sbadmin/js/scripts.js') }}"></script>
</body>

</html>
