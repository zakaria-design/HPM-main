<!-- Modal Bootstrap 5 -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white small">
        <h5 class="modal-title" id="detailModalLabel">Detail Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-grid gap-2" style="grid-template-columns: 130px 20px 1fr; align-items: center; row-gap: 8px;">
          <div class="text-start fw-bold">Nomor Surat</div>
          <div class="text-center fw-bold">:</div>
          <div class="text-start"><span id="modal-id"></span></div>

          <div class="text-start fw-bold">Nama Customer</div>
          <div class="text-center fw-bold">:</div>
          <div class="text-start"><span id="modal-nama"></span></div>

          <div class="text-start fw-bold">Tanggal Input</div>
          <div class="text-center fw-bold">:</div>
          <div class="text-start"><span id="modal-tanggal"></span></div>

          <div class="text-start fw-bold">User</div>
          <div class="text-center fw-bold">:</div>
          <div class="text-start"><span id="modal-user"></span></div>

          <div class="text-start fw-bold">Keterangan</div>
          <div class="text-center fw-bold">:</div>
          <div class="text-start"><span id="modal-keterangan"></span></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm small" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
