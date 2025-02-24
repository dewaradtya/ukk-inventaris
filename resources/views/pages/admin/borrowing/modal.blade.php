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
                        class="btn btn-secondary d-flex align-items-center rounded-circle p-4 gap-4" target="_blank"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                        data-bs-title="Bukti Peminjaman">
                        <i class="fas fa-file-alt fa-2x"></i>
                    </a>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger d-flex align-items-center rounded-circle p-4 gap-4"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                            data-bs-title="Hapus Peminjaman">
                            <i class="fas fa-trash fa-2x"></i>
                        </button>
                    </form>

                    @if (Auth::check() && in_array(Auth::user()->level->name, ['Admin', 'Operator']))
                        <a href="#" id="returnLink"
                            class="btn btn-success d-flex align-items-center rounded-circle p-4 gap-4"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                            data-bs-title="Form Pengembalian">
                            <i class="fas fa-check fa-2x"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const actionModal = new bootstrap.Modal(document.getElementById("actionModal"));
        const editLink = document.getElementById("editLink");
        const proofLink = document.getElementById("proofLink");
        const deleteForm = document.getElementById("deleteForm");
        const returnLink = document.getElementById("returnLink");

        document.body.addEventListener("click", function(event) {
            const target = event.target.closest(".open-action-modal");
            if (!target) return;

            event.preventDefault();
            event.stopPropagation();

            const borrowId = target.dataset.id;
            const editUrl = target.dataset.edit;
            const proofUrl = target.dataset.proof;
            const deleteUrl = target.dataset.delete;
            const statusUrl = target.dataset.status;
            const loanStatus = target.dataset.loanStatus;

            editLink.href = editUrl;
            proofLink.href = proofUrl;
            deleteForm.action = deleteUrl;

            if (returnLink) {
                returnLink.href = statusUrl;
                returnLink.style.display = loanStatus === "borrow" ? "inline-block" : "none";
            }

            actionModal.show();
        });
    });
</script>
