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
                            <form action="{{ route('officer.update', $officer->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="borrow_date" class="form-label">Tanggal Peminjaman</label>
                                    <input type="date" class="form-control" id="borrow_date" name="borrow_date" 
                                        value="{{ old('borrow_date', $officer->borrow_date) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="return_date" class="form-label">Tanggal Pengembalian</label>
                                    <input type="date" class="form-control" id="return_date" name="return_date" 
                                        value="{{ old('return_date', $officer->return_date) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="loan_status" class="form-label">Status Peminjaman</label>
                                    <select class="form-control" id="loan_status" name="loan_status" required>
                                        <option value="pending" {{ old('loan_status', $officer->loan_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ old('loan_status', $officer->loan_status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="returned" {{ old('loan_status', $officer->loan_status) == 'returned' ? 'selected' : '' }}>Returned</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="id_level" class="form-label">Petugas</label>
                                    <select class="form-control" id="id_level" name="id_level" required>
                                        <option value="" disabled selected>Pilih Petugas</option>
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}" 
                                                {{ old('id_level', $officer->id_level) == $level->id ? 'selected' : '' }}>
                                                {{ $level->name }} ({{ $level->nip }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="card-footer">
                                    <a href="{{ route('officer.index') }}" class="btn btn-secondary">Back</a>
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
