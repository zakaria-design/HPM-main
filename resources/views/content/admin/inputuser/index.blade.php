<div>
    <div id="content-wrapper">

        <section class="content-header pt-0 mt-0 pt-md-5 mt-md-5">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="text-primary"><i class=" fas fa-user-plus"></i> @yield('title')</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-user-lock"></i> Admin</a></li>
                    <li class="breadcrumb-item active"><i class=" fas fa-user-plus"></i> @yield('title')</li>
                    </ol>
                </div>
                </div>
            </div>
        </section>


            <div>
            <button type="button" class="btn btn-primary btn-sm ml-2 mb-4" data-toggle="modal" data-target="#userModal">
                <i class="fas fa-user-plus"></i> Tambah User
            </button>

                
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-nowrap data-table">
                                <thead>
                                    <tr>
                                        <th class="ps-5">No</th>
                                        <th><i class="fas fa-sort-alpha-up mr-1 text-primary"></i> Nama User</th>
                                        <th><i class="fas fa-user mr-1 text-primary"></i> User ID</th>
                                        <th><i class="fas fa-mail-bulk mr-1 text-primary"></i>Email</th>
                                        <th><i class="fas fa-phone mr-1 text-primary"></i> No hp</th>
                                        <th><i class="fas fa-tools mr-1 text-primary"></i> Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $index => $user)
                                        <tr>
                                           <td class="ps-5 small">{{ $users->firstItem() + $index }}</td>
                                            <td class="small">{{ $user->name }}</td>
                                            <td class="small">{{ $user->user_id }}</td>
                                            <td class="small">{{ $user->email }}</td>
                                            <td class="small"><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->no_hp) }}" target="_blank">
                                                    <i class="fab fa-whatsapp text-success mr-1"></i>{{ $user->no_hp }}
                                                </a>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-info" 
                                                        wire:click="setSelectedUser({{ $user->id }})" 
                                                        data-toggle="modal" 
                                                        data-target="#detailModal">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                                |
                                                <button class="btn btn-sm btn-outline-danger" 
                                                         wire:click="deleteUser({{ $user->id }})">
                                                   <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada user</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{-- Pagination links --}}            
                            {{ $users->links() }}
                    </div> 
                </div> 
            </div>
        </section>

        {{-- modal input user --}}
        @include('livewire.admin.inputuser.user')
         {{-- Notifikasi sukses --}}
        @script
            <script>
                // Tutup modal setelah simpan
                    $wire.on('closeModal', () => {
                        $('#userModal').modal('hide');
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

        {{-- modal detail user --}}
        @include('livewire.admin.inputuser.detail')

    </div>
</div>
