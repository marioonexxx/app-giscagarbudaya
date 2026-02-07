@extends('layouts.navbar')

@section('title', 'Daftar Usulan Cagar Budaya')

@push('styles')
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .avatar-img {
            transition: transform 0.2s;
        }

        .avatar-img:hover {
            transform: scale(1.1);
        }

        .badge-status {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.7rem;
            padding: 0.5em 0.8em;
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
                                <i class="fas fa-list-ul me-2"></i>Daftar Usulan Cagar Budaya
                            </h1>
                        </div>
                        <div class="col-12 col-xl-auto mb-3">
                            <a class="btn btn-sm btn-primary shadow-sm fw-bold text-uppercase"
                                href="{{ route('admin_kabupaten.cagar-budaya.create') }}">
                                <i class="fas fa-plus me-1"></i> Tambah Usulan Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-start-lg border-success shadow-sm"
                    role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table me-1"></i> Data Usulan
                        Kabupaten/Kota</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="tableUsulan" style="width:100%">
                            <thead class="bg-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Objek</th>
                                    <th>Kategori</th>
                                    <th>Tipe Spasial</th>
                                    <th>Status Verifikasi</th>
                                    <th>Tgl Usulan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cagarBudaya as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar me-3">
                                                    @if ($item->foto->isNotEmpty())
                                                        <img class="avatar-img rounded shadow-sm border"
                                                            src="{{ asset('storage/' . $item->foto->first()->path) }}"
                                                            style="width: 45px; height: 45px; object-fit: cover;"
                                                            alt="Thumbnail">
                                                    @else
                                                        <div class="bg-light text-muted rounded border shadow-sm d-flex align-items-center justify-content-center"
                                                            style="width: 45px; height: 45px;">
                                                            <i class="fas fa-image fa-sm"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $item->nama }}</div>
                                                    <small class="text-muted"><i class="fas fa-map-marker-alt fa-xs"></i>
                                                        {{ Str::limit($item->alamat_lengkap ?? 'Lokasi tidak spesifik', 30) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                        <td>
                                            @if ($item->tipe_geometri == 'Titik')
                                                <span class="badge bg-info-soft text-info"><i
                                                        class="fas fa-map-pin me-1"></i> Titik</span>
                                            @else
                                                <span class="badge bg-purple-soft text-purple"><i
                                                        class="fas fa-draw-polygon me-1"></i> Poligon</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = match ($item->status_verifikasi) {
                                                    'Pendaftaran'
                                                        => 'bg-warning-soft text-warning border border-warning',
                                                    'Diverifikasi' => 'bg-blue-soft text-blue border border-blue',
                                                    'Ditetapkan'
                                                        => 'bg-success-soft text-success border border-success',
                                                    'Ditolak' => 'bg-danger-soft text-danger border border-danger',
                                                    default => 'bg-light text-muted',
                                                };
                                            @endphp
                                            <span class="badge badge-status {{ $statusClass }}">
                                                <i class="fas fa-circle fa-xs me-1"></i> {{ $item->status_verifikasi }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="small text-muted">{{ $item->created_at->format('d/m/Y') }}</div>
                                            <div class="small">{{ $item->created_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group shadow-sm" role="group">
                                                <a href="{{ route('admin_kabupaten.cagar-budaya.edit', $item->id) }}"
                                                    class="btn btn-sm btn-white text-warning border"
                                                    data-bs-toggle="tooltip" title="Edit Data">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form
                                                    action="{{ route('admin_kabupaten.cagar-budaya.destroy', $item->id) }}"
                                                    method="POST" class="d-inline form-delete">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-sm btn-white text-danger border btn-delete"
                                                        data-bs-toggle="tooltip" title="Hapus Data">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            $('#tableUsulan').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                },
                columnDefs: [{
                    orderable: false,
                    targets: [0, 6]
                }]
            });

            // Inisialisasi Tooltip
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // SweetAlert untuk konfirmasi hapus
            $('.btn-delete').click(function(e) {
                let form = $(this).closest('form');
                Swal.fire({
                    title: 'Hapus Usulan?',
                    text: "Seluruh data dan foto terkait akan dihapus permanen.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74a3b',
                    cancelButtonColor: '#858796',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
