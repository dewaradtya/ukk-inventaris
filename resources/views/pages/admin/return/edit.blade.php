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
                            <form action="{{ route('return.update', $return->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control" id="borrow_date" name="borrow_date"
                                                value="{{ old('borrow_date', $return->borrow_date) }}" readonly>
                                            <label for="borrow_date">Tanggal Peminjaman</label>
                                        </div>
                                    </div>

                                    @if (auth()->user()->level->name !== 'Peminjam')
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="date" class="form-control" id="return_date"
                                                    name="return_date"
                                                    value="{{ old('return_date', $return->return_date) }}" readonly>
                                                <label for="return_date">Tanggal Pengembalian</label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="id_employee" class="form-label">Pegawai</label>
                                            <select class="form-control" id="id_employee" name="id_employee" disabled>
                                                <option value="" disabled selected>Pilih Pegawai</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}"
                                                        {{ old('id_employee', $return->id_employee) == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->name }} ({{ $employee->nip }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    <div id="inventory-container">
                                        @foreach ($return->loanDetails as $loanDetail)
                                            <div class="inventory-item">
                                                <div class="mb-3">
                                                    <label class="form-label">Pilih Inventaris</label>
                                                    <select name="id_inventories[]" class="form-control" disabled>
                                                        @foreach ($inventories as $inventory)
                                                            <option value="{{ $inventory->id }}"
                                                                {{ $inventory->id == $loanDetail->id_inventories ? 'selected' : '' }}>
                                                                {{ $inventory->name }} (Stok: {{ $inventory->amount }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Jumlah</label>
                                                    <input type="number" name="amount[]" class="form-control"
                                                        min="1" value="{{ $loanDetail->amount }}" readonly>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Status Peminjaman</label>
                                        <select class="form-control @error('loan_status') is-invalid @enderror"
                                            id="loan_status" name="loan_status">
                                            <option value="borrow"
                                                {{ $return->loan_status == 'borrow' ? 'selected' : '' }}>Dipinjam</option>
                                            <option value="return"
                                                {{ $return->loan_status == 'return' ? 'selected' : '' }}>Dikembalikan
                                            </option>
                                        </select>
                                    </div>

                                </div>

                                <div class="card-footer">
                                    <a href="{{ route('borrowing.index') }}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </main>
@endsection
