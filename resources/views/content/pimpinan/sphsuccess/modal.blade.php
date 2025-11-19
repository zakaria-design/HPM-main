<div wire:ignore.self class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detail Surat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body px-4" style="max-height: 60vh; overflow-y: auto;">
                @if($selectedSurat)

                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Nomor Surat</div>
                        <div class="col-7">: {{ $selectedSurat->nomor_surat ?? '-' }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Nama Customer</div>
                        <div class="col-7">: {{ $selectedSurat->nama_customer ?? '-' }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Nominal</div>
                        <div class="col-7">: Rp. {{ isset($selectedSurat->nominal) ? number_format($selectedSurat->nominal, 0, ',', '.') : '-' }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 fw-bold">User</div>
                        <div class="col-7">
                            : 
                            @php
                                $user = \App\Models\User::where('user_id', $selectedSurat->user_id)->first();
                            @endphp
                            {{ $user ? $user->name : '-' }}
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Di Buat</div>
                        <div class="col-7">
                            : {{ isset($selectedSurat->created_at) ? \Carbon\Carbon::parse($selectedSurat->created_at)->format('d-m-Y H:i') : '-' }}
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Di Update</div>
                        <div class="col-7">
                            : {{ isset($selectedSurat->update) ? \Carbon\Carbon::parse($selectedSurat->update)->format('d-m-Y H:i') : '-' }}
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Status</div>
                        <div class="col-7 mb-2">
                            : <span class="bg-success text-white px-2 py-1 rounded">Success</span>
                        </div>
                    </div>

                @else
                    <p class="text-center">Loading.....</p>
                @endif
            </div>

            {{-- Footer --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>
