@extends('layouts.user_type.auth')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid py-4">
            @if (in_array(auth()->user()->level->name, ['Admin', 'Operator']))
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header pb-0 d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-0">Tabel Pegawai</h6>
                                </div>
                                <div class="d-flex">
                                    <form action="{{ route('employee.index') }}" method="GET" class="d-flex me-2">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control form-control-sm"
                                                placeholder="Cari nama atau nip..." value="{{ request('search') }}">
                                            <span class="input-group-text text-body"><i class="fas fa-search"
                                                    aria-hidden="true"></i></span>
                                        </div>
                                    </form>
                                    <button class="btn bg-gradient-primary btn-sm mb-0" data-bs-toggle="modal"
                                        data-bs-target="#createEmployeeModal">
                                        Tambah Pegawai
                                    </button>
                                </div>
                            </div>
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Nama</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    NIP</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Alamat</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employees as $employee)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-xs">{{ $employee->name }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $employee->nip }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $employee->address }}
                                                        </p>
                                                    </td>
                                                    <td class="align-middle">
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
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary pb-2">
                                <h6 class="card-title text-white mb-0">Profil Anda</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <div class="card w-75">
                                        <div class="card-header text-center bg-light">
                                            <h5 class="mb-0">
                                                {{ auth()->user()->employee->first() ? auth()->user()->employee->first()->name : 'Data Name belum tersedia' }}                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4 text-right font-weight-bold">NIP:</div>
                                                <div class="col-8">
                                                    {{ auth()->user()->employee->first() ? auth()->user()->employee->first()->nip : 'Data NIP belum tersedia' }}
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-4 text-right font-weight-bold">Alamat:</div>
                                                <div class="col-8">
                                                    {{ auth()->user()->employee->first() ? auth()->user()->employee->first()->address : 'Data Alamat belum tersedia' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3 text-center">
                                    @if (auth()->user()->employee && auth()->user()->employee->first())
                                        <a href="{{ route('employee.edit', auth()->user()->employee->first()->id) }}"
                                            class="btn btn-warning btn-sm mb-0">
                                            Edit Pegawai
                                        </a>
                                    @else
                                        <button class="btn btn-success btn-sm mb-0" data-bs-toggle="modal"
                                            data-bs-target="#createEmployeeModal">
                                            Tambah Pegawai
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
    @include('pages.admin.employee.create')
@endsection
