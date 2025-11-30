<div>
    <div id="content-wrapper" class="mb-5">

        <section class="content-header pt-0 mt-0 pt-md-5 mt-md-5">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 ps-3">
                        <h4 class="text-primary">
                            <i class="fas fa-user-plus me-1"></i>
                            @yield('title')
                        </h4>
                    </div>

                    <div class="col-sm-6 ps-3">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item">
                                <a href="#">
                                    <i class="fas fa-user-lock"></i> Admin
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="fas fa-user-plus me-1"></i>
                                @yield('title')
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>



        <div>
            <div class="ps-3">
                <button class="btn btn-primary ml-3 mb-3 small btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                    <i class="bi bi-person-plus"></i> Tambah User
                </button>
            </div>

                
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-nowrap data-table">
                                <thead>
                                    <tr>
                                        <th class="ps-5">No</th>
                                        <th><i class="fas fa-sort-alpha-up mr-1 text-primary"></i> Nama User</th>
                                        <th><i class="fas fa-user mr-1 text-primary"></i> User ID</th>
                                        <th><i class="fas fa-mail-bulk mr-1 text-primary"></i> Email</th>
                                        <th><i class="fas fa-phone mr-1 text-primary"></i> No hp</th>
                                        <th><i class="fas fa-tools mr-1 text-primary"></i> Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $index => $user)
                                        <tr>
                                            <td class="ps-5 small">{{ $index + 1 }}</td>
                                            <td class="small">{{ $user->name }}</td>
                                            <td class="small">{{ $user->user_id }}</td>
                                            <td class="small">{{ $user->email }}</td>
                                            <td class="small"><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->no_hp) }}" target="_blank">
                                                    <i class="fab fa-whatsapp text-success mr-1"></i>{{ $user->no_hp }}
                                                </a>
                                            </td>
                                            <td>
                                                <button 
                                                    class="btn btn-sm btn-outline-info"
                                                    onclick="showDetail({{ $user }})"
                                                    title="Lihat Detail">
                                                    <i class="fas fa-info-circle"></i> 
                                                </button>
                                                |
                                                <form action="{{ route('admin.user.delete', $user->id) }}" class="d-inline" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger" title="Hapus User">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada user</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                    </div> 
                </div> 
            </div>
        </section>


    </div>
</div>

@include('content.admin.inputuser.user')
@include('content.admin.inputuser.detail')
{{-- JS DETAIL MODAL --}}
<script>
    function showDetail(user) {

        document.getElementById('d_nama').innerHTML = user.name;
        document.getElementById('d_userid').innerHTML = user.user_id;
        document.getElementById('d_email').innerHTML = user.email;
        document.getElementById('d_role').innerHTML = user.role;
        document.getElementById('d_alamat').innerHTML = user.alamat ?? '-';
        document.getElementById('d_hp').innerHTML = user.no_hp ?? '-';

        // --- Format tanggal ---
        let tanggal = new Date(user.created_at).toLocaleDateString('id-ID', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        });
        document.getElementById('d_created').innerHTML = tanggal;

        // Foto
        document.getElementById('d_foto').src =
            user.foto ? "/foto_profil/" + user.foto : "/avatar.jpg";

        new bootstrap.Modal(document.getElementById('detailModal')).show();
    }
</script>


