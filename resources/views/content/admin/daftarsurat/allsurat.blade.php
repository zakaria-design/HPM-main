<div wire:ignore.self class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detail Surat</h5>
               <button type="button" class="close text-white" onclick="$('#detailModal').modal('hide')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body px-4" style="max-height: 60vh; overflow-y: auto;">
                @if($selectedSurat)
                
                    <div class="row mb-2">
                        <div class="col-5 font-weight-bold">Jenis Surat</div>
                        <div class="col-7">: {{ $selectedSurat->jenis_surat ?? '-' }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 font-weight-bold">Nomor Surat</div>
                        <div class="col-7">: {{ $selectedSurat->nomor_surat ?? '-' }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 font-weight-bold">Nama Customer</div>
                        <div class="col-7">: {{ $selectedSurat->nama_customer ?? '-' }}</div>
                    </div>

                   @if(isset($selectedSurat->jenis_surat) && 
                        in_array($selectedSurat->jenis_surat, ['surat penawaran harga', 'surat invoice']))
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold">Nominal</div>
                            <div class="col-7">
                                : Rp {{ isset($selectedSurat->nominal) 
                                    ? number_format($selectedSurat->nominal, 0, ',', '.') 
                                    : '-' }}
                            </div>
                        </div>
                    @endif

                    <div class="row mb-2">
                        <div class="col-5 font-weight-bold">User</div>
                        <div class="col-7">: 
                            @php
                                $user = \App\Models\User::where('user_id', $selectedSurat->user_id)->first();
                            @endphp
                            {{ $user ? $user->name : '-' }}
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 font-weight-bold">Di Buat</div>
                        <div class="col-7">: {{ isset($selectedSurat->created_at) ? \Carbon\Carbon::parse($selectedSurat->created_at)->format('d-m-Y H:i') : '-' }}</div>
                    </div>
                    
                    @if(isset($selectedSurat->jenis_surat) && $selectedSurat->jenis_surat === 'surat penawaran harga')
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold">Di Update</div>
                            <div class="col-7">
                                : {{ isset($selectedSurat->update) 
                                    ? \Carbon\Carbon::parse($selectedSurat->update)->format('d-m-Y H:i') 
                                    : '-' }}
                            </div>
                        </div>
                    @endif

                    @if(isset($selectedSurat->jenis_surat) && $selectedSurat->jenis_surat === 'surat penawaran harga')
                        <div class="row mb-2">
                            <div class="col-5 font-weight-bold">Status</div>
                            <div class="col-7 text-success font-weight-bold">: Sukses</div>
                        </div>
                    @endif
                @else
                    <p class="text-center">Memuat data...</p>
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="$('#detailModal').modal('hide')">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Event dari Livewire
    document.addEventListener('livewire:init', () => {
        Livewire.on('show-detail-modal', () => {
            $('#detailModal').modal('show');
        });

        Livewire.on('hide-detail-modal', () => {
            $('#detailModal').modal('hide');
        });
    });
</script>
