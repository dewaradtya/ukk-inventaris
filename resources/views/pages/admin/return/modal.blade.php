<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actionModalLabel">Aksi Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center gap-4">
                    @if (Auth::check() && Auth::user()->level->name === 'Admin')
                        <a href="#" id="editLink" class="btn btn-primary d-flex align-items-center rounded-circle p-4 gap-4"
                            data-bs-toggle="tooltip" data-bs-title="Edit Peminjaman">
                            <i class="fas fa-pen fa-2x"></i>
                        </a>
                    @endif
                    <a href="#" id="proofLink" class="btn btn-secondary d-flex align-items-center rounded-circle p-4 gap-4" target="_blank"
                        data-bs-toggle="tooltip" data-bs-title="Bukti Peminjaman">
                        <i class="fas fa-file-alt fa-2x"></i>
                    </a>
                    @if (Auth::check() && Auth::user()->level->name === 'Admin')
                        <form id="deleteForm" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger d-flex align-items-center rounded-circle p-4 gap-4"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')"
                                data-bs-toggle="tooltip" data-bs-title="Hapus Peminjaman">
                                <i class="fas fa-trash fa-2x"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const actionModal = new bootstrap.Modal(document.getElementById("actionModal"));
        const editLink = document.getElementById("editLink");
        const proofLink = document.getElementById("proofLink");
        const deleteForm = document.getElementById("deleteForm");

        document.body.addEventListener("click", function (event) {
            const target = event.target.closest(".open-action-modal");
            if (!target) return;

            event.preventDefault();

            const editUrl = target.dataset.edit;
            const proofUrl = target.dataset.proof;
            const deleteUrl = target.dataset.delete;

            if (editLink) editLink.href = editUrl;
            if (proofLink) proofLink.href = proofUrl;
            if (deleteForm) deleteForm.action = deleteUrl;

            actionModal.show();
        });
    });
</script>
