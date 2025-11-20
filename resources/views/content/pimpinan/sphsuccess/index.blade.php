<div>
    <div id="content-wrapper" class="mb-5">

        <section class="content-header pt-0 mt-0 pt-md-5 mt-md-5">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="text-primary"><i class="fas fa-check-circle"></i> @yield('title')</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                     <li class="breadcrumb-item"><a href="#"><i class="fas fa-user-tie"></i> Pimpinan</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-check-circle"></i> @yield('title')</li>
                    </ol>
                </div>
                </div>
            </div>
        </section>


         <section class="content-header">
                <div class=" mb-3 ml-3 col-10 col-md-4">
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
                <div class="table-responsive">
                <table class="table table-hover align-middle text-nowrap data-table">
                    <thead>
                        <tr>
                            <th class="ps-5">No</th>
                            <th><i class="fas fa-sort-numeric-down mr-1 text-primary"></i> Nomor Surat</th>
                            <th><i class="fas fa-user mr-1 text-primary"></i> Nama Customer</th>
                            <th><i class="fas fa-dollar-sign mr-1 text-primary"></i> Nominal</th>
                            <th><i class="far fa-calendar-alt mr-1 text-primary"></i> Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $item)
                            <tr>
                                <td class="ps-5 small"> {{ ($data->currentPage() - 1) * $data->perPage() + $index + 1 }}</td>
                                <td class="small">{{ $item->nomor_surat }}</td>
                                <td class="small">{{ $item->nama_customer }}</td>
                                <td class="small">Rp. {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info" 
                                            data-id="{{ $item->id }}" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#detailModal">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
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
@include('content.pimpinan.sphsuccess.modal')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var detailModal = document.getElementById('detailModal')
        detailModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var id = button.getAttribute('data-id')

            fetch(`/pimpinan/sphsuccess/detail/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalNomorSurat').textContent = data.nomor_surat;
                    document.getElementById('modalNamaCustomer').textContent = data.nama_customer;
                    document.getElementById('modalNominal').textContent = "Rp. " + parseFloat(data.nominal).toLocaleString('id-ID');
                    document.getElementById('modalUserName').textContent = data.user_name ?? '-';
                    document.getElementById('modalStatus').textContent = data.status ?? 'Success';
                    document.getElementById('modalCreatedAt').textContent = data.created_at;
                    document.getElementById('modalUpdatedAt').textContent = data.updated_at;
                })
                .catch(err => console.error(err));
        });
    });
</script>