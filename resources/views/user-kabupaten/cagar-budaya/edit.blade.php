@extends('layouts.navbar')

@section('title', 'Edit Usulan Cagar Budaya')

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
            position: relative;
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

        .badge-old {
            position: absolute;
            top: 5px;
            left: 5px;
            background: rgba(0, 97, 242, 0.8);
            color: white;
            font-size: 10px;
            padding: 2px 5px;
            border-radius: 4px;
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
                                <i class="fas fa-edit me-2"></i>Edit Usulan: {{ $cagarBudaya->nama }}
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
            <form action="{{ route('admin_kabupaten.cagar-budaya.update', $cagarBudaya->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card shadow-sm mb-4">
                    <div
                        class="card-header bg-white fw-bold text-primary d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-map-marker-alt me-1"></i> 1. Lokasi Spasial (Geser/Edit untuk
                            Perubahan)</span>
                        <div>
                            <button type="button" id="btnResetMap" class="btn btn-xs btn-outline-danger me-2 shadow-sm">
                                <i class="fas fa-trash-alt me-1"></i> Hapus & Gambar Ulang
                            </button>
                            <span class="badge bg-success text-white" id="geoStatus">{{ $cagarBudaya->tipe_geometri }}
                                Terpilih</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div id="mapInput"></div>
                        <input type="hidden" name="tipe_geometri" id="tipe_geometri"
                            value="{{ $cagarBudaya->tipe_geometri }}">
                        <input type="hidden" name="koordinat" id="koordinat"
                            value="{{ json_encode($cagarBudaya->koordinat) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-7">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white fw-bold text-primary">2. Detail Informasi</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="small mb-1 fw-bold">Nama Objek <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control"
                                        value="{{ old('nama', $cagarBudaya->nama) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1 fw-bold">Kategori Budaya <span
                                            class="text-danger">*</span></label>
                                    <select name="kategori_id" class="form-select" required>
                                        @foreach ($kategori as $k)
                                            <option value="{{ $k->id }}"
                                                {{ $cagarBudaya->kategori_id == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1 fw-bold">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $cagarBudaya->deskripsi) }}</textarea>
                                </div>
                                <div class="mb-0">
                                    <label class="small mb-1 fw-bold">Alamat Lengkap</label>
                                    <textarea name="alamat_lengkap" class="form-control" rows="2">{{ old('alamat_lengkap', $cagarBudaya->alamat_lengkap) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm mb-4 border-start-lg border-primary">
                            <div class="card-header bg-white fw-bold text-primary">3. Dokumen Pendukung (PDF)</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="small mb-1 fw-bold">Surat Pengantar Dinas (Kosongkan jika tidak
                                        diubah)</label>
                                    <input type="file" name="file_surat_pengantar" class="form-control" accept=".pdf">
                                    @if ($cagarBudaya->file_surat_pengantar)
                                        <small class="text-success"><i class="fas fa-check-circle"></i> File sudah ada: <a
                                                href="{{ asset('storage/' . $cagarBudaya->file_surat_pengantar) }}"
                                                target="_blank">Lihat PDF</a></small>
                                    @endif
                                </div>
                                <div class="mb-0">
                                    <label class="small mb-1 fw-bold">Naskah Rekomendasi TACB (Kosongkan jika tidak
                                        diubah)</label>
                                    <input type="file" name="file_rekomendasi_tacb" class="form-control" accept=".pdf">
                                    @if ($cagarBudaya->file_rekomendasi_tacb)
                                        <small class="text-success"><i class="fas fa-check-circle"></i> File sudah ada: <a
                                                href="{{ asset('storage/' . $cagarBudaya->file_rekomendasi_tacb) }}"
                                                target="_blank">Lihat PDF</a></small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white fw-bold text-primary">4. Dokumentasi Foto</div>
                            <div class="card-body">
                                <div class="alert alert-warning-soft small mb-3 border-0">
                                    <i class="fas fa-exclamation-triangle me-1"></i> Mengunggah foto baru akan
                                    <strong>menghapus semua</strong> foto lama.
                                </div>

                                <label class="small fw-bold">Foto Saat Ini:</label>
                                <div class="preview-container mb-3 border p-2 rounded bg-light">
                                    @foreach ($cagarBudaya->foto as $f)
                                        <div class="preview-item">
                                            <span class="badge-old">Lama</span>
                                            <img src="{{ asset('storage/' . $f->path) }}" class="preview-img"
                                                title="{{ $f->keterangan }}">
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mb-3">
                                    <label class="small mb-1 fw-bold">Upload Foto Baru (Opsional)</label>
                                    <input type="file" name="foto_upload[]" id="foto_upload" class="form-control"
                                        multiple accept="image/*">
                                    <div id="preview" class="preview-container"></div>
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm py-3 fw-bold">
                                    <i class="fas fa-save me-2"></i> SIMPAN PERUBAHAN
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
            const initialCoords = {!! json_encode($cagarBudaya->koordinat) !!};
            const initialType = "{{ $cagarBudaya->tipe_geometri }}";

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
                editMode: true,
                removalMode: true
            });

            let drawnLayer;

            const updateInputs = (layer, shape) => {
                const type = (shape === 'Marker' || layer instanceof L.Marker) ? 'Titik' : 'Poligon';
                const coords = (type === 'Titik') ? layer.getLatLng() : layer.getLatLngs()[0];
                document.getElementById('tipe_geometri').value = type;
                document.getElementById('koordinat').value = JSON.stringify(coords);
                document.getElementById('geoStatus').innerText = type + ' Terpilih';
            };

            // Load Existing
            if (initialType === 'Titik') {
                drawnLayer = L.marker([initialCoords.lat, initialCoords.lng]).addTo(map);
                map.setView([initialCoords.lat, initialCoords.lng], 17);
            } else {
                drawnLayer = L.polygon(initialCoords).addTo(map);
                map.fitBounds(drawnLayer.getBounds());
            }

            // Bind edit event to existing layer
            drawnLayer.on('pm:edit', () => updateInputs(drawnLayer, initialType));

            map.on('pm:create', (e) => {
                if (drawnLayer) map.removeLayer(drawnLayer);
                drawnLayer = e.layer;
                updateInputs(e.layer, e.shape);
                drawnLayer.on('pm:edit', () => updateInputs(drawnLayer, e.shape));
            });

            document.getElementById('btnResetMap').addEventListener('click', () => {
                if (drawnLayer) map.removeLayer(drawnLayer);
                drawnLayer = null;
                document.getElementById('koordinat').value = '';
                document.getElementById('geoStatus').innerText = 'Belum Ditandai';
                document.getElementById('geoStatus').className = 'badge bg-danger text-white';
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
                        div.innerHTML =
                            `<img src="${e.target.result}" class="preview-img"><span class="file-label">${file.name}</span>`;
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
