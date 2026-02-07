@extends('layouts.navbar')

@section('title', 'Manajemen Admin Kabupaten')

@section('content')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-xl px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title text-primary">
                                <i class="fas fa-users-cog me-2"></i>Manajemen Admin Kabupaten
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <span class="small fw-bold text-primary text-uppercase">Daftar Akun Admin Wilayah</span>
                    <button class="btn btn-sm btn-primary shadow-sm" id="btnTambah">
                        <i class="fas fa-user-plus me-1"></i> Registrasi Admin Baru
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="tableUser">
                            <thead class="table-light text-primary">
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <th>Email / Username</th>
                                    <th>Wilayah Kerja</th>
                                    <th>Peran</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $user->name }}</div>
                                            <div class="small text-muted text-xs">Dibuat:
                                                {{ $user->created_at->format('d/m/Y') }}</div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge bg-blue-soft text-blue">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                {{ $user->wilayah->nama ?? 'Semua Wilayah' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-capitalize small fw-bold text-muted">
                                                {{ str_replace('_', ' ', $user->peran) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-light text-warning btn-edit"
                                                    data-id="{{ $user->id }}" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                @if ($user->id !== auth()->id())
                                                    <form
                                                        action="{{ route('super_admin.user-management.destroy', $user->id) }}"
                                                        method="POST" class="d-inline form-delete">
                                                        @csrf @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-sm btn-light text-danger btn-delete"
                                                            title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge bg-light text-muted small">Aktif</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted small italic">
                                            <i class="fas fa-info-circle me-1"></i> Belum ada user yang terdaftar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalUser" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-0 shadow">
                    <form id="formUser" method="POST">
                        @csrf
                        <div id="methodField"></div>
                        <div class="modal-header bg-white border-bottom">
                            <h5 class="modal-title fw-bold text-primary" id="modalTitle">Form User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="small mb-1 fw-bold text-dark">Nama Lengkap</label>
                                    <input type="text" name="name" id="name" class="form-control shadow-none"
                                        placeholder="Contoh: Admin Maluku Tengah" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="small mb-1 fw-bold text-dark">Email</label>
                                    <input type="email" name="email" id="email" class="form-control shadow-none"
                                        placeholder="admin@mail.com" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="small mb-1 fw-bold text-dark">Peran (Role)</label>
                                    <select name="peran" id="peran" class="form-select shadow-none" required>
                                        <option value="admin_kabupaten">Admin Kabupaten</option>
                                        {{-- <option value="evaluator">Evaluator</option>
                                        <option value="super_admin">Super Admin</option> --}}
                                    </select>
                                </div>
                                <div class="col-md-12" id="wilayahContainer">
                                    <label class="small mb-1 fw-bold text-dark">Wilayah Penempatan</label>
                                    <select name="kode_wilayah" id="kode_wilayah" class="form-select shadow-none">
                                        <option value="">-- Pilih Wilayah --</option>
                                        @foreach ($listWilayah as $w)
                                            <option value="{{ $w->kode }}">{{ $w->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-text small">Wilayah kerja admin di tingkat Kabupaten/Kota.</div>
                                </div>
                                <div class="col-md-12 border-top pt-3">
                                    <label class="small mb-1 fw-bold text-dark">Password</label>
                                    <input type="password" name="password" id="password" class="form-control shadow-none"
                                        placeholder="Masukkan password">
                                    <div id="pass_hint" class="form-text small text-muted">Minimal 8 karakter. Kosongkan
                                        jika tidak ingin mengubah password saat edit.</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light py-2 border-top">
                            <button type="button" class="btn btn-light border btn-sm text-uppercase fw-bold"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm text-uppercase fw-bold shadow-sm">
                                <i class="fas fa-save me-1"></i> Simpan Akun
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
            // 1. Logika Tampilan Wilayah Berdasarkan Peran
            function toggleWilayah() {
                if ($('#peran').val() === 'admin_kabupaten') {
                    $('#wilayahContainer').show();
                } else {
                    $('#wilayahContainer').hide();
                    $('#kode_wilayah').val('');
                }
            }
            $('#peran').change(toggleWilayah);

            // 2. SweetAlert Success Notification
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 2500,
                    showConfirmButton: false
                });
            @endif

            // 3. SweetAlert Error Notification
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan!',
                    text: "{{ session('error') }}",
                });
            @endif

            // 4. Modal Tambah User
            $('#btnTambah').click(function() {
                $('#formUser')[0].reset();
                $('#methodField').html('');
                $('#formUser').attr('action', "{{ route('super_admin.user-management.store') }}");
                $('#modalTitle').text('Registrasi Admin Baru');
                $('#password').attr('required', true);
                toggleWilayah();
                $('#modalUser').modal('show');
            });

            // 5. Modal Edit User (AJAX)
            $('.btn-edit').click(function() {
                let id = $(this).data('id');
                $('#methodField').html('@method('PUT')');
                $('#formUser').attr('action', "{{ url('super_admin/user-management') }}/" + id);
                $('#password').removeAttr('required');

                $.get("{{ url('super_admin/user-management') }}/" + id, function(data) {
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#peran').val(data.peran);
                    $('#kode_wilayah').val(data.kode_wilayah);
                    toggleWilayah();
                    $('#modalTitle').text('Update Data Admin');
                    $('#modalUser').modal('show');
                }).fail(function() {
                    Swal.fire('Error', 'Gagal mengambil data user', 'error');
                });
            });

            // 6. SweetAlert Konfirmasi Hapus
            $(document).on('click', '.btn-delete', function(e) {
                let form = $(this).closest('form');
                Swal.fire({
                    title: 'Hapus Akun?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74a3b',
                    cancelButtonColor: '#858796',
                    confirmButtonText: 'Ya, Hapus Akun!',
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
