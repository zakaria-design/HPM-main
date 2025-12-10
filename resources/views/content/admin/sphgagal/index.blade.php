<div>
     <div id="content-wrapper" class="mb-5">

        <section class="content-header pt-0 mt-0 pt-md-5 mt-md-5">
            <div class="container-fluid">
                <div class="row mb-2 align-items-center">
                    
                    <!-- Title -->
                    <div class="col-sm-6">
                        <h4 class="text-primary">
                            <i class="fas fa-times-circle"></i> @yield('title')
                        </h4>
                    </div>

                    <!-- Breadcrumb -->
                    <div class="col-sm-6 d-flex justify-content-sm-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="#">
                                        <i class="fas fa-user-lock"></i> Admin
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <i class="fas fa-times-circle"></i> @yield('title')
                                </li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
            <p class="text-primary ps-3"><i class="far fa-calendar-times"></i> Surat SPH Dan INV Gagal</p>
        </section>
        
        <div class="mb-3 px-3">
            <form method="GET" action="" class="d-flex align-items-center gap-2">
                
                <select name="bulan" class="form-select w-auto" onchange="this.form.submit()">
                    <option value="">Semua Bulan</option>
                    @for ($b = 1; $b <= 12; $b++)
                        <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                        </option>
                    @endfor
                </select>

               
                <select name="tahun" class="form-select w-auto" onchange="this.form.submit()">
                    <option value="">Semua Tahun</option>
                    @for ($t = 2020; $t <= now()->year; $t++)
                        <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>
                            {{ $t }}
                        </option>
                    @endfor
                </select>

             
                <a href="{{ route('admin.suratgagal.export', request()->query()) }}" 
                class="btn btn-outline-success"
                title="Export To Excel">
                <i class="fas fa-file-excel"></i>
                </a>

            </form>
        </div>

        <section class="content-header">
            
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
            <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap data-table">
                    <thead>
                        <tr>
                            <th class="ps-5">No</th>
                            <th><i class="fas fa-sort-numeric-down mr-1 text-primary"></i> Nomor Surat</th>
                            <th><i class="fas fa-user mr-1 text-primary"></i> Nama Customer</th>
                            <th><i class="fas fa-mail-bulk mr-1 text-primary"></i> Jenis</th>
                            <th><i class="fas fa-user-tie mr-1 text-primary"></i> Marketing</th>
                            <th><i class="fas fa-dollar-sign mr-1 text-primary"></i> Nominal</th>
                            <th><i class="fas fa-wrench mr-1 text-primary"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $item)
                            <tr>
                                <td class="ps-5 small"> {{ ($data->currentPage() - 1) * $data->perPage() + $index + 1 }}</td>
                                <td class="small">{{ $item->nomor_surat }}</td>
                                <td class="small">{{ $item->nama_customer }}</td>
                                <td class="small fw-bold">
                                    @foreach(explode(',', $item->jenis) as $jenis)
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
                                    @if($item->marketing)
                                        {{ $item->marketing }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="small">Rp. {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        
                                        <!-- Detail -->
                                        <button class="btn btn-sm btn-outline-info"
                                            onclick='showDetail(@json($item))' title="Detail Surat">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                        <span>|</span>
                                        <!-- Edit -->
                                        <button 
                                            class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEdit"
                                            data-nama="{{ $item->nama_customer }}"
                                            data-nomor="{{ $item->nomor_surat }}"
                                            data-nominal="{{ $item->nominal }}"
                                            data-jenis="{{ $item->jenis }}"
                                            data-status="{{ $item->status ?? '' }}"
                                            title="Edit Surat">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <span>|</span>
                                        <!-- Delete -->
                                        <form action="{{ route('admin.suratgagal.destroy', $item->id) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Yakin ingin hapus data ini?')"
                                            style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="jenis" value="{{ $item->jenis }}">
                                            <button class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

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
                    {{ $data->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </section>

    </div>
</div>
{{-- detail modal --}}
@include('content.admin.sphgagal.modal')
@include('content.admin.sphgagal.edit-modal')
{{-- edit modal --}}
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

        // Tambahkan nama user
        document.getElementById('d_user').innerHTML = data.user_name ?? '-';

        let tglUpdate = data.updated_at 
            ? new Date(data.updated_at).toLocaleDateString('id-ID')
            : '-';

        document.getElementById('d_updated_at').innerHTML = tglUpdate;

        new bootstrap.Modal(document.getElementById('detailModal')).show();
    }

</script>


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

