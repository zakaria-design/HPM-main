<div>
    <div id="content-wrapper">
            <!-- Content Header (Page header) -->
        <section class="content-header pt-0 mt-0 pt-md-5 mt-md-5">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">

                    <!-- Title -->
                    <div class="col-sm-6">
                        <h3 class="text-primary">
                            <i class="fas fa-reply-all ps-2"></i> @yield('title')
                        </h3>
                    </div>

                    <!-- Breadcrumb -->
                    <div class="col-sm-6 d-flex justify-content-sm-end ps-4">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="#">
                                        <i class="fas fa-user"></i> User
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="fas fa-reply-all"></i> @yield('title')
                                </li>
                            </ol>
                        </nav>
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
                <div class="col-12 ps-2">
                        <p class="text-l text-bold text-primary"><i class="fas fa-history mr-1 ps-3"></i> Surat SPH dan INV in Progress</p>
                </div>
                </div>
                        <div class="card-body">
            <div class="mb-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 px-3">

            {{-- KIRI: Filter + dropdown --}}
            <div class="d-flex flex-column flex-md-row align-items-md-center gap-3 w-100">

                <span class="fw-bold">Filter:</span>

                {{-- Dropdown Jenis Surat --}}
                <form method="GET" action="" class="w-100 w-md-auto">
                    <select name="jenis" class="form-select" onchange="this.form.submit()">
                        <option value="semua" {{ $jenis_surat == 'semua' ? 'selected' : '' }}>Semua Jenis</option>
                        <option value="SPH" {{ $jenis_surat == 'SPH' ? 'selected' : '' }}>Surat Penawaran Harga</option>
                        <option value="INV" {{ $jenis_surat == 'INV' ? 'selected' : '' }}>Surat Invoice</option>
                    </select>
                </form>

            </div>

            {{-- KANAN: Pencarian --}}
            <div class="w-100 w-md-25">
                <form action="" method="GET" class="input-group">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="cari nama customer..." 
                        class="form-control"
                        autocomplete="off">

                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
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
                                <th><i class="fas fa-mail-bulk mr-1 text-primary"></i> Jenis</th>
                                <th><i class="fas fa-user-tie mr-1 text-primary"></i> Marketing</th>
                                <th><i class="far fa-calendar-alt mr-1 text-primary"></i> Tanggal</th>
                                <th><i class="fas fa-wrench mr-1 text-primary"></i> Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($surat as $index => $row)
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
                                    <td class="small fw-bold">
                                        @foreach(explode(',', $row->jenis_surat) as $jenis)
                                            @php 
                                                $jenis = trim($jenis); 
                                                $color = match($jenis) {
                                                    'SPH' => 'text-success',   // hijau
                                                    'SKT' => 'text-danger',    // merah
                                                    'INV' => 'text-warning',   // kuning
                                                    default => 'text-secondary'
                                                };
                                            @endphp
                                            
                                            <span class="{{ $color }}">{{ $jenis }}</span>
                                            @if(!$loop->last), @endif
                                        @endforeach
                                    </td>
                                    <td class="small">
                                        @if($row->marketing)
                                             {{ $row->marketing }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="small">{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-start align-items-center gap-2">

                                            <!-- Tombol Gagal -->
                                            <a href="{{ route('manager.surat.status', ['table' => $row->sumber_tabel, 'id' => $row->id, 'status' => 'gagal']) }}"
                                            onclick="return confirm('Tandai sebagai gagal?');"
                                            class="btn btn-outline-danger rounded-circle d-flex justify-content-center align-items-center"
                                            style="width:32px;height:32px;padding:0;"
                                            title="Tandai Gagal">
                                                <i class="fas fa-times"></i>
                                            </a>

                                            <span>|</span>

                                            <!-- Tombol Berhasil -->
                                            <a href="{{ route('manager.surat.status', ['table' => $row->sumber_tabel, 'id' => $row->id, 'status' => 'berhasil']) }}"
                                            onclick="return confirm('Tandai sebagai berhasil?');"
                                            class="btn btn-outline-success rounded-circle d-flex justify-content-center align-items-center"
                                            style="width:32px;height:32px;padding:0;"
                                            title="Tandai Berhasil">
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
                        {{ $surat->links('pagination::bootstrap-5') }}
                    </div>

                </div>    
            </div>
        </div>  
    </section>

{{-- card update surat --}}
    {{-- <section class="content">
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
     --}}
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
