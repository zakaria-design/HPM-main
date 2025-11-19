<div wire:ignore.self class="modal fade" id="allModal" tabindex="-1" aria-labelledby="allModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="allModalLabel">
            Daftar Semua Surat
            <span class="fw-light">({{ $modalType === 'sph' ? 'SPH Berhasil' : 'SPH Gagal' }})</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @if($allData)
            @foreach($allData as $item)
                <div class="p-2 mb-2 border rounded bg-light d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $item->nomor_surat }}</strong> — {{ $item->nama_customer }} <br>
                        <span class="text-secondary">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                    </div>
                    <button wire:click="showDetail({{ $item->id }}, '{{ $modalType }}')" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-eye"></i> Detail
                    </button>
                </div>
            @endforeach
        @else
            <p class="text-center text-muted">Tidak ada data ditemukan.</p>
        @endif
      </div>
    </div>
  </div>
</div>
