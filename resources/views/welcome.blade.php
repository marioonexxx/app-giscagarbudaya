<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Sistem Informasi Cagar Budaya Maluku</title>

    <link href="{{ asset('sbadmin/css/styles.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('sbadmin/assets/img/favicon.png') }}" />

    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous">
    </script>

    <style>
        .bg-landing {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e1b4b 100%);
            min-height: 100vh;
            color: white;
        }

        .navbar-landing {
            padding: 1.5rem 0;
            transition: all 0.3s;
        }

        .hero-section {
            padding-top: 10rem;
            padding-bottom: 5rem;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: white;
            text-shadow: 2px 4px 10px rgba(179, 177, 177, 0.2);
        }

        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.85;
            margin-bottom: 2.5rem;
            max-width: 600px;
        }

        .btn-landing {
            padding: 0.8rem 2rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s;
        }

        .btn-login-outline {
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
        }

        .btn-login-outline:hover {
            background: white;
            color: #1e3a8a;
            border-color: white;
        }

        .hero-image-container {
            position: relative;
        }

        .floating-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            display: block;
        }
    </style>
</head>

<body class="bg-landing">
    <nav class="navbar navbar-expand-lg navbar-dark navbar-landing">
        <div class="container px-5">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
                <img src="{{ asset('sbadmin/assets/img/pemprov-maluku.png') }}" alt="Logo" width="45"
                    class="me-3">

                <div class="d-flex flex-column lh-1">
                    <span class="fs-5 fw-bold text-uppercase">SI-CAGAR BUDAYA</span>
                    <span class="small fw-normal text-white-50" style="font-size: 0.75rem;">
                        Dinas Pendidikan dan Kebudayaan Provinsi Maluku
                    </span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-4">
                    {{-- Gunakan logika request() agar link yang aktif terlihat tebal --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active fw-bold' : '' }}" href="/">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        {{-- Diubah dari #statistik menjadi route publik.statistik --}}
                        <a class="nav-link {{ request()->routeIs('publik.statistik') ? 'active fw-bold' : '' }}"
                            href="{{ route('publik.statistik') }}">
                            <i class="fas fa-chart-bar me-1"></i>Statistik</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('publik.peta') ? 'active fw-bold' : '' }}"
                            href="{{ route('publik.peta') }}">
                            <i class="fas fa-map-marked-alt me-1"></i> Peta
                        </a>
                    </li>
                </ul>
                @if (Route::has('login'))
                    <div>
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="btn btn-landing btn-white shadow-sm text-primary bg-white">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-landing btn-login-outline">Login Sistem</a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="container px-5">
            <div class="row gx-5 align-items-center">
                <div class="col-lg-6">
                    <div class="mb-5 mb-lg-0">
                        <div class="badge bg-white-soft text-white rounded-pill px-3 py-2 mb-3">
                            <i class="fas fa-landmark me-2"></i> Dinas Pendidikan dan Kebudayaan
                        </div>
                        <h1 class="hero-title">Lestarikan Warisan Budaya Maluku.</h1>
                        <p class="hero-subtitle">
                            Platform digital untuk pendataan, pemetaan, dan pengelolaan aset Cagar Budaya di Bumi Seribu
                            Pulau secara terintegrasi dan akurat.
                        </p>
                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <a class="btn btn-primary btn-landing shadow-lg" href="{{ route('publik.statistik') }}">
                                <i class="fas fa-search me-2"></i> Jelajahi Data
                            </a>
                            <a class="btn btn-login-outline btn-landing" href="#tentang">
                                Pelajari Lebih Lanjut
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="hero-image-container">
                        <div class="floating-card">
                            <div class="row text-center">
                                <div class="col-6 mb-4">
                                    <span class="stat-number text-white">{{ $jumlahTerverifikasi }}</span>
                                    <span class="small opacity-75 text-uppercase">Objek Terverifikasi</span>
                                </div>
                                <div class="col-6 mb-4">
                                    <span class="stat-number text-white">11</span>
                                    <span class="small opacity-75 text-uppercase">Kabupaten/Kota</span>
                                </div>
                                <div class="col-6">
                                    <span class="stat-number text-white">{{ $jumlahEvaluator ?? 0 }}</span>
                                    <span class="small opacity-75 text-uppercase">TACB Ahli</span>
                                </div>
                                <div class="col-6">
                                    <span class="stat-number text-white">100%</span>
                                    <span class="small opacity-75 text-uppercase">Digitalisasi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <footer class="py-5 mt-auto">
        <div class="container px-5 text-center">
            <div class="small opacity-50">
                &copy; {{ date('Y') }} Dinas Pendidikan dan Kebudayaan Provinsi Maluku.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
</body>

</html>
