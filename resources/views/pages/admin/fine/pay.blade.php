@extends('layouts.user_type.auth')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h5 class="mb-0">Bayar Denda</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('fine.pay.process', $fine->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Pegawai</label>
                                        <input type="text" class="form-control"
                                            value="{{ $fine->borrowing->employee->name ?? 'Pegawai Tidak Ditemukan' }}"
                                            readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Total Denda</label>
                                            <input type="text" class="form-control"
                                                value="Rp {{ number_format($fine->fine_amount, 0, ',', '.') }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Sudah Dibayar</label>
                                            <input type="text" class="form-control"
                                                value="Rp {{ number_format($fine->paid_amount, 0, ',', '.') }}" readonly>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Sisa Pembayaran</label>
                                        <input type="text" class="form-control"
                                            value="Rp {{ number_format($fine->remaining_amount, 0, ',', '.') }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Nominal Pembayaran</label>
                                        <input type="number" name="payment_amount"
                                            class="form-control @error('payment_amount') is-invalid @enderror">
                                        @error('payment_amount')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Bukti Pembayaran</label>
                                        <input type="file" name="payment_proof"
                                            class="form-control @error('payment_proof') is-invalid @enderror">
                                        @error('payment_proof')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Bayar</button>
                                    <a href="{{ route('fine.index') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
