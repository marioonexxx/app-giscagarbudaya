<nav class="sidenav shadow-right sidenav-light">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">

            <div class="sidenav-menu-heading">Utama</div>
            <a class="nav-link" href="{{ route(auth()->user()->peran . '.dashboard') }}">
                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                Dashboard
            </a>

            @if (auth()->user()->peran == 'admin_kabupaten')
                <div class="sidenav-menu-heading">Manajemen Data</div>

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse"
                    data-bs-target="#collapseCagarBudaya" aria-expanded="false" aria-controls="collapseCagarBudaya">
                    <div class="nav-link-icon"><i data-feather="grid"></i></div>
                    Cagar Budaya
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseCagarBudaya" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('admin_kabupaten.cagar-budaya.create') }}">Daftarkan Baru</a>
                        <a class="nav-link" href="{{ route('admin_kabupaten.cagar-budaya.index') }}">Daftar Usulan</a>
                        <a class="nav-link" href="#!">Riwayat Penolakan</a>
                    </nav>
                </div>

                <a class="nav-link" href="{{ route('admin_kabupaten.peta-sebaran.index') }}">
                    <div class="nav-link-icon"><i data-feather="map"></i></div>
                    Peta Sebaran
                </a>
            @endif

            @if (auth()->user()->peran == 'evaluator')
                <div class="sidenav-menu-heading">Verifikasi & Validasi</div>

                {{-- <a class="nav-link" href="#!">
                    <div class="nav-link-icon"><i data-feather="check-square"></i></div>
                    Antrian Evaluasi
                    <span class="badge bg-warning-soft text-warning ms-auto">Proses</span>
                </a> --}}

                <a class="nav-link" href="{{ route('evaluator.verifikasi.riwayat') }}">
                    <div class="nav-link-icon"><i data-feather="file-text"></i></div>
                    Data Terverifikasi
                </a>
            @endif

            @if (auth()->user()->peran == 'super_admin')
                <div class="sidenav-menu-heading">Administrator Sistem</div>

                <a class="nav-link" href="{{ route('super_admin.user-management.index') }}">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Manajemen User Admin Kabupaten
                </a>
                <a class="nav-link" href="{{ route('super_admin.management-userevaluator.index') }}">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Manajemen User TACB
                </a>

                <a class="nav-link" href="#!">
                    <div class="nav-link-icon"><i data-feather="database"></i></div>
                    Master Wilayah & Kategori
                </a>

                <a class="nav-link" href="#!">
                    <div class="nav-link-icon"><i data-feather="settings"></i></div>
                    Konfigurasi Sistem
                </a>
            @endif

            <div class="sidenav-menu-heading">Personal</div>
            <a class="nav-link" href="{{ route('profile.edit') }}">
                <div class="nav-link-icon"><i data-feather="user"></i></div>
                Profil Saya
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <div class="nav-link-icon"><i data-feather="log-out"></i></div>
                    Keluar
                </a>
            </form>
        </div>
    </div>

    <div class="sidenav-footer">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Logged in as:</div>
            <div class="sidenav-footer-title">{{ auth()->user()->name }}</div>
            <div class="small fw-bold text-primary">
                {{ auth()->user()->wilayah->nama ?? 'Pusat/Provinsi' }}
            </div>
        </div>
    </div>
</nav>
