<div>
    <div id="content-wrapper" class="mb-5">

        <section class="content-header pt-0 mt-0 pt-md-5 mt-md-5">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="text-primary"><i class="fas fa-history"></i> @yield('title')</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                     <li class="breadcrumb-item"><a href="#"><i class="fas fa-user-tie"></i> Pimpinan</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-history"></i> @yield('title')</li>
                    </ol>
                </div>
                </div>
            </div>
    <section class="content">
            <div>
        <!-- Default box -->
        <div>
            {{-- card --}}
            <div>
                <div class="d-flex justify-content-between">
                {{-- dropdown jenis surat --}}
                <div class="">
                    <div class=" mb-3 ml-3">
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
                                    <td>
                                        <!-- Tombol Detail -->
                                        <button 
                                            class="btn btn-sm btn-outline-info"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#detailModal"
                                            data-id="{{ $row->nomor_surat }}"
                                            data-nama="{{ $row->nama_customer }}"
                                            data-tanggal="{{ $row->created_at }}"
                                            data-user="{{ $row->user_name ?? '-' }}"
                                            data-keterangan="{{ $row->keterangan ?? 'Proses' }}">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
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

     </div>
</div>

{{-- modal detail --}}
@include('content.pimpinan.sphprogres.modal')
<script>
    const detailModal = document.getElementById('detailModal');
    detailModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget; // tombol yang diklik
        document.getElementById('modal-id').textContent = button.getAttribute('data-id');
        document.getElementById('modal-nama').textContent = button.getAttribute('data-nama');
        document.getElementById('modal-tanggal').textContent = button.getAttribute('data-tanggal');
        document.getElementById('modal-user').textContent = button.getAttribute('data-user');
        document.getElementById('modal-keterangan').textContent = button.getAttribute('data-keterangan');
    });
</script>
