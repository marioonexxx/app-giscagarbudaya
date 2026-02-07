@extends('layouts.navbar')

@section('title', 'Dashboard Evaluator')

@section('content')
    <main>
        <div class="container-xl px-4 mt-5">
            <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                <div class="me-4 mb-3 mb-sm-0">
                    <h1 class="mb-0 text-primary fw-bold">Evaluasi & Verifikasi</h1>
                    <div class="text-muted">Selamat bekerja, {{ auth()->user()->name }}. Periksa data dengan teliti.</div>
                </div>
                <div class="col-12 col-xl-auto">
                    <div class="text-muted small"><i class="fas fa-calendar-alt me-1"></i> {{ date('d F Y') }}</div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-start-lg border-warning h-100 shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small fw-bold text-warning text-uppercase mb-1">Antrean Verifikasi</div>
                                    <div class="h3 fw-bold">{{ $antreanVerifikasi }}</div>
                                </div>
                                <div class="ms-2">
                                    <i class="fas fa-hourglass-start fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-start-lg border-success h-100 shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small fw-bold text-success text-uppercase mb-1">Total Selesai</div>
                                    <div class="h3 fw-bold">{{ $totalSelesai }}</div>
                                </div>
                                <div class="ms-2">
                                    <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-start-lg border-danger h-100 shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small fw-bold text-danger text-uppercase mb-1">Total Ditolak</div>
                                    <div class="h3 fw-bold">{{ $totalDitolak ?? 0 }}</div>
                                </div>
                                <div class="ms-2">
                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Usulan Baru Perlu Verifikasi</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 px-4">Nama Objek</th>
                                    <th class="border-0">Kategori</th>
                                    <th class="border-0">Kabupaten/Kota</th>
                                    <th class="border-0">Spasial</th>
                                    <th class="border-0">Tanggal Masuk</th>
                                    <th class="border-0 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tugasTerbaru as $item)
                                    <tr>
                                        <td class="px-4">
                                            <div class="fw-bold text-dark">{{ $item->nama }}</div>
                                        </td>
                                        <td>{{ $item->kategori->nama_kategori ?? 'Umum' }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                {{ $item->user->name ?? 'Admin Kab' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($item->tipe_geometri == 'Titik')
                                                <small class="text-info"><i class="fas fa-map-pin me-1"></i> Titik</small>
                                            @else
                                                <small class="text-purple"><i class="fas fa-draw-polygon me-1"></i>
                                                    Poligon</small>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at->format('d M Y') }}</td>
                                        <td class="text-center">
                                            {{-- Sesuaikan route ini dengan yang ada di web.php Anda --}}
                                            <a class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm"
                                                href="{{ route('evaluator.verifikasi.show', $item->id) }}">
                                                <i class="fas fa-search me-1"></i> Periksa
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fas fa-check-circle fa-3x mb-3 text-light"></i>
                                            <p class="mb-0">Tidak ada usulan baru yang perlu diverifikasi saat ini.</p>
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
