<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Statistik - SI-CAGAR BUDAYA</title>

    <link href="{{ asset('sbadmin/css/styles.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('sbadmin/assets/img/favicon.png') }}" />

    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"
        crossorigin="anonymous"></script>

    <style>
        /* Menggunakan background yang sama dengan welcome */
        .bg-landing {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e1b4b 100%);
            min-height: 100vh;
            color: white;
        }

        .navbar-landing {
            padding: 1.5rem 0;
            transition: all 0.3s;
        }

        /* Penyesuaian konten agar tidak tertutup navbar */
        .content-section {
            padding-top: 8rem;
            padding-bottom: 5rem;
        }

        .floating-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            color: white;
        }

        .table-custom {
            color: white !important;
        }

        .table-custom thead th {
            color: rgba(255, 255, 255, 0.7);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            text-transform: uppercase;
            font-size: 0.8rem;
        }

        .table-custom tbody td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0.5rem;
        }

        /* Style untuk Tombol Detail agar terlihat */
        .btn-detail {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 50px;
            transition: all 0.3s;
        }

        .btn-detail:hover {
            background: white;
            color: #1e3a8a;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .badge-kategori {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
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

        #detailFoto {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 1rem;
        }

        /* Style untuk Select Filter agar matching */
        .form-select-custom {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 50px;
            padding: 0.5rem 1rem;
        }

        .form-select-custom option {
            background: #1e1b4b;
            color: white;
        }
    </style>
</head>

<body class="bg-landing">
    <nav class="navbar navbar-expand-lg navbar-dark navbar-landing fixed-top">
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
                data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-4">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active fw-bold' : '' }}" href="/">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('publik.statistik') ? 'active fw-bold' : '' }}"
                            href="{{ route('publik.statistik') }}">
                            <i class="fas fa-chart-bar me-1"></i> Statistik
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('publik.peta') ? 'active fw-bold' : '' }}"
                            href="{{ route('publik.peta') }}">
                            <i class="fas fa-map-marked-alt me-1"></i> Peta Sebaran
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

    <div class="content-section">
        <div class="container px-5">
            <div class="text-center mb-5">
                <h2 class="fw-800 display-4 mb-3 text-white">Statistik Objek</h2>
                <p class="opacity-75 mx-auto" style="max-width: 600px;">Data inventarisasi cagar budaya yang telah
                    melalui proses verifikasi oleh Tim Ahli Cagar Budaya.</p>
            </div>

            <div class="floating-card">
                <div class="row align-items-center mb-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <span class="small opacity-50 text-uppercase d-block">Total Objek</span>
                                <h2 class="fw-bold mb-0" id="totalObjek">0</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <label class="small opacity-50 me-2">FILTER WILAYAH:</label>
                        <select id="filterWilayah" class="form-select-custom shadow-none">
                            <option value="">Seluruh Maluku</option>
                            @foreach ($kabupatens as $kab)
                                <option value="{{ $kab->kode }}">{{ $kab->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom align-middle">
                        <thead>
                            <tr>
                                <th>Nama Objek</th>
                                <th>Kategori</th>
                                <th>Kabupaten/Kota</th>
                                <th class="text-end">Opsi</th>
                            </tr>
                        </thead>
                        <tbody id="bodyStatistik">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDetailPublik" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg"
                style="background: #1e1b4b; color: white; border: 1px solid rgba(255,255,255,0.1) !important;">
                <div class="modal-header border-0 p-4">
                    <h5 class="modal-title fw-bold" id="detailNama">Detail</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 pt-0">
                    <div id="loaderModal" class="text-center py-5">
                        <div class="spinner-border text-light"></div>
                    </div>
                    <div id="contentModal" class="d-none">
                        <div class="row">
                            <div class="col-lg-5 mb-4">
                                <img id="detailFoto" src="" class="shadow-lg border border-2 border-white-50">
                            </div>
                            <div class="col-lg-7">
                                <div class="mb-3">
                                    <label class="small opacity-50 d-block text-uppercase">Kategori</label>
                                    <span id="detailKategori" class="badge badge-kategori"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="small opacity-50 d-block text-uppercase">Wilayah</label>
                                    <span id="detailWilayah" class="fw-bold"></span>
                                </div>
                                <div class="mb-3">
                                    <label class="small opacity-50 d-block text-uppercase">Alamat</label>
                                    <p id="detailAlamat" class="small mb-0"></p>
                                </div>
                                <div class="mb-0">
                                    <label class="small opacity-50 d-block text-uppercase">Deskripsi</label>
                                    <div class="p-3 rounded mt-2"
                                        style="background: rgba(255,255,255,0.05); max-height: 200px; overflow-y: auto;">
                                        <p id="detailDeskripsi" class="small mb-0" style="line-height: 1.6;"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            function loadData(kode = '') {
                $('#bodyStatistik').html(
                    '<tr><td colspan="4" class="text-center py-5 opacity-50">Mengambil data...</td></tr>');
                $.get("{{ route('api.statistik') }}", {
                    wilayah_kode: kode
                }, function(data) {
                    let html = '';
                    $('#totalObjek').text(data.length);
                    if (data.length > 0) {
                        data.forEach(item => {
                            html += `
                            <tr>
                                <td class="fw-bold text-white">${item.nama}</td>
                                <td><span class="badge badge-kategori">${item.kategori ? item.kategori.nama_kategori : '-'}</span></td>
                                <td class="opacity-75">${item.wilayah ? item.wilayah.nama : '-'}</td>
                                <td class="text-end">
                                    <button onclick="lihatDetail(${item.id})" class="btn btn-sm btn-detail px-3 shadow-sm">Detail</button>
                                </td>
                            </tr>`;
                        });
                    } else {
                        html =
                            '<tr><td colspan="4" class="text-center py-5 opacity-50">Belum ada data tersedia.</td></tr>';
                    }
                    $('#bodyStatistik').html(html);
                });
            }
            loadData();
            $('#filterWilayah').change(function() {
                loadData($(this).val());
            });
        });

        function lihatDetail(id) {
            $('#modalDetailPublik').modal('show');
            $('#contentModal').addClass('d-none');
            $('#loaderModal').removeClass('d-none');
            $.get(`/api/cagar-detail/${id}`, function(res) {
                $('#detailNama').text(res.nama);
                $('#detailKategori').text(res.kategori);
                $('#detailWilayah').text(res.wilayah);
                $('#detailAlamat').text(res.alamat);
                $('#detailDeskripsi').text(res.deskripsi);
                let fotoUrl = res.foto.length > 0 ? res.foto[0] :
                    'https://placehold.co/600x400/1e3a8a/white?text=No+Image';
                $('#detailFoto').attr('src', fotoUrl);
                $('#loaderModal').addClass('d-none');
                $('#contentModal').removeClass('d-none');
            });
        }
    </script>
</body>

</html>
