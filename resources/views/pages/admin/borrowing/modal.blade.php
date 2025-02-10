<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actionModalLabel">Aksi Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center gap-4">
                    <a href="#" id="editLink"
                        class="btn btn-primary d-flex align-items-center rounded-circle p-4 gap-4"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                        data-bs-title="Edit Peminjaman">
                        <i class="fas fa-pen fa-2x"></i>
                    </a>
                    <a href="#" id="proofLink"
                        class="btn btn-secondary d-flex align-items-center rounded-circle p-4 gap-4" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                        data-bs-title="Bukti Peminjaman">
                        <i class="fas fa-file-alt fa-2x"></i>
                    </a>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger d-flex align-items-center rounded-circle p-4 gap-4"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                            data-bs-title="Hapus Peminjaman">
                            <i class="fas fa-trash fa-2x"></i>
                        </button>
                    </form>
                    <form id="returnForm" method="POST" class="d-inline" style="display: none;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="loan_status" value="return">
                        <button type="submit"
                            class="btn btn-success d-flex align-items-center rounded-circle p-4 gap-4"
                            onclick="return confirm('Apakah Anda yakin ingin mengubah status peminjaman ini?')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                            data-bs-title="Sudah Dikembalikan">
                            <i class="fas fa-check fa-2x"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const borrowRows = document.querySelectorAll(".borrow-row");
        const actionModal = new bootstrap.Modal(document.getElementById("actionModal"));
        const editLink = document.getElementById("editLink");
        const proofLink = document.getElementById("proofLink");
        const deleteForm = document.getElementById("deleteForm");
        const returnForm = document.getElementById("returnForm");

        borrowRows.forEach(row => {
            row.addEventListener("click", function() {
                const borrowId = this.dataset.id;
                const editUrl = this.dataset.edit;
                const proofUrl = this.dataset.proof;
                const deleteUrl = this.dataset.delete;
                const statusUrl = this.dataset.status;
                const loanStatus = this.dataset.loanStatus;

                editLink.href = editUrl;
                proofLink.href = proofUrl;
                deleteForm.action = deleteUrl;
                returnForm.action = statusUrl;

                if (loanStatus === "borrow") {
                    returnForm.style.display = "inline-block";
                } else {
                    returnForm.style.display = "none";
                }

                actionModal.show();
            });
        });
    });
</script>
