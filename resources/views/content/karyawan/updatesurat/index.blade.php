<div>
    <div class="content-wrapper">
            <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="text-primary"><i class="fas fa-reply-all"></i> @yield('title')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#"><i class="fas fa-user"></i> User</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-reply-all"></i> @yield('title')</li>
                    </ol>
                </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div>
        <!-- Default box -->
        <div>
            {{-- card --}}
            <div>
                <div class="d-flex justify-content-between">
                {{-- dropdown jenis surat --}}
                <div class="col-12">
                        <p class="text-l text-bold text-primary"><i class="fas fa-history mr-1"></i> Surat SPH In Progress</p>
                </div>
                </div>
                {{-- table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-nowrap">
                        <thead>
                            <tr>
                                <th class="ps-4">No</th>
                                <th><i class="fas fa-sort-numeric-down mr-1 text-primary"></i> Nomor surat</th>
                                <th><i class="fas fa-user mr-1 text-primary"></i> Nama Customer</th>
                                <th><i class="fas fa-dollar-sign mr-1 text-primary"></i> Nominal</th>
                                <th><i class="far fa-calendar-alt mr-1 text-primary"></i> Tanggal</th>
                                <th><i class="fas fa-wrench mr-1 text-primary"></i> Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $index => $item)
                                <tr>
                                    <td class="ps-4">{{ $data->firstItem() + $index }}</td>
                                    <td>{{ $item->nomor_surat }}</td>
                                    <td>{{ $item->nama_customer }}</td>
                                    <td> 
                                        @if($item->nominal)
                                            Rp {{ number_format($item->nominal, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-2 ms-n4" style="margin-left: -14px;">
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
                                    <td colspan="6" class="text-center">Belum ada surat.</td>
                                </tr>
                            @endforelse 
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div class="mt-3">
                        {{-- {{ $dataSurat->links() }} --}}
                    </div>
                </div>    
            </div>
        </div>  
    </section>

{{-- card update surat --}}
    <section class="content">
        <div class="container py-4">
            <h4 class="mb-4 text-center fw-bold text-primary">Update Surat SPH</h4>

            <div class="row">
                <!-- Kolom kiri: SPH Berhasil -->
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-success text-white fw-semibold">
                            <i class="bi bi-check-circle"></i> Surat Berhasil
                        </div>
                        <div class="card-body">
                             @php
                                $limitedSph = $sphSukses->take(2);
                            @endphp

                            @forelse ($limitedSph as $item)
                                <div class="p-3 mb-3 rounded-3 shadow-sm border d-flex flex-column bg-light hover-shadow transition">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold text-success mb-0">{{ $item->nomor_surat }}</h6>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($item->update)->diffForHumans() }}</small>
                                    </div>
                                    <div class="mt-1">
                                        <span class="text-dark">{{ $item->nama_customer }}</span><br>
                                        <span class="text-secondary fw-semibold">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>

                                        <button wire:click="showDetail({{ $item->id }}, 'sph')" class="btn btn-sm btn-outline-success float-end">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center m-0">Belum ada data berhasil.</p>
                            @endforelse

                            @if($sphSukses->count() > 2)
                                <div class="text-center mt-2">
                                    <button wire:click="showAllData('sph')" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-list"></i> Lihat lainnya
                                    </button>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                <!-- Kolom kanan: SPH Gagal -->
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-danger text-white fw-semibold">
                            <i class="bi bi-x-circle"></i> Surat Gagal
                        </div>
                        <div class="card-body">
                             @php
                                $limitedGagal = $sphGagal->take(2);
                            @endphp

                            @forelse ($limitedGagal as $item)
                                <div class="p-3 mb-3 rounded-3 shadow-sm border d-flex flex-column bg-light hover-shadow transition">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold text-danger mb-0">{{ $item->nomor_surat }}</h6>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($item->update)->diffForHumans() }}</small>
                                    </div>
                                    <div class="mt-1">
                                        <span class="text-dark">{{ $item->nama_customer }}</span><br>
                                        <span class="text-secondary fw-semibold">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>

                                        <button wire:click="showDetail({{ $item->id }}, 'sph_gagal')" class="btn btn-sm btn-outline-danger float-end">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center m-0">Belum ada data gagal.</p>
                            @endforelse

                            @if($sphGagal->count() > 2)
                                <div class="text-center mt-2">
                                    <button wire:click="showAllData('sph_gagal')" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-list"></i> Lihat lainnya
                                    </button>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* Efek hover dan transisi lembut */
            .hover-shadow {
                transition: all 0.25s ease-in-out;
            }
            .hover-shadow:hover {
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                transform: translateY(-2px);
            }

            /* Responsif padding dan card */
            @media (max-width: 768px) {
                .card {
                    margin-bottom: 1.5rem;
                }
            }
        </style>
    </section>
    
{{-- modal all card --}}
    @include('livewire.karyawan.updatesurat.allmodal')
    @script
    <script>
        Livewire.on('showAllModal', () => {
            var modal = new bootstrap.Modal(document.getElementById('allModal'));
            modal.show();
        });
    </script>
    @endscript

{{-- modal detail card --}}
    @include('livewire.karyawan.updatesurat.modal')
    @script
    <script>
        // Tampilkan modal detail setelah event Livewire
        $wire.on('showDetailModal', () => {
            var detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
            detailModal.show();
        });
    </script>
    @endscript
{{-- akhir --}}


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
