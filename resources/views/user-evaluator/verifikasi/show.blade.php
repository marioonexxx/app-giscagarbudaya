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

        .badge-revisi {
            background-color: #f6e7c1;
            color: #856404;
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
                                    <th width="30%">Nama Objek</th>
                                    <td class="d-flex align-items-start">
                                        <span class="me-2">:</span>
                                        <span class="fw-bold text-dark">{{ $cagar->nama }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td class="d-flex align-items-start">
                                        <span class="me-2">:</span>
                                        {{ $cagar->kategori->nama_kategori ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Alamat Lokasi</th>
                                    <td class="d-flex align-items-start">
                                        <span class="me-2">:</span>
                                        {{ $cagar->alamat_lengkap ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td class="d-flex align-items-start">
                                        <span class="me-2">:</span>
                                        <div class="bg-light p-3 rounded small flex-grow-1">
                                            {{ $cagar->deskripsi ?? 'Tidak ada deskripsi.' }}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Surat Pengantar</th>
                                    <td class="d-flex align-items-start">
                                        <span class="me-2">:</span>
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
                                    <td class="d-flex align-items-start">
                                        <span class="me-2">:</span>
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
                            {{-- CEK STATUS: Jika masih Pendaftaran, tampilkan tombol aksi --}}
                            @if ($cagar->status_verifikasi == 'Pendaftaran')
                                <div class="d-grid gap-2">
                                    <button class="btn btn-success w-100 mb-2 shadow-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalEvaluasi"
                                        onclick="setEvaluasi('Layak', 'success', 'Konfirmasi Setujui')">
                                        <i class="fas fa-check-circle me-2"></i>Setujui Data
                                    </button>

                                    <button class="btn btn-warning w-100 mb-2 shadow-sm text-white" data-bs-toggle="modal"
                                        data-bs-target="#modalEvaluasi"
                                        onclick="setEvaluasi('Perlu Revisi', 'warning', 'Instruksi Revisi')">
                                        <i class="fas fa-sync me-2"></i>Minta Revisi
                                    </button>

                                    <button class="btn btn-outline-danger w-100 shadow-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalEvaluasi"
                                        onclick="setEvaluasi('Tidak Layak', 'danger', 'Alasan Penolakan')">
                                        <i class="fas fa-times-circle me-2"></i>Tolak Data
                                    </button>
                                </div>
                            @else
                                {{-- TAMPILAN JIKA SUDAH DIPROSES (READ ONLY) --}}
                                <div class="text-center py-2">
                                    <div class="avatar avatar-xl bg-light text-primary mb-3"
                                        style="width: 3rem; height: 3rem; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%;">
                                        <i class="fas fa-clipboard-check fa-lg"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">Data Terverifikasi</h5>
                                    <p class="small text-muted">Status akhir objek ini adalah:</p>

                                    @php
                                        $badgeFinal =
                                            [
                                                'Diverifikasi' => 'bg-success',
                                                'Ditetapkan' => 'bg-primary',
                                                'Revisi' => 'bg-warning text-dark',
                                                'Ditolak' => 'bg-danger',
                                            ][$cagar->status_verifikasi] ?? 'bg-secondary';
                                    @endphp
                                    <span
                                        class="badge {{ $badgeFinal }} d-block p-2 mb-3">{{ $cagar->status_verifikasi }}</span>

                                    <div class="bg-light p-2 rounded small border text-start">
                                        <i class="fas fa-info-circle me-1 text-primary"></i>
                                        Data ini sudah tidak dapat diubah kembali. Silakan cek menu <strong>Riwayat</strong>
                                        untuk melihat log lengkap.
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white fw-bold">Lampiran Foto</div>
                        <div class="card-body">
                            <div class="row g-2">
                                @forelse($cagar->foto as $f)
                                    <div class="col-6">
                                        <img src="{{ asset('storage/' . $f->path) }}" class="img-preview border shadow-sm"
                                            alt="Foto Cagar Budaya">
                                    </div>
                                @empty
                                    <div class="col-12 text-center py-4 text-muted small">
                                        <i class="fas fa-image fa-2x mb-2 opacity-25"></i><br>Tidak ada foto lampiran.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="modalEvaluasi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            {{-- Action form akan diisi otomatis melalui JS setEvaluasi --}}
            <form action="" method="POST" id="formEvaluasi">
                @csrf
                <input type="hidden" name="kesimpulan" id="inputKesimpulan">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header text-white" id="modalHeader">
                        <h5 class="modal-title" id="modalTitle">Evaluasi Data</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="small fw-bold mb-2">Catatan/Alasan Evaluasi <span
                                    class="text-danger">*</span></label>
                            <textarea name="catatan" class="form-control" rows="5" id="catatanEvaluasi"
                                placeholder="Berikan catatan detail..." required></textarea>
                            <div class="form-text mt-2 small text-muted">
                                Catatan ini akan tersimpan sebagai riwayat verifikasi.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn" id="btnSubmitEvaluasi">Kirim Keputusan</button>
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
        function setEvaluasi(kesimpulan, type, title) {
            const form = document.getElementById('formEvaluasi');
            const inputKesimpulan = document.getElementById('inputKesimpulan');
            const cagarId = "{{ $cagar->id }}";

            // 1. Set Input Hidden
            inputKesimpulan.value = kesimpulan;
            document.getElementById('modalTitle').innerText = title;

            // 2. Sesuaikan Action Route (Mengikuti struktur route kamu)
            if (kesimpulan === 'Layak') {
                form.action = "{{ route('evaluator.verifikasi.setujui', $cagar->id) }}";
            } else {
                form.action = "{{ route('evaluator.verifikasi.tolak', $cagar->id) }}";
            }

            // 3. Update UI Modal
            const header = document.getElementById('modalHeader');
            const btn = document.getElementById('btnSubmitEvaluasi');
            header.className = 'modal-header text-white bg-' + type;
            btn.className = 'btn btn-' + type;
            if (type === 'warning') btn.classList.add('text-white');

            // 4. Update Placeholder
            const area = document.getElementById('catatanEvaluasi');
            if (kesimpulan === 'Layak') area.placeholder = "Contoh: Dokumen sudah sesuai.";
            if (kesimpulan === 'Perlu Revisi') area.placeholder = "Contoh: Mohon perbaiki foto koordinat.";
            if (kesimpulan === 'Tidak Layak') area.placeholder = "Contoh: Objek tidak memenuhi syarat.";
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Peta
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

            // Loading submit
            document.getElementById('formEvaluasi').addEventListener('submit', function() {
                Swal.fire({
                    title: 'Menyimpan Keputusan...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });
        });
    </script>
@endpush
