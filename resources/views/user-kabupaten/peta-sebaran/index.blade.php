@extends('layouts.navbar')

@section('title', 'Peta Sebaran Cagar Budaya')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />

    <style>
        #mapSebaran {
            height: 80vh;
            width: 100%;
            border-radius: 12px;
            background-color: #ffffff;
            border: 1px solid #e3e6f0;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
        }

        /* Marker Dot Dinamis */
        .pulse-dot {
            width: 14px;
            height: 14px;
            border: 2px solid #fff;
            border-radius: 50%;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            display: block;
        }

        /* Tooltip Style */
        .custom-tooltip {
            background: rgba(45, 55, 72, 0.9) !important;
            color: #fff !important;
            border: none !important;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: bold;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 8px;
            padding: 5px;
        }
    </style>
@endpush

@section('content')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-xl px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title text-primary">
                                <i class="fas fa-map-marked-alt me-2"></i>Peta Sebaran Objek Wilayah
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4">
            <div class="card shadow-sm">
                <div class="card-body p-2">
                    <div id="mapSebaran"></div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Inisialisasi Map (Center Maluku)
            const map = L.map('mapSebaran', {
                center: [-3.2371, 130.1445],
                zoom: 7,
                fullscreenControl: true, // Poin 3: Mengaktifkan Fullscreen
                fullscreenControlOptions: {
                    position: 'topleft'
                }
            });

            // 2. Base Layer (Light)
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; CartoDB'
            }).addTo(map);

            const layersGroup = [];

            // Fungsi Warna Status
            function getStatusColor(status) {
                switch (status) {
                    case 'Ditetapkan':
                        return '#10b981'; // Hijau
                    case 'Diverifikasi':
                        return '#3b82f6'; // Biru
                    case 'Revisi':
                        return '#f59e0b'; // Oranye
                    case 'Ditolak':
                        return '#ef4444'; // Merah
                    default:
                        return '#6b7280'; // Pendaftaran (Abu-abu)
                }
            }

            // 3. Render Data dari Controller
            @foreach ($sebaran as $item)
                (function() {
                    const type = "{{ $item->tipe_geometri }}";
                    const coords = {!! json_encode($item->koordinat) !!};
                    const nama = "{{ $item->nama }}";
                    const status = "{{ $item->status_verifikasi }}";
                    const color = getStatusColor(status);

                    // Marker Icon Dinamis sesuai warna status
                    const customIcon = L.divIcon({
                        className: 'custom-div-icon',
                        html: `<div class="pulse-dot" style="background: ${color};"></div>`,
                        iconSize: [14, 14],
                        iconAnchor: [7, 7]
                    });

                    let layer;

                    if (type === 'Titik' && coords && coords.lat) {
                        layer = L.marker([coords.lat, coords.lng], {
                            icon: customIcon
                        }).addTo(map);
                    } else if (type === 'Poligon' && Array.isArray(coords) && coords.length > 0) {
                        layer = L.polygon(coords, {
                            color: color,
                            weight: 2,
                            fillColor: color,
                            fillOpacity: 0.2
                        }).addTo(map);

                        // Tambah marker di tengah poligon biar bisa diklik/label
                        L.marker(layer.getBounds().getCenter(), {
                            icon: customIcon
                        }).addTo(map);
                    }

                    if (layer) {
                        // Tooltip (Label Nama)
                        layer.bindTooltip(nama, {
                            permanent: true,
                            direction: 'top',
                            className: 'custom-tooltip',
                            offset: [0, -5]
                        });

                        // Popup (Informasi Detail)
                        layer.bindPopup(`
                            <div style="min-width: 150px">
                                <strong style="font-size:14px">${nama}</strong><br>
                                <span class="badge" style="background-color: ${color}; color: white; font-size: 10px; padding: 2px 5px; margin-top:5px">${status}</span>
                                <hr style="margin: 8px 0">
                                <a href="{{ route('admin_kabupaten.cagar-budaya.edit', $item->id) }}" class="btn btn-primary btn-sm text-white w-100" style="font-size: 11px">Detail/Edit</a>
                            </div>
                        `);

                        layersGroup.push(layer);
                    }
                })();
            @endforeach

            // 4. Auto-Focus (FitBounds) jika ada data
            if (layersGroup.length > 0) {
                const group = new L.featureGroup(layersGroup);
                map.fitBounds(group.getBounds(), {
                    padding: [50, 50]
                });
            }

            // Fix render issue dalam container
            setTimeout(() => {
                map.invalidateSize();
            }, 500);
        });
    </script>
@endpush
