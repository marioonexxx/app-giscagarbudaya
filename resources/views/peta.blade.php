<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Peta Sebaran - SI-CAGAR BUDAYA</title>

    <link href="{{ asset('sbadmin/css/styles.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('sbadmin/assets/img/favicon.png') }}" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js">
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

        .content-section {
            padding-top: 6rem;
            height: 100vh;
            display: flex;
            flex-direction: column;
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

        .map-wrapper {
            flex-grow: 1;
            position: relative;
            margin: 0 2rem 1.5rem 2rem;
            border-radius: 1rem;
            overflow: hidden;
            border: 1px solid #e3e6f0;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
        }

        #map {
            height: 100%;
            width: 100%;
            background: #fff;
            z-index: 1;
        }

        .filter-panel {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e3e6f0;
            width: 280px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .pulse-dot {
            width: 12px;
            height: 12px;
            background: #e74a3b;
            border: 2px solid #fff;
            border-radius: 50%;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            animation: pulse-red 2s infinite;
        }

        @keyframes pulse-red {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(231, 74, 59, 0.7);
            }

            70% {
                transform: scale(1.1);
                box-shadow: 0 0 0 8px rgba(231, 74, 59, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(231, 74, 59, 0);
            }
        }

        .custom-tooltip {
            background: rgba(45, 55, 72, 0.9) !important;
            color: #fff !important;
            border: none !important;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: bold;
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

    <div class="content-section">
        <div class="map-wrapper">
            <div id="map"></div>
            <div class="filter-panel shadow-sm">
                <h5 class="fw-bold mb-1" style="color:#1e3a8a">Filter Sebaran</h5>
                <p class="text-muted mb-3 small">Pilih wilayah untuk memfilter titik.</p>
                <div class="mb-3">
                    <label class="small fw-bold text-muted mb-1">Kabupaten / Kota</label>
                    <select id="filterWilayah" class="form-select shadow-none">
                        <option value="">-- Seluruh Maluku --</option>
                        @foreach ($kabupaten as $kab)
                            <option value="{{ $kab->kode }}">{{ $kab->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="bg-light p-2 rounded border text-center">
                    <div class="small text-muted mb-1">Total Objek</div>
                    <span class="h4 fw-bold text-primary" id="countBadge">0</span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // 1. Inisialisasi Map Statis
        var map = L.map('map', {
            center: [-3.3241, 129.0015],
            zoom: 7,
            scrollWheelZoom: false
        });

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; CartoDB'
        }).addTo(map);

        var markersLayer = L.layerGroup().addTo(map);

        var customIcon = L.divIcon({
            className: 'custom-div-icon',
            html: '<div class="pulse-dot"></div>',
            iconSize: [12, 12],
            iconAnchor: [6, 6]
        });

        function renderData(dataList) {
            markersLayer.clearLayers();
            $('#countBadge').text(dataList.length);

            dataList.forEach(item => {
                const type = item.tipe_geometri;
                // Ambil koordinat: jika string diparse, jika sudah objek langsung pakai
                const coords = (typeof item.koordinat === 'string') ? JSON.parse(item.koordinat) : item.koordinat;
                const nama = item.nama;
                let layer;

                // Logika Titik: Cek kolom lat/lng ATAU isi json koordinat
                if (type === 'Titik') {
                    let lat = item.latitude || (coords ? coords.lat : null);
                    let lng = item.longitude || (coords ? coords.lng : null);

                    if (lat && lng) {
                        layer = L.marker([parseFloat(lat), parseFloat(lng)], {
                            icon: customIcon
                        });
                    }
                }
                // Logika Poligon
                else if (type === 'Poligon' && Array.isArray(coords) && coords.length > 0) {
                    layer = L.polygon(coords, {
                        color: '#e74a3b',
                        weight: 2,
                        fillColor: '#e74a3b',
                        fillOpacity: 0.2
                    });
                    // Marker pembantu di tengah poligon agar nama muncul
                    L.marker(layer.getBounds().getCenter(), {
                        icon: customIcon
                    }).addTo(markersLayer);
                }

                if (layer) {
                    layer.bindTooltip(nama, {
                        permanent: true,
                        direction: 'top',
                        className: 'custom-tooltip',
                        offset: [0, -8]
                    });
                    layer.bindPopup(`<strong>${nama}</strong><br><small>Tipe: ${type}</small>`);
                    markersLayer.addLayer(layer);
                }
            });
        }

        $(document).ready(function() {
            // Load Awal: Data default dari controller
            var initialData = {!! json_encode($sebaran) !!};
            renderData(initialData);

            // Filter On/Off tanpa merubah posisi kamera
            $('#filterWilayah').change(function() {
                var kode = $(this).val();
                $.get("{{ route('api.statistik') }}", {
                    wilayah_kode: kode
                }, function(res) {
                    renderData(res);
                });
            });

            setTimeout(() => {
                map.invalidateSize();
            }, 500);
        });
    </script>
</body>

</html>
