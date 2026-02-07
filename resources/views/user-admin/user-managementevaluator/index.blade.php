@extends('layouts.navbar')

@section('title', 'Manajemen User Evaluator')

@section('content')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-xl px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title text-primary">
                                <i class="fas fa-user-shield me-2"></i>Manajemen User Evaluator (TACB)
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <span class="small fw-bold text-primary text-uppercase">Daftar Akun Tim Ahli / Evaluator</span>
                    <button class="btn btn-sm btn-primary shadow-sm" id="btnTambah">
                        <i class="fas fa-plus me-1"></i> Registrasi Evaluator Baru
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="tableEvaluator">
                            <thead class="table-light text-primary">
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <th>Email / Username</th>
                                    <th>Peran</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($evaluators as $user)
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $user->name }}</div>
                                            <div class="small text-muted text-xs">Terdaftar:
                                                {{ $user->created_at->format('d/m/Y') }}</div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge bg-green-soft text-green text-uppercase">
                                                {{ $user->peran }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-light text-warning btn-edit"
                                                    data-id="{{ $user->id }}" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <form
                                                    action="{{ route('super_admin.management-userevaluator.destroy', $user->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-sm btn-light text-danger btn-delete" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="fas fa-info-circle me-1"></i> Belum ada data evaluator.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Form --}}
        <div class="modal fade" id="modalEvaluator" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-0 shadow">
                    <form id="formEvaluator" method="POST">
                        @csrf
                        <div id="methodField"></div>
                        <div class="modal-header bg-white border-bottom">
                            <h5 class="modal-title fw-bold text-primary" id="modalTitle">Form Evaluator</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="small mb-1 fw-bold text-dark">Nama Lengkap</label>
                                    <input type="text" name="name" id="name" class="form-control shadow-none"
                                        placeholder="Nama Lengkap & Gelar" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="small mb-1 fw-bold text-dark">Email</label>
                                    <input type="email" name="email" id="email" class="form-control shadow-none"
                                        placeholder="email@evaluator.com" required>
                                </div>
                                {{-- Hidden Input karena Peran Otomatis Evaluator --}}
                                <input type="hidden" name="peran" value="evaluator">

                                <div class="col-md-12">
                                    <label class="small mb-1 fw-bold text-dark">Password</label>
                                    <input type="password" name="password" id="password" class="form-control shadow-none"
                                        placeholder="Masukkan password">
                                    <div class="form-text small text-muted">Minimal 8 karakter. Kosongkan jika tidak ingin
                                        mengubah saat edit.</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light py-2 border-top">
                            <button type="button" class="btn btn-light border btn-sm text-uppercase fw-bold"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm text-uppercase fw-bold shadow-sm">
                                <i class="fas fa-save me-1"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            const evaluatorModal = new bootstrap.Modal(document.getElementById('modalEvaluator'));

            // Notifikasi Berhasil
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 2500,
                    showConfirmButton: false
                });
            @endif

            // Tambah Data
            $('#btnTambah').click(function() {
                $('#formEvaluator')[0].reset();
                $('#methodField').empty();
                $('#formEvaluator').attr('action',
                    "{{ route('super_admin.management-userevaluator.store') }}");
                $('#modalTitle').text('Registrasi Evaluator Baru');
                $('#password').attr('required', true);
                evaluatorModal.show();
            });

            // Edit Data
            $('.btn-edit').click(function() {
                let id = $(this).data('id');
                $('#methodField').html('@method('PUT')');
                $('#formEvaluator').attr('action', "{{ url('super_admin/management-userevaluator') }}/" +
                    id);
                $('#password').removeAttr('required');

                $.get("{{ url('super_admin/management-userevaluator') }}/" + id, function(data) {
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#modalTitle').text('Update Data Evaluator');
                    evaluatorModal.show();
                });
            });

            // Hapus Data
            $(document).on('click', '.btn-delete', function() {
                let form = $(this).closest('form');
                Swal.fire({
                    title: 'Hapus Evaluator?',
                    text: "Akses evaluator ini akan dicabut permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74a3b',
                    confirmButtonText: 'Ya, Hapus!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    </script>
@endpush
