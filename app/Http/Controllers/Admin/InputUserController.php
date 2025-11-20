<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class InputUserController extends Controller
{
    // ================================
    // 📌 HALAMAN INDEX (DAFTAR USER + MODAL TAMBAH)
    // ================================
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->get();

        return view('admin.inputuser.index', compact('users'));
    }

    // ================================
    // 📌 SIMPAN USER BARU
    // ================================
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'alamat'   => 'nullable',
            'no_hp'    => 'nullable',
            'role'     => 'required',
            'foto'     => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // 📌 Generate otomatis user_id → HPM-0001
        $lastUser = User::orderBy('id', 'DESC')->first();
        
        if ($lastUser) {
            $lastNumber = intval(substr($lastUser->user_id, 4));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $userId = 'HPM-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // 📌 Upload foto jika ada
        $fotoName = null;
        if ($request->hasFile('foto')) {
            $fotoName = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('foto_profil'), $fotoName);
        }

        // 📌 Simpan ke database
        User::create([
            'name'     => $request->name,
            'user_id'  => $userId,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'alamat'   => $request->alamat,
            'no_hp'    => $request->no_hp,
            'foto'     => $fotoName,
            'role'     => $request->role,
        ]);

        return back()->with('success', 'User berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // hapus foto jika ada
        if ($user->foto && file_exists(public_path('foto_profil/' . $user->foto))) {
            unlink(public_path('foto_profil/' . $user->foto));
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus!');
    }

    

}
