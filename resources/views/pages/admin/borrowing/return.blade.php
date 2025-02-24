@extends('layouts.user_type.auth')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Form Pengembalian Barang</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <!-- Borrower Information Card -->
                                <div class="col-lg-6 mb-4 mb-lg-0">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-header bg-gradient-primary p-3">
                                            <h6 class="text-white mb-0">
                                                Data Peminjam
                                            </h6>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="info-item mb-3">
                                                <label class="text-muted mb-1">Nama Peminjam</label>
                                                <p class="h6 mb-0">{{ $borrowing->employee->name }}</p>
                                            </div>
                                            <div class="info-item mb-3">
                                                <label class="text-muted mb-1">NIP</label>
                                                <p class="h6 mb-0">{{ $borrowing->employee->nip }}</p>
                                            </div>
                                            <div class="info-item mb-3">
                                                <label class="text-muted mb-1">Alamat</label>
                                                <p class="h6 mb-0">{{ $borrowing->employee->address }}</p>
                                            </div>
                                            <div class="info-item">
                                                <label class="text-muted mb-1">Tanggal Peminjaman</label>
                                                <p class="h6 mb-0">
                                                    {{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d M Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Borrowed Items Card -->
                                <div class="col-lg-6">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-header bg-gradient-info p-3">
                                            <h6 class="text-white mb-0">
                                                Detail Barang yang Dipinjam
                                            </h6>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="table-responsive">
                                                <table class="table table-hover align-middle">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="border-0">Nama Barang</th>
                                                            <th class="border-0 text-center">Jumlah</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($borrowing->loanDetails as $loanDetail)
                                                            <tr>
                                                                <td>{{ $loanDetail->inventory->name }}</td>
                                                                <td class="text-center">
                                                                    <span
                                                                        class="badge bg-info">{{ $loanDetail->amount }}</span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Return Form Card -->
                            <div class="card shadow-sm">
                                <div class="card-header bg-gradient-success p-3">
                                    <h6 class="text-white mb-0">
                                        Form Pengembalian Barang
                                    </h6>
                                </div>
                                <div class="card-body p-4">
                                    <form
                                        action="{{ route('borrowing.updateStatus', ['id' => $borrowing->id, 'status' => 'return']) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="loan_status" value="return">

                                        <div class="row g-4">
                                            <div class="col-md-12">
                                                <label class="form-label">Tanggal Peminjaman</label>
                                                <div class="input-group">
                                                    <input type="date" class="form-control" id="borrow_date"
                                                        name="borrow_date" value="{{ $borrowing->borrow_date }}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label">Tanggal Pengembalian</label>
                                                <div class="input-group">
                                                    <input type="date" class="form-control" id="return_date"
                                                        name="return_date" value="{{ now()->format('Y-m-d') }}" readonly>
                                                </div>
                                            </div>

                                            @foreach ($borrowing->loanDetails as $loanDetail)
                                                <div class="col-md-12">
                                                    <label class="form-label">Kondisi Barang Saat Dipinjam -
                                                        {{ $loanDetail->inventory->name }}</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control"
                                                            value="{{ $loanDetail->condition_borrowed }}" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="form-label">Kondisi Barang Saat Dikembalikan -
                                                        {{ $loanDetail->inventory->name }}</label>
                                                    <div class="input-group">
                                                        <select
                                                            class="form-select @error('condition_returned.' . $loanDetail->id) is-invalid @enderror"
                                                            name="condition_returned[{{ $loanDetail->id }}]">
                                                            <option value="" disabled selected>Pilih Kondisi</option>
                                                            <option value="baik"
                                                                {{ old('condition_returned.' . $loanDetail->id) == 'baik' ? 'selected' : '' }}>
                                                                Baik</option>
                                                            <option value="rusak"
                                                                {{ old('condition_returned.' . $loanDetail->id) == 'rusak' ? 'selected' : '' }}>
                                                                Rusak</option>
                                                            <option value="hilang"
                                                                {{ old('condition_returned.' . $loanDetail->id) == 'hilang' ? 'selected' : '' }}>
                                                                Hilang</option>
                                                        </select>
                                                        @error('condition_returned.' . $loanDetail->id)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="d-flex justify-content-end mt-4">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-check me-2"></i>Konfirmasi Pengembalian
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
