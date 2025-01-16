<div class="modal fade" id="createBorrowingModal" tabindex="-1" aria-labelledby="createBorrowingModalLabel" aria-hidden="true">
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
                        <input type="date" class="form-control" id="borrow_date" name="borrow_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="return_date" class="form-label">Tanggal Pengembalian</label>
                        <input type="date" class="form-control" id="return_date" name="return_date">
                    </div>
                    <div class="mb-3">
                        <label for="loan_status" class="form-label">Status Peminjaman</label>
                        <select class="form-control" id="loan_status" name="loan_status" required>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="returned">Returned</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_employee" class="form-label">Pegawai</label>
                        <select class="form-control" id="id_employee" name="id_employee" required>
                            <option value="" disabled selected>Select Pegawai</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->nip }})</option>
                            @endforeach
                        </select>
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
