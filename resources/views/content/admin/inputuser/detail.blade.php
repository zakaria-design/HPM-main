<div wire:ignore.self class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            {{-- Header --}}
            <div class="modal-header bg-info text-white text-center">
                <h5 class="modal-title ">Detail User</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            {{-- Body --}}
            <div class="modal-body px-4" style="max-height: 60vh; overflow-y: auto;">
                @if($selectedUser)
                    <div class="row">
                        {{-- Kolom Foto: desktop kanan, mobile atas --}}
                        <div class="col-md-4 text-center order-md-2 order-1 mb-3 mb-md-0">
                            @if($selectedUser->foto)
                                <img src="{{ asset('foto_profil/' . $selectedUser->foto) }}" 
                                     alt="Foto {{ $selectedUser->name }}" 
                                     class="img-fluid rounded" style="max-height:200px;">
                            @else
                                <img src="{{ asset('avatar.jpg') }}" 
                                     alt="Foto default" 
                                     class="img-fluid rounded" style="max-height:200px;">
                            @endif
                        </div>

                        {{-- Kolom kiri: Label + Isi --}}
                        <div class="col-md-8 order-md-1 order-2">
                            <div class="row mb-2">
                                <div class="col-4 font-weight-bold">User ID</div>
                                <div class="col-8">: {{ $selectedUser->user_id }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 font-weight-bold">Nama</div>
                                <div class="col-8">: {{ $selectedUser->name }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 font-weight-bold">Email</div>
                                <div class="col-8">: {{ $selectedUser->email }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 font-weight-bold">Alamat</div>
                                <div class="col-8">: {{ $selectedUser->alamat }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 font-weight-bold">No HP</div>
                                <div class="col-8">: {{ $selectedUser->no_hp }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 font-weight-bold">Role</div>
                                <div class="col-8">: {{ ucfirst($selectedUser->role) }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 font-weight-bold">Dibuat</div>
                                <div class="col-8">: {{ $selectedUser->created_at->format('d-m-Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-center">Loading.....</p>
                @endif
            </div>

            {{-- Footer --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
