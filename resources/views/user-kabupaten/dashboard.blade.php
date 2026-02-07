@extends('layouts.navbar')

@section('title', 'Dashboard Super Admin')

@section('content')
    <main>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-5">
            <!-- Custom page header alternative example-->
            <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                <div class="me-4 mb-3 mb-sm-0">
                    <h1 class="mb-0">Dashboard</h1>
                    <div class="small">
                        <span class="fw-500 text-primary">Friday</span>
                        &middot; September 20, 2021 &middot; 12:16 PM
                    </div>
                </div>
                <!-- Date range picker example-->
                <div class="input-group input-group-joined border-0 shadow" style="width: 16.5rem">
                    <span class="input-group-text"><i data-feather="calendar"></i></span>
                    <input class="form-control ps-0 pointer" id="litepickerRangePlugin"
                        placeholder="Select date range..." />
                </div>
            </div>
            <!-- Illustration dashboard card example-->
            <div class="card card-waves mb-4 mt-5">
                <div class="card-body p-5">
                    <div class="row align-items-center justify-content-between">
                        <div class="col">
                            <h2 class="text-primary">Panel Manajemen Kebudayaan Provinsi Maluku</h2>
                            <p class="text-gray-700">
                                Selamat datang di pusat kendali data kebudayaan. Dashboard ini mengintegrasikan seluruh data
                                objek cagar budaya
                                dari 11 Kabupaten/Kota di Maluku. Pastikan seluruh data cagar budaya—baik kebendaan maupun
                                takbenda—terdata
                                dengan akurat untuk mendukung upaya pelestarian aset bangsa.
                            </p>
                            <a class="btn btn-primary p-3" href="#!">
                                Mulai Kelola Data
                                <i class="ms-1" data-feather="external-link"></i>
                            </a>
                        </div>
                        <div class="col d-none d-lg-block mt-xxl-n4"><img class="img-fluid px-xl-4 mt-xxl-n5"
                                src="{{ asset('sbadmin/assets/img/illustrations/statistics.svg') }}" /></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-start-lg border-start-warning h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small fw-bold text-warning mb-1">Usulan Baru (Pendaftaran)</div>
                                    <div class="h5">{{ $countPendaftaran }} Objek</div>
                                    <div class="text-xs text-gray-500">Menunggu tinjauan awal</div>
                                </div>
                                <div class="ms-2"><i class="fas fa-file-medical fa-2x text-gray-200"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-start-lg border-start-info h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small fw-bold text-info mb-1">Telah Diverifikasi</div>
                                    <div class="h5">{{ $countDiverifikasi }} Objek</div>
                                    <div class="text-xs text-gray-500">Data telah divalidasi sistem</div>
                                </div>
                                <div class="ms-2"><i class="fas fa-check-double fa-2x text-gray-200"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-start-lg border-start-success h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small fw-bold text-success mb-1">Ditetapkan (SK)</div>
                                    <div class="h5">{{ $countDitetapkan }} Objek</div>
                                    <div class="text-xs text-gray-500">Resmi sebagai Cagar Budaya</div>
                                </div>
                                <div class="ms-2"><i class="fas fa-certificate fa-2x text-gray-200"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-start-lg border-start-danger h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div class="small fw-bold text-danger mb-1">Ditolak / Tidak Layak</div>
                                    <div class="h5">{{ $countDitolak }} Objek</div>
                                    <div class="text-xs text-gray-500">Tidak memenuhi kriteria</div>
                                </div>
                                <div class="ms-2"><i class="fas fa-times-circle fa-2x text-gray-200"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
