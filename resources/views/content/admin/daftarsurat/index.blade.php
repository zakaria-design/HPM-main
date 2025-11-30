<div>
    <div id="content-wrapper" class="mb-5">
        <section class="content-header pt-0 mt-0 pt-md-5 mt-md-5">
            <div class="container-fluid">
                <div class="row mb-2 ps-2">
                    <div class="col-sm-6">
                        <h4 class="text-primary">
                            <i class="fas fa-mail-bulk me-1 text-primary"></i>
                            @yield('title')
                        </h4>
                    </div>

                    <div class="col-sm-6 ps-2">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item">
                                <a href="#">
                                    <i class="fas fa-user-lock"></i> Admin
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="fas fa-mail-bulk me-1 text-primary"></i>
                                @yield('title')
                            </li>
                        </ol>

                   </div>
                </div>
            </div>
        </section>

        {{-- <div class="mb-3 px-3">
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

             
                <a href="{{ route('admin.daftarsurat.export', request()->query()) }}" 
                class="btn btn-outline-success">
                <i class="fas fa-file-excel"></i>
                </a>

            </form>
        </div> --}}


    <section class="content">
        <div>
      <!-- Default box -->
      <div>
        <div>

        </div>
        {{-- card --}}
        <div class="card-body">
            <div class="mb-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 px-3">

            {{-- KIRI: Filter + dropdown --}}
            <div class="d-flex flex-column flex-md-row align-items-md-center gap-3 w-100">

                <span class="fw-bold">Filter:</span>

                {{-- Dropdown Jenis Surat --}}
                <form method="GET" action="" class="w-100 w-md-auto">
                    <select name="jenis" class="form-select" onchange="this.form.submit()">
                        <option value="semua" {{ $jenis == 'semua' ? 'selected' : '' }}>Semua Jenis</option>
                        <option value="SPH" {{ $jenis == 'SPH' ? 'selected' : '' }}>Surat Penawaran Harga</option>
                        <option value="INV" {{ $jenis == 'INV' ? 'selected' : '' }}>Surat Invoice</option>
                        <option value="SKT" {{ $jenis == 'SKT' ? 'selected' : '' }}>Surat Keterangan</option>
                    </select>
                </form>

                
                {{-- Dropdown Kategori --}}
                <form method="GET" action="" class="w-100 w-md-auto">
                    <select name="kategori" class="form-select" onchange="this.form.submit()">
                        <option value="semua" {{ ($kategori ?? 'semua') == 'semua' ? 'selected' : '' }}>Semua</option>
                        <option value="perusahaan" {{ ($kategori ?? '') == 'perusahaan' ? 'selected' : '' }}>Surat Perusahaan</option>
                        <option value="perorangan" {{ ($kategori ?? '') == 'perorangan' ? 'selected' : '' }}>Surat Perorangan</option>
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
                                <th><i class="fas fa-mail-bulk mr-1 text-primary"></i> Jenis</th>
                                <th><i class="fas fa-dollar-sign mr-1 text-primary"></i> Nominal</th>
                                <th><i class="fas fa-tools mr-1 mr-1 text-primary"></i> Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($surat as $p)
                                <tr>
                                    <td class="ps-4 small">{{ $loop->iteration + ($surat->currentPage()-1) * $surat->perPage() }}</td>
                                    <td class="small">{{ $p->nomor_surat }}</td>
                                    <td class="small">{{ $p->nama_customer }}</td>
                                    <td class="small fw-bold">
                                        @foreach(explode(',', $p->jenis) as $jenis)
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
                                        @if($p->nominal)
                                            Rp {{ number_format($p->nominal, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info"
                                            onclick='showDetail(@json($p))' title="Detail Surat">
                                            <i class="fas fa-info-circle"></i>
                                        </button>

                                        <span> | </span>

                                        <button 
                                            class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEdit"
                                            data-nama="{{ $p->nama_customer }}"
                                            data-nomor="{{ $p->nomor_surat }}"
                                            data-nominal="{{ $p->nominal }}"
                                            data-jenis="{{ $p->jenis }}"
                                            data-status="{{ $p->status ?? '' }}"
                                            title="Edit Surat">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <span> | </span>

                                        <form action="{{ route('admin.daftarsurat.delete') }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')

                                            <input type="hidden" name="nomor_surat" value="{{ $p->nomor_surat }}">
                                            <input type="hidden" name="jenis" value="{{ $p->jenis }}">

                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus Surat">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

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
@include('content.admin.daftarsurat.modal')
@include('content.admin.daftarsurat.edit-modal')
{{-- modal detail surat --}}
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


