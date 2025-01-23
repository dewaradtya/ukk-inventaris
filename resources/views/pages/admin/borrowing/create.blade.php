<div class="modal fade" id="createBorrowingModal" tabindex="-1" aria-labelledby="createBorrowingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBorrowingModalLabel">Create New Borrowing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('borrowing.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="borrow_date" class="form-label">Tanggal Peminjaman</label>
                        <input type="date" class="form-control @error('borrow_date') is-invalid @enderror"
                            id="borrow_date" name="borrow_date" value="{{ old('borrow_date') }}" required>
                        @error('borrow_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="return_date" class="form-label">Tanggal Pengembalian</label>
                        <input type="date" class="form-control @error('return_date') is-invalid @enderror"
                            id="return_date" name="return_date" value="{{ old('return_date') }}" readonly>
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
                            <option value="borrow" {{ old('loan_status') == 'borrow' ? 'selected' : '' }}>Dipinjam
                            </option>
                            <option value="returned" {{ old('loan_status') == 'returned' ? 'selected' : '' }}>Dikembalikan
                            </option>
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
                            <option value="" disabled selected>Select Pegawai</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ old('id_employee') == $employee->id ? 'selected' : '' }}>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
