@extends('layouts.navbar')

@section('title', 'Tambah Usulan Cagar Budaya')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.css" />
    <style>
        #mapInput {
            height: 500px;
            width: 100%;
            border-radius: 8px;
            z-index: 1;
            border: 1px solid #d1d3e2;
        }

        .preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;
        }

        .preview-item {
            width: 120px;
            text-align: center;
        }

        .preview-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #eaecf4;
        }

        .file-label {
            font-size: 0.7rem;
            color: #69707a;
            word-break: break-all;
            display: block;
            margin-top: 5px;
        }

        .border-start-lg {
            border-left: 0.25rem solid !important;
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
                                <i class="fas fa-plus-circle me-2"></i>Tambah Usulan Cagar Budaya
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-sm btn-light text-primary shadow-sm"
                                href="{{ route('admin_kabupaten.dashboard') }}">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-4">
            <form action="{{ route('admin_kabupaten.cagar-budaya.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card shadow-sm mb-4">
                    <div
                        class="card-header bg-white fw-bold text-primary d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-map-marker-alt me-1"></i> 1. Lokasi Spasial (Titik atau Area)</span>
                        <div>
                            <button type="button" id="btnResetMap" class="btn btn-xs btn-outline-danger me-2 shadow-sm">
                                <i class="fas fa-trash-alt me-1"></i> Hapus Gambar di Peta
                            </button>
                            <span class="badge bg-primary-soft text-primary" id="geoStatus">Belum Ditandai</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div id="mapInput"></div>
                        <input type="hidden" name="tipe_geometri" id="tipe_geometri" value="{{ old('tipe_geometri') }}">
                        <input type="hidden" name="koordinat" id="koordinat" value="{{ old('koordinat') }}">
                    </div>
                    @error('koordinat')
                        <div class="card-footer bg-danger-soft py-2 text-danger small">
                            <i class="fas fa-exclamation-triangle me-1"></i> Wajib menandai lokasi pada peta.
                        </div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-lg-7">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white fw-bold text-primary">2. Detail Informasi</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="small mb-1 fw-bold">Nama Objek <span class="text-danger">*</span></label>
                                    <input type="text" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                        required placeholder="Contoh: Benteng Belgica">
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="small mb-1 fw-bold">Kategori Budaya <span
                                            class="text-danger">*</span></label>
                                    <select name="kategori_id"
                                        class="form-select @error('kategori_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategori as $k)
                                            <option value="{{ $k->id }}"
                                                {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="small mb-1 fw-bold">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="4"
                                        placeholder="Ceritakan sejarah singkat atau kondisi fisik...">{{ old('deskripsi') }}</textarea>
                                </div>

                                <div class="mb-0">
                                    <label class="small mb-1 fw-bold">Alamat Lengkap</label>
                                    <textarea name="alamat_lengkap" class="form-control" rows="2" placeholder="Jalan, Desa/Kelurahan, Kecamatan...">{{ old('alamat_lengkap') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm mb-4 border-start-lg border-primary">
                            <div class="card-header bg-white fw-bold text-primary">3. Dokumen Pendukung (PDF Kabupaten)
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="small mb-1 fw-bold">Surat Pengantar Dinas/Bupati</label>
                                    <input type="file" name="file_surat_pengantar"
                                        class="form-control @error('file_surat_pengantar') is-invalid @enderror"
                                        accept=".pdf">
                                    <small class="text-muted">Format: PDF, Maks: 5MB</small>
                                    @error('file_surat_pengantar')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-0">
                                    <label class="small mb-1 fw-bold">Naskah Rekomendasi TACB Kabupaten</label>
                                    <input type="file" name="file_rekomendasi_tacb"
                                        class="form-control @error('file_rekomendasi_tacb') is-invalid @enderror"
                                        accept=".pdf">
                                    <small class="text-muted">Format: PDF, Maks: 5MB</small>
                                    @error('file_rekomendasi_tacb')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white fw-bold text-primary">4. Dokumentasi Foto</div>
                            <div class="card-body">
                                <div class="alert alert-primary-soft small mb-3 border-0">
                                    <i class="fas fa-info-circle me-1"></i> Nama file asli akan digunakan sebagai keterangan
                                    foto secara otomatis.
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1 fw-bold">Upload Foto (Bisa pilih banyak)</label>
                                    <input type="file" name="foto_upload[]" id="foto_upload"
                                        class="form-control @error('foto_upload.*') is-invalid @enderror" multiple
                                        accept="image/*">
                                    <div id="preview" class="preview-container"></div>
                                    @error('foto_upload.*')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm py-3 fw-bold">
                                    <i class="fas fa-paper-plane me-2"></i> KIRIM USULAN KE PROVINSI
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/@geoman-io/leaflet-geoman-free@latest/dist/leaflet-geoman.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi Map
            const map = L.map('mapInput').setView([-3.6547, 128.1906], 13);

            L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: 'Google Satellite'
            }).addTo(map);

            map.pm.addControls({
                position: 'topleft',
                drawMarker: true,
                drawPolygon: true,
                drawPolyline: false,
                drawCircle: false,
                drawCircleMarker: false,
                drawRectangle: false,
                cutPolygon: false,
                dragMode: true,
                editMode: true,
                removalMode: true
            });

            let drawnLayer;

            // Update Input Hidden Helper
            const updateGeomInputs = (layer, shape) => {
                let type = (shape === 'Marker') ? 'Titik' : 'Poligon';
                let coords = (shape === 'Marker') ? layer.getLatLng() : layer.getLatLngs()[0];

                document.getElementById('tipe_geometri').value = type;
                document.getElementById('koordinat').value = JSON.stringify(coords);

                const status = document.getElementById('geoStatus');
                status.innerText = type + ' Berhasil Ditandai';
                status.className = 'badge bg-success text-white';
            };

            // Restore Old Input
            @if (old('koordinat'))
                const oldType = "{{ old('tipe_geometri') }}";
                const oldCoords = {!! old('koordinat') !!};
                if (oldType === 'Titik') {
                    drawnLayer = L.marker([oldCoords.lat, oldCoords.lng]).addTo(map);
                } else {
                    drawnLayer = L.polygon(oldCoords).addTo(map);
                }
                document.getElementById('geoStatus').innerText = oldType + ' Terpilih (Restore)';
                document.getElementById('geoStatus').className = 'badge bg-success text-white';
            @endif

            // Event saat menggambar
            map.on('pm:create', (e) => {
                if (drawnLayer) map.removeLayer(drawnLayer);
                drawnLayer = e.layer;
                updateGeomInputs(e.layer, e.shape);

                drawnLayer.on('pm:edit', () => {
                    updateGeomInputs(drawnLayer, (drawnLayer instanceof L.Marker ? 'Marker' :
                        'Polygon'));
                });
            });

            // Reset Map
            document.getElementById('btnResetMap').addEventListener('click', () => {
                if (drawnLayer) {
                    map.removeLayer(drawnLayer);
                    drawnLayer = null;
                }
                document.getElementById('tipe_geometri').value = '';
                document.getElementById('koordinat').value = '';
                const status = document.getElementById('geoStatus');
                status.innerText = 'Belum Ditandai';
                status.className = 'badge bg-primary-soft text-primary';
            });

            // Preview Foto
            document.getElementById('foto_upload').addEventListener('change', function() {
                const preview = document.getElementById('preview');
                preview.innerHTML = '';
                Array.from(this.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const div = document.createElement('div');
                        div.className = 'preview-item';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="preview-img">
                            <span class="file-label">${file.name}</span>
                        `;
                        preview.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                });
            });

            setTimeout(() => {
                map.invalidateSize();
            }, 300);
        });
    </script>
@endpush
