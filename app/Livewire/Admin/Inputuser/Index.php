<?php

namespace App\Livewire\Admin\Inputuser;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination; // <-- fix disini
use Illuminate\Support\Facades\Hash;

class Index extends Component
{
    use WithPagination; 

    public $selectedUser = null;

    protected $paginationTheme = 'bootstrap';

    public $name, $email, $alamat, $no_hp, $role, $password, $password_confirmation;

    protected $rules = [
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email',
        'alamat' => 'required|string|max:255',
        'no_hp' => 'required|string|max:20',
        'role' => 'required|in:karyawan,manager',
        'password' => 'required|min:6|same:password_confirmation',
    ];

    // Pesan kesalahan dalam bahasa Indonesia
    protected $messages = [
        'name.required' => 'Nama tidak boleh kosong',
        'name.string' => 'Nama harus berupa teks',
        'name.max' => 'Nama maksimal 100 karakter',

        'email.required' => 'Email tidak boleh kosong',
        'email.email' => 'Email harus valid',
        'email.unique' => 'Email sudah digunakan',

        'alamat.required' => 'Alamat tidak boleh kosong',
        'alamat.string' => 'Alamat harus berupa teks',
        'alamat.max' => 'Alamat maksimal 255 karakter',

        'no_hp.required' => 'No HP tidak boleh kosong',
        'no_hp.string' => 'No HP harus berupa teks',
        'no_hp.max' => 'No HP maksimal 20 karakter',

        'role.required' => 'Role harus dipilih',
        'role.in' => 'Role tidak valid',

        'password.required' => 'Password tidak boleh kosong',
        'password.min' => 'Password minimal 6 karakter',
        'password.same' => 'Konfirmasi password tidak sama',
    ];

    public function setSelectedUser($userId)
    {
        $this->selectedUser = User::find($userId);
    }

    public function generateUserId()
    {
        do {
            $random = rand(1000, 9999);
            $userId = "HPM-" . $random;
        } while (User::where('user_id', $userId)->exists());

        return $userId;
    }

    public function save()
    {
        // Cukup validasi, tanpa try-catch untuk SweetAlert error
        $this->validate();

        $userId = $this->generateUserId();

        User::create([
            'user_id' => $userId,
            'name' => $this->name,
            'email' => $this->email,
            'alamat' => $this->alamat,
            'no_hp' => $this->no_hp,
            'role' => $this->role,
            'password' => Hash::make($this->password),
        ]);

        $this->reset(); // reset input form
        $this->dispatch('closeModal'); // tutup modal

        // Event SweetAlert sukses tetap ada
        $this->dispatch('showSuccess', message: 'User berhasil ditambahkan');

        $this->gotoPage(1); // pindah ke halaman pertama
    }


    // ===============================
    // Hapus user
    // ===============================
    public function deleteUser($userId)
    {
        $user = User::find($userId);

        if ($user) {
            $user->delete();

            // Reset selectedUser jika perlu
            if ($this->selectedUser && $this->selectedUser->id == $userId) {
                $this->selectedUser = null;
            }

            // Event SweetAlert sukses
            $this->dispatch('showSuccess', message: 'User berhasil dihapus');

            // Kembali ke halaman pertama
            $this->gotoPage(1);
        } else {
            $this->dispatch('showError', message: 'User tidak ditemukan');
        }
    }


    public function render()
    {
        return view('livewire.admin.inputuser.index', [
            'users' => User::orderBy('created_at', 'desc')->paginate(5),
        ]);
    }
}
