@extends('layouts.user_type.auth')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Edit Peminjaman</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('borrowing.update', $borrowing->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="borrow_date" class="form-label">Tanggal Peminjaman</label>
                                    <input type="date" class="form-control @error('borrow_date') is-invalid @enderror"
                                        id="borrow_date" name="borrow_date"
                                        value="{{ old('borrow_date', $borrowing->borrow_date) }}">
                                    @error('borrow_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="return_date" class="form-label">Tanggal Pengembalian</label>
                                    <input type="date" class="form-control @error('return_date') is-invalid @enderror"
                                        id="return_date" name="return_date"
                                        value="{{ old('return_date', $borrowing->return_date) }}">
                                    @error('return_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="loan_status" class="form-label">Status Peminjaman</label>
                                    <select class="form-control @error('loan_status') is-invalid @enderror" id="loan_status"
                                        name="loan_status">
                                        <option value="borrow"
                                            {{ old('loan_status', $borrowing->loan_status) == 'borrow' ? 'selected' : '' }}>
                                            Dipinjam</option>
                                        <option value="returned"
                                            {{ old('loan_status', $borrowing->loan_status) == 'returned' ? 'selected' : '' }}>
                                            Dikembalikan</option>
                                    </select>
                                    @error('loan_status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="id_employee" class="form-label">Pegawai</label>
                                    <select class="form-control @error('id_employee') is-invalid @enderror" id="id_employee"
                                        name="id_employee">
                                        <option value="" disabled selected>Pilih Pegawai</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"
                                                {{ old('id_employee', $borrowing->id_employee) == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }} ({{ $employee->nip }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_employee')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="card-footer">
                                    <a href="{{ route('borrowing.index') }}" class="btn btn-secondary">Back</a>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
