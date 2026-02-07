@extends('layouts.navbar')

@section('title', 'Evaluasi Data - ' . $cagar->nama)

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        #mapDetail {
            height: 400px;
            width: 100%;
            border-radius: 8px;
            z-index: 1;
        }

        .img-preview {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.2s;
        }

        .img-preview:hover {
            transform: scale(1.02);
        }

        .card-header.bg-primary-soft {
            background-color: rgba(78, 115, 223, 0.1);
            color: #4e73df;
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
                                <i class="fas fa-file-signature me-2"></i>Lembar Evaluasi Verifikator
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-sm btn-light text-primary border shadow-sm"
                                href="{{ route('evaluator.dashboard') }}">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Antrean
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4">
            <div class="row">
                <div class="col-xl-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-info-circle me-1 text-primary"></i> Data Teknis Objek</span>
                            <span class="badge bg-primary-soft text-primary">{{ $cagar->status_verifikasi }}</span>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless align-middle">
                                <tr>
                                    <th width="35%">Nama Objek</th>
                                    <td>: <span class="fw-bold text-dark">{{ $cagar->nama }}</span></td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td>: {{ $cagar->kategori->nama_kategori ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat Lokasi</th>
                                    <td>: {{ $cagar->alamat ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>: <div class="bg-light p-3 rounded small">
                                            {{ $cagar->deskripsi ?? 'Tidak ada deskripsi.' }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Surat Pengantar</th>
                                    <td>:
                                        @if ($cagar->file_surat_pengantar)
                                            <a href="{{ asset('storage/' . $cagar->file_surat_pengantar) }}"
                                                class="btn btn-xs btn-outline-primary" target="_blank">
                                                <i class="fas fa-file-pdf me-1"></i> Lihat Berkas
                                            </a>
                                        @else
                                            <span class="text-danger small"><i
                                                    class="fas fa-exclamation-circle me-1"></i>Belum diunggah</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Rekomendasi TACB</th>
                                    <td>:
                                        @if ($cagar->file_rekomendasi_tacb)
                                            <a href="{{ asset('storage/' . $cagar->file_rekomendasi_tacb) }}"
                                                class="btn btn-xs btn-outline-info" target="_blank">
                                                <i class="fas fa-file-pdf me-1"></i> Lihat Berkas
                                            </a>
                                        @else
                                            <span class="text-danger small"><i
                                                    class="fas fa-exclamation-circle me-1"></i>Belum diunggah</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white fw-bold">
                            <i class="fas fa-map-marked-alt me-1 text-primary"></i> Lokasi Spasial
                            ({{ $cagar->tipe_geometri }})
                        </div>
                        <div class="card-body p-2">
                            <div id="mapDetail"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card shadow-sm mb-4 border-top-lg border-primary">
                        <div class="card-header bg-white fw-bold">Keputusan Evaluator</div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <form id="formSetuju" action="{{ route('evaluator.verifikasi.setujui', $cagar->id) }}"
                                    method="POST">
                                    @csrf
                                    <button type="button" id="btnSetuju" class="btn btn-success w-100 mb-2 shadow-sm">
                                        <i class="fas fa-check-circle me-2"></i>Verifikasi Sekarang
                                    </button>
                                </form>

                                <button class="btn btn-outline-danger w-100 shadow-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalTolak">
                                    <i class="fas fa-undo me-2"></i>Tolak & Revisi
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white fw-bold">Lampiran Foto</div>
                        <div class="card-body">
                            <div class="row g-2">
                                @forelse($cagar->foto as $f)
                                    <div class="col-6">
                                        <img src="{{ asset('storage/' . $f->path) }}" class="img-preview border shadow-sm">
                                    </div>
                                @empty
                                    <div class="col-12 text-center py-4 text-muted small">
                                        <i class="fas fa-image fa-2x mb-2 opacity-25"></i><br>Tidak ada foto.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="modalTolak" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('evaluator.verifikasi.tolak', $cagar->id) }}" method="POST">
                @csrf
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Alasan Penolakan Data</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="small fw-bold mb-2">Instruksi perbaikan bagi Admin Kabupaten:</label>
                        <textarea name="catatan_evaluator" class="form-control" rows="5"
                            placeholder="Contoh: Lampirkan surat pengantar yang sudah ditandatangani..." required></textarea>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-light border" data-bs-modal="dismiss">Batal</button>
                        <button type="submit" class="btn btn-danger shadow">Kirim Revisi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Inisialisasi Peta
            const type = "{{ $cagar->tipe_geometri }}";
            const coords = {!! json_encode($cagar->koordinat) !!};
            const map = L.map('mapDetail');
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png').addTo(map);

            if (type === 'Titik' && coords && coords.lat) {
                L.marker([coords.lat, coords.lng]).addTo(map);
                map.setView([coords.lat, coords.lng], 16);
            } else if (type === 'Poligon' && Array.isArray(coords)) {
                const poly = L.polygon(coords, {
                    color: '#4e73df',
                    weight: 3
                }).addTo(map);
                map.fitBounds(poly.getBounds(), {
                    padding: [30, 30]
                });
            }

            // 2. SweetAlert Konfirmasi Verifikasi
            document.getElementById('btnSetuju').addEventListener('click', function() {
                // Cek kelengkapan dokumen (secara client-side sederhana)
                const surat = {{ $cagar->file_surat_pengantar ? 'true' : 'false' }};
                const rekom = {{ $cagar->file_rekomendasi_tacb ? 'true' : 'false' }};

                let config = {
                    title: 'Verifikasi Data?',
                    text: 'Pastikan seluruh informasi teknis sudah benar sebelum diverifikasi.',
                    icon: 'question',
                    confirmButtonText: 'Ya, Verifikasi!',
                    confirmButtonColor: '#198754'
                };

                if (!surat || !rekom) {
                    config.title = 'Dokumen Belum Lengkap!';
                    config.text =
                        'Beberapa file wajib belum diunggah. Anda yakin ingin tetap memverifikasi?';
                    config.icon = 'warning';
                }

                Swal.fire({
                    ...config,
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Memproses...',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        document.getElementById('formSetuju').submit();
                    }
                });
            });
        });
    </script>
@endpush
