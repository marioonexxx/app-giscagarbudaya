@extends('layouts.navbar')

@section('title', 'Daftar Riwayat Verifikasi')

@section('content')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-xl px-4">
                <div class="page-header-content py-3">
                    <h1 class="page-header-title text-primary">
                        <i class="fas fa-history me-2"></i>Semua Riwayat Verifikasi
                    </h1>
                </div>
            </div>
        </header>

        <div class="container-xl px-4">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="small text-uppercase">
                                    <th class="ps-4">Nama Objek & Kategori</th>
                                    <th>Kabupaten/Kota</th>
                                    <th>Status Sistem</th>
                                    <th>Kesimpulan Evaluator</th>
                                    <th>Verifikator</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dataCagar as $item)
                                    @php
                                        // Ambil evaluasi terbaru untuk mendapatkan kesimpulan dan catatan
                                        $evaluasiTerakhir = $item->evaluasi->sortByDesc('created_at')->first();

                                        // Warna badge untuk Status Verifikasi (Enum di tabel Cagar Budaya)
                                        $badgeColor =
                                            [
                                                'Diverifikasi' => 'bg-success',
                                                'Ditetapkan' => 'bg-primary',
                                                'Revisi' => 'bg-warning text-dark',
                                                'Ditolak' => 'bg-danger',
                                            ][$item->status_verifikasi] ?? 'bg-secondary';
                                    @endphp
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $item->nama }}</div>
                                            <small class="text-muted">{{ $item->kategori->nama_kategori ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <div class="small">
                                                <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                                {{ $item->kabupaten->nama_kabupaten ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="badge {{ $badgeColor }} small">{{ $item->status_verifikasi }}</span>
                                        </td>
                                        <td>
                                            {{-- Menampilkan kolom 'kesimpulan' dari tabel evaluasi_cagar_budaya --}}
                                            @if ($evaluasiTerakhir)
                                                <div class="small fw-bold">{{ $evaluasiTerakhir->kesimpulan }}</div>
                                                <div class="text-muted small text-truncate" style="max-width: 150px;">
                                                    "{{ $evaluasiTerakhir->catatan }}"
                                                </div>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="small fw-bold">{{ $evaluasiTerakhir->evaluator->name ?? 'System' }}
                                            </div>
                                            <div class="text-muted small" style="font-size: 0.7rem;">
                                                {{ $evaluasiTerakhir ? $evaluasiTerakhir->created_at->format('d/m/Y H:i') : '-' }}
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('evaluator.verifikasi.show', $item->id) }}"
                                                class="btn btn-xs btn-outline-primary">
                                                <i class="fas fa-search me-1"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fas fa-folder-open fa-2x mb-2 opacity-25"></i><br>
                                            Belum ada riwayat data yang diverifikasi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
