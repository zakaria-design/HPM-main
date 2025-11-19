<div wire:ignore.self class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fw-semibold" id="detailModalLabel">
          Detail Surat
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body px-4 py-3">
        @if($selectedSurat)
          <div class="table-responsive">
            <table class="table table-borderless align-middle mb-0">
              <tbody>
                <tr>
                  <th class="fw-semibold text-dark" style="width: 40%;">Nomor Surat</th>
                  <td class="text-dark">: {{ $selectedSurat->nomor_surat }}</td>
                </tr>
                <tr>
                  <th class="fw-semibold text-dark">Nama Customer</th>
                  <td class="text-dark">: {{ $selectedSurat->nama_customer }}</td>
                </tr>
                <tr>
                  <th class="fw-semibold text-dark">Nominal</th>
                  <td class="text-success">: Rp {{ number_format($selectedSurat->nominal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <th class="fw-semibold text-dark">User ID</th>
                  <td class="text-dark">: {{ $selectedSurat->user_id }}</td>
                </tr>
                <tr>
                  <th class="fw-semibold text-dark">Tanggal Dibuat</th>
                  <td class="text-dark">
                   : {{ \Carbon\Carbon::parse($selectedSurat->created_at)->format('d M Y H:i') }}
                  </td>
                </tr>
                <tr>
                  <th class="fw-semibold text-dark">Tanggal Update</th>
                  <td class="text-dark">
                   : {{ \Carbon\Carbon::parse($selectedSurat->update)->format('d M Y H:i') }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        @else
          <p class="text-muted text-center m-0">Tidak ada data untuk ditampilkan.</p>
        @endif
      </div>

      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
          Tutup
        </button>
      </div>
    </div>
  </div>
</div>

<style>
  /* Semua isi tabel rata kiri & sejajar tengah */
  .modal-body table th,
  .modal-body table td {
    text-align: left;
    vertical-align: middle;
    padding-top: 0.6rem;
    padding-bottom: 0.6rem;
  }

  .modal-body table th {
    color: #495057;
  }

  .modal-body table td {
    color: #212529;
  }
</style>
