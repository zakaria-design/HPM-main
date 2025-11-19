<div>
     <div id="content-wrapper">

        <section class="content-header pt-0 mt-0 pt-md-5 mt-md-5">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="text-primary"><i class="fas fa-history"></i> @yield('title')</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-user-lock"></i> Admin</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-history"></i> @yield('title')</li>
                    </ol>
                </div>
                </div>
            </div>
        </section>

        <section class="content-header">
            <div>
                <div class="d-flex justify-content-between mb-3 pl-4">
                    <input wire:model.live="search" type="text" class="form-control w-25" placeholder="Cari Customer...">
                </div>
                <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap data-table">
                    <thead>
                        <tr>
                            <th class="ps-5">No</th>
                            <th><i class="fas fa-sort-numeric-down mr-1 text-primary"></i> Nomor Surat</th>
                            <th><i class="fas fa-user mr-1 text-primary"></i> Nama Customer</th>
                            <th><i class="fas fa-dollar-sign mr-1 text-primary"></i> Nominal</th>
                            <th><i class="fas fa-wrench mr-1 text-primary"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td class="ps-5 small">{{ ($data->currentPage() - 1) * $data->perPage() + $loop->index + 1 }}</td>
                                <td class="small">{{ $item->nomor_surat }}</td>
                                <td class="small">{{ $item->nama_customer }}</td>
                                <td class="small">Rp.{{ number_format($item->nominal, 0, ',', '.') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-2 ms-n4" style="margin-left: -14px;">
                                        <button class="btn btn-sm btn-outline-info" 
                                            wire:click="showDetail({{ $item->id }})" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#detailModal">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                            
                                            <span class="text-muted small">|</span>
                                            
                                            <button wire:click="tolak({{ $item->id }})"
                                                    class="btn btn-outline-danger d-flex align-items-center justify-content-center rounded-circle"
                                                    style="width: 32px; height: 32px;" title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </button>

                                            <span class="text-muted small">|</span>

                                            <button wire:click="setujui({{ $item->id }})"
                                                    class="btn btn-outline-success d-flex align-items-center justify-content-center rounded-circle"
                                                    style="width: 32px; height: 32px;" title="Setujui">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
                <div class="mt-2">
                    {{ $data->links() }}
                </div>
            </div>
        </section>

        @include('livewire.admin.sphprogres.modal')
        @script
        <script>
            Livewire.on('showDetailModal', () => {
                const modal = new bootstrap.Modal(document.getElementById('detailModal'));
                modal.show();
            });
        </script>
        @endscript

        {{-- notifikasi dispatch --}}
    @script
    <script>
        // Tutup modal setelah simpan
            $wire.on('closeModal', () => {
                $('#pengajuanModal').modal('hide');
            });

            // SweetAlert feedback
            $wire.on('showSuccess', data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6',
                    showConfirmButton: true, 
                    allowOutsideClick: true, 
                });
            });

            Livewire.on('showError', (data) => {
                Swal.fire({
                    icon: 'error',
                    title: 'gagall!',
                    text: data.message,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6',
                    showConfirmButton: true, 
                    allowOutsideClick: true, 
                });
            });
    </script>
    @endscript
    </div>
</div>
