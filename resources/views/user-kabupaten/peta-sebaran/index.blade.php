@extends('layouts.navbar')

@section('title', 'Peta Sebaran Cagar Budaya')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #mapSebaran {
            height: 80vh;
            width: 100%;
            border-radius: 12px;
            background-color: #ffffff;
            border: 1px solid #e3e6f0;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
        }

        /* Marker Dot Merah */
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
                                <i class="fas fa-map-marked-alt me-2"></i>Peta Sebaran Objek
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Inisialisasi Map
            const map = L.map('mapSebaran', {
                center: [-3.6547, 128.1906],
                zoom: 11
            });

            // 2. Base Layer Ultra-Light (Agar tidak putih polos tanpa konteks)
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; CartoDB'
            }).addTo(map);

            const layersGroup = [];

            // Icon Marker
            const customIcon = L.divIcon({
                className: 'custom-div-icon',
                html: '<div class="pulse-dot"></div>',
                iconSize: [12, 12],
                iconAnchor: [6, 6]
            });

            // 3. Loop Data
            @forelse ($sebaran as $item)
                (function() {
                    const type = "{{ $item->tipe_geometri }}";
                    const coords = {!! json_encode($item->koordinat) !!};
                    const nama = "{{ $item->nama }}";

                    // Cek data di console (F12)
                    console.log("Data Item:", {
                        nama,
                        type,
                        coords
                    });

                    let layer;

                    if (type === 'Titik' && coords && coords.lat) {
                        layer = L.marker([coords.lat, coords.lng], {
                            icon: customIcon
                        }).addTo(map);
                    } else if (type === 'Poligon' && Array.isArray(coords) && coords.length > 0) {
                        layer = L.polygon(coords, {
                            color: '#4e73df',
                            weight: 2,
                            fillColor: '#4e73df',
                            fillOpacity: 0.2
                        }).addTo(map);

                        // Taruh marker di tengah poligon untuk label
                        L.marker(layer.getBounds().getCenter(), {
                            icon: customIcon
                        }).addTo(map);
                    }

                    if (layer) {
                        layer.bindTooltip(nama, {
                            permanent: true,
                            direction: 'top',
                            className: 'custom-tooltip',
                            offset: [0, -5]
                        });

                        layer.bindPopup(`<strong>${nama}</strong><br>Tipe: ${type}`);
                        layersGroup.push(layer);
                    }
                })();
            @empty
                console.warn("Data 'sebaran' kosong dari Controller.");
            @endforelse

            // 4. Fokuskan Peta ke semua data
            if (layersGroup.length > 0) {
                const group = new L.featureGroup(layersGroup);
                map.fitBounds(group.getBounds(), {
                    padding: [50, 50]
                });
            }

            // Fix render
            setTimeout(() => {
                map.invalidateSize();
            }, 500);
        });
    </script>
@endpush
