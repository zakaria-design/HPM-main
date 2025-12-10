<div>
    <div id="content-wrapper" class="mb-5">

        <section class="content-header pt-0 mt-0 pt-md-5 mt-md-5">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">

                    <!-- Judul -->
                    <div class="col-sm-6">
                        <h4 class="text-primary">
                            <i class="fas fa-check-circle"></i> @yield('title')
                        </h4>
                    </div>

                    <!-- Breadcrumb -->
                    <div class="col-sm-6 d-flex justify-content-sm-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="#">
                                        <i class="fas fa-user-tie"></i> Pimpinan
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="fas fa-check-circle"></i> @yield('title')
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
                        <p class="text-l text-bold text-primary"><i class="fas fa-calendar-check ps-2"></i> Surat SPH dan INV success</p>
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
                                <th><i class="far fa-calendar-alt mr-1 text-primary"></i> Tanggal</th>
                                <th><i class="fas fa-wrench mr-1 text-primary"></i> Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($surat as $index => $row)
                                <tr>
                                    <td class="ps-4 small">{{ ($surat->currentPage() - 1) * $surat->perPage() + ($index + 1) }}</td>
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
                                        @foreach(explode(',', $row->jenis) as $jenis)
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
                                    <td class="small">{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-start align-items-center gap-2">
                                            <button class="btn btn-sm btn-outline-info"
                                                onclick='showDetail(@json($row))' title="Detail Surat">
                                                <i class="fas fa-info-circle"></i>
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
                        {{ $surat->links('pagination::bootstrap-5') }}
                    </div>

                </div>    
            </div>
        </div>  
    </section>

     </div>
</div>

{{-- modal detail --}}
@include('content.pimpinan.sphsuccess.modal')

{{-- detail modal --}}
<script>
    function showDetail(data) {

        document.getElementById('d_jenis').innerHTML = data.jenis;
        document.getElementById('d_customer').innerHTML = data.nama_customer;
        document.getElementById('d_nomor').innerHTML = data.nomor_surat;
        // Format nominal: 1000000 => 1.000.000
        let nominalFormatted = data.nominal 
            ? new Intl.NumberFormat('id-ID').format(data.nominal)
            : '-';

        document.getElementById('d_nominal').innerHTML = nominalFormatted;

        let tgl = new Date(data.created_at).toLocaleDateString('id-ID');
        document.getElementById('d_created').innerHTML = tgl;

        // nama marketing
        document.getElementById('d_marketing').innerHTML =
        (data.marketing ?? '').trim() !== '' ? data.marketing : '-';

        // Tambahkan nama user
        document.getElementById('d_user').innerHTML = data.user_name ?? '-';

        let tglUpdate = data.updated_at 
            ? new Date(data.updated_at).toLocaleDateString('id-ID')
            : '-';

        document.getElementById('d_updated_at').innerHTML = tglUpdate;

        new bootstrap.Modal(document.getElementById('detailModal')).show();
    }

</script>
