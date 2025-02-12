@extends('layouts.user_type.auth')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            @if (in_array(auth()->user()->level->name, ['Admin', 'Operator']))
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                    <div>
                                        <h5 class="mb-0">Manajemen Pegawai</h5>
                                        <p class="text-muted small mb-0">Kelola data pegawai</p>
                                    </div>
                                    <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
                                        <form action="{{ route('employee.index') }}" method="GET" class="w-100 w-sm-auto">
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="search" class="form-control form-control-sm"
                                                    placeholder="Cari nama atau nip..." value="{{ request('search') }}">
                                                <span class="input-group-text text-body"><i class="fas fa-search"
                                                        aria-hidden="true"></i></span>
                                            </div>
                                        </form>

                                        <div class="d-flex gap-2">
                                            <button class="btn bg-gradient-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#createEmployeeModal">
                                                Tambah Pegawai
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="table-responsive px-4">
                                    <table class="table table-hover table-striped align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Nama</th>
                                                <th
                                                    class="text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    NIP</th>
                                                <th
                                                    class="text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Alamat</th>
                                                <th
                                                    class="text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employees as $employee)
                                                <tr>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $employee->name }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-primary font-weight-bold text-white">{{ $employee->nip }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $employee->address }}
                                                        </p>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('employee.edit', $employee->id) }}"
                                                            class="btn btn-outline-primary p-2">
                                                            <i class="fa fa-pen text-primary fa-lg" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Edit"></i>
                                                        </a>
                                                        <form action="{{ route('employee.destroy', $employee->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger p-2"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus pegawai ini?')"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Hapus">
                                                                <i class="fa fa-trash fa-lg"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $employees->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="card border-0 shadow-lg">
                            <div class="card-header bg-primary text-white text-center position-relative py-4">
                                <div class="position-absolute top-0 start-0 p-3">
                                    <i class="fas fa-user fs-4"></i>
                                </div>
                                <h5 class="mb-0 text-white">KARTU PEGAWAI</h5>
                            </div>

                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <div class="position-relative d-inline-block">
                                        <div class="rounded-circle overflow-hidden border border-4 border-primary shadow-sm"
                                            style="width: 120px; height: 120px;">
                                            <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('assets/img/default-avatar.jpg') }}" alt="Profile Picture" class="img-fluid">
                                        </div>
                                        <div class="position-absolute bottom-0 end-0">
                                            <span class="badge rounded-pill bg-success">
                                                <i class="fas fa-check-circle"></i> Active
                                            </span>
                                        </div>
                                    </div>

                                    <h4 class="mt-3 mb-1">
                                        {{ auth()->user()->employee->first() ? auth()->user()->employee->first()->name : 'Data Name belum tersedia' }}
                                    </h4>
                                </div>

                                <div class="border-top pt-3">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-id-card text-primary me-2"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <small class="text-muted">NIP</small>
                                                    <div class="fw-bold">
                                                        {{ auth()->user()->employee->first() ? auth()->user()->employee->first()->nip : 'Data NIP belum tersedia' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-location-dot text-primary me-2"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <small class="text-muted">Alamat</small>
                                                    <div class="fw-bold">
                                                        {{ auth()->user()->employee->first() ? auth()->user()->employee->first()->address : 'Data Alamat belum tersedia' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    @if (auth()->user()->employee && auth()->user()->employee->first())
                                        <a href="{{ route('employee.edit', auth()->user()->employee->first()->id) }}"
                                            class="btn btn-warning btn-sm"> Edit Pegawai
                                        </a>
                                    @else
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#createEmployeeModal">Tambah Pegawai
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="card-footer bg-light text-center py-2">
                                <small class="text-muted">
                                    <i class="fas fa-shield-alt me-1"></i> ID Card Valid until 2025
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
    @include('pages.admin.employee.create')
@endsection
