<div class="modal fade" id="detailModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow">

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detail User</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="row align-items-start">

                    <!-- FOTO: Mobile di atas, Desktop di kanan -->
                    <div class="col-md-4 text-center order-1 order-md-2 mb-3 mb-md-0">
                        <img id="d_foto" src=""
                             class="img-thumbnail rounded"
                             style="width:200px; height:200px; object-fit:cover;">
                    </div>

                    <!-- DETAIL: Mobile di bawah, Desktop di kiri -->
                    <div class="col-md-8 order-2 order-md-1">

                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Nama</div>
                            <div class="col-8">: <span id="d_nama"></span></div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-4 fw-bold">User ID</div>
                            <div class="col-8">: <span id="d_userid"></span></div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Email</div>
                            <div class="col-8">: <span id="d_email"></span></div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Role</div>
                            <div class="col-8">: <span id="d_role"></span></div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Alamat</div>
                            <div class="col-8">: <span id="d_alamat"></span></div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-4 fw-bold">No HP</div>
                            <div class="col-8">: <span id="d_hp"></span></div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-4 fw-bold">Dibuat Pada</div>
                            <div class="col-8">: <span id="d_created"></span></div>
                        </div>

                    </div>

                </div>

            </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm small" data-bs-dismiss="modal">Tutup</button>
      </div>
        </div>
    </div>
</div>
