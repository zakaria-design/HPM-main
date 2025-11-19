<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Remix Icon CSS -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-6 mt-10">
    {{-- Judul --}}
    <h2 class="text-2xl font-bold mb-6 text-center">👤 Edit Profil</h2>

    {{-- Tombol Kembali --}}
    <div class="mb-6">
        @php
            $role = Auth::user()->role ?? 'manager'; // default karyawan jika role kosong
            switch($role) {
                case 'admin':
                    $dashboardRoute = route('admin.dashboard.index');
                    break;
                case 'direktur':
                    $dashboardRoute = route('pimpinan.dashboard.index');
                    break;
                default:
                    $dashboardRoute = route('manager.dashboard.index');
            }
        @endphp

        <a href="{{ $dashboardRoute }}" 
        class="inline-flex items-center gap-2 text-gray-700 hover:text-gray-900 font-semibold px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition">
        <i class="ri-arrow-left-line text-lg"></i>
        <span>Kembali</span>
        </a>
    </div>


    {{-- FORM UBAH PROFIL --}}
    <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5 mb-10">
        @csrf
        @method('PUT')

        <!-- Foto Profil -->
        <div class="flex flex-col items-center gap-2">
            <label class="block text-sm font-medium text-gray-700">Foto Profil</label>
            @if($user->foto)
                <img src="{{ asset('foto_profil/' . $user->foto) }}" 
                     alt="Foto Profil" 
                     class="w-28 h-28 rounded-full object-cover border-2 border-gray-200 shadow-sm">
            @else
                <div class="w-28 h-28 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 border-2 border-gray-200">
                    <i class="ri-user-line text-2xl"></i>
                </div>
            @endif
            <input type="file" name="foto" class="block w-full mt-2 border rounded p-2 text-sm">
            @error('foto') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Nama -->
       <!-- Nama (readonly) -->
        <div class="relative">
            <i class="ri-user-fill absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                class="w-full border rounded-lg p-2 pl-10 bg-gray-100 cursor-not-allowed" 
                placeholder="Nama Lengkap" readonly>
        </div>


        <!-- No HP -->
        <div class="relative">
            <i class="ri-phone-fill absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" 
                   class="w-full border rounded-lg p-2 pl-10" placeholder="Nomor HP">
            @error('no_hp') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Alamat -->
        <div class="relative">
            <i class="ri-map-pin-fill absolute left-3 top-3 text-gray-400"></i>
            <textarea name="alamat" rows="3" class="w-full border rounded-lg p-2 pl-10" placeholder="Alamat">{{ old('alamat', $user->alamat) }}</textarea>
            @error('alamat') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- User ID (readonly) -->
        <div class="relative">
            <i class="ri-id-card-fill absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" value="{{ $user->user_id }}" class="w-full border rounded-lg p-2 pl-10 bg-gray-100" readonly>
        </div>

        <!-- Tombol Simpan -->
        <div class="flex justify-end">
            <button type="submit" 
                    class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                <i class="ri-save-3-fill text-lg"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </form>

    {{-- FORM UBAH PASSWORD --}}
    <h2 class="text-xl font-bold mb-4 border-t pt-4 flex items-center gap-2"><i class="ri-lock-fill"></i> Ubah Password</h2>

    <form action="{{ route('profil.updatePassword') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="relative">
            <i class="ri-key-fill absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="password" name="current_password" class="w-full border rounded-lg p-2 pl-10" placeholder="Password Lama" required>
            @error('current_password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="relative">
            <i class="ri-lock-password-fill absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="password" name="new_password" class="w-full border rounded-lg p-2 pl-10" placeholder="Password Baru" required>
            @error('new_password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="relative">
            <i class="ri-lock-2-fill absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="password" name="new_password_confirmation" class="w-full border rounded-lg p-2 pl-10" placeholder="Konfirmasi Password Baru" required>
        </div>

        <div class="flex justify-end">
            <button type="submit" 
                    class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition">
                <i class="ri-refresh-line text-lg"></i>
                <span>Ubah Password</span>
            </button>
        </div>
    </form>
</div>


{{-- SweetAlert ubah pr0file Success Notification --}}
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        position: 'center',
        showConfirmButton: true,
        confirmButtonText: 'Tutup',
        allowOutsideClick: true,
        allowEscapeKey: true,
    });
</script>
@endif

{{-- SweetAlert ubah password Notification --}}
@if (session('password_success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('password_success') }}",
        position: 'center',
        showConfirmButton: true,
        confirmButtonText: 'Tutup',
        allowOutsideClick: true,
        allowEscapeKey: true,
    });
</script>
@endif

@if (session('password_error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: "{{ session('password_error') }}",
        position: 'center',
        showConfirmButton: true,
        confirmButtonText: 'Tutup',
        allowOutsideClick: true,
        allowEscapeKey: true,
    });
</script>
@endif


</body>
</html>
