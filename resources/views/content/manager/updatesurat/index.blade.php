<div>
    <div id="content-wrapper">
            <!-- Content Header (Page header) -->
        <section class="content-header pt-0 mt-0 pt-md-5 mt-md-5">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="text-primary"><i class="fas fa-reply-all"></i> @yield('title')</h3>
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
                            @forelse ($data as $index => $row)
                                <tr>
                                    <td class="ps-4 small">{{ $index+1 }}</td>
                                    <td class="small">{{ $row->nomor_surat }}</td>
                                    <td class="small">{{ $row->nama_customer }}</td>
                                    <td class="small"> 
                                        @if($row->nominal)
                                            Rp {{ number_format($row->nominal, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="small">{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-2 ms-n4" style="margin-left: -14px;">
                                            <a href="{{ route('manager.surat.gagal', $row->id) }}" class="btn btn-outline-danger d-flex align-items-center justify-content-center rounded-circle" style="width: 32px; height: 32px;" title="tandai gagal">
                                                <i class="fas fa-times"></i>
                                            </a>

                                            <span class="text-muted small">|</span>

                                            <a href="{{ route('manager.surat.berhasil', $row->id) }}" class="btn btn-outline-success d-flex align-items-center justify-content-center rounded-circle" style="width: 32px; height: 32px;" title="tandai berhasil">
                                                <i class="fas fa-check"></i>
                                            </a>
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
                                $limited = $berhasil->take(3);
                            @endphp

                            @forelse ($limited as $berhasil)
                                <div class="p-3 mb-3 rounded-3 shadow-sm border d-flex flex-column bg-light hover-shadow transition">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold text-success mb-0">{{ $berhasil->nomor_surat }}</h6>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($berhasil->update)->diffForHumans() }}</small>
                                    </div>
                                    <div class="mt-1">
                                        <span class="text-dark">{{ $berhasil->nama_customer }}</span><br>
                                        <span class="text-secondary fw-semibold">Rp {{ number_format($berhasil->nominal, 0, ',', '.') }}</span>

                                    <button class="btn btn-sm btn-outline-success float-end"
                                            onclick="showDetail({{ $berhasil->id }}, 'sph')">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center m-0">Belum ada data berhasil.</p>
                            @endforelse

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
                                $limitedGagal = $gagal->take(3);
                            @endphp

                            @forelse ($limitedGagal as $gagal)
                                <div class="p-3 mb-3 rounded-3 shadow-sm border d-flex flex-column bg-light hover-shadow transition">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold text-danger mb-0">{{ $gagal->nomor_surat }}</h6>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($gagal->update)->diffForHumans() }}</small>
                                    </div>
                                    <div class="mt-1">
                                        <span class="text-dark">{{ $gagal->nama_customer }}</span><br>
                                        <span class="text-secondary fw-semibold">Rp {{ number_format($gagal->nominal, 0, ',', '.') }}</span>

                                    <button class="btn btn-sm btn-outline-danger float-end"
                                            onclick="showDetail({{ $gagal->id }}, 'sph_gagal')">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>

                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center m-0">Belum ada data gagal.</p>
                            @endforelse

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
    
    {{-- modal --}}
    @include('content.manager.updatesurat.modal')
    <script>
        function showDetail(id, type) {

            fetch(`/manager/update-surat/detail/${id}/${type}`)
                .then(response => response.json())
                .then(data => {

                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    document.getElementById("detail_nomor").innerText = data.nomor_surat;
                    document.getElementById("detail_customer").innerText = data.nama_customer;
                    document.getElementById("detail_nominal").innerText = 
                        "Rp " + Number(data.nominal).toLocaleString('id-ID');
                    document.getElementById("detail_update").innerText = data.update;
                    document.getElementById("detail_created").innerText = data.created_at;

                    let detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
                    detailModal.show();
                });
        }
    </script>


    </div>
</div>
