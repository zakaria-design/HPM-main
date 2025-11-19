<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // ⬅️ pastikan ini ada

class ProfileController extends Controller
{
    // Menampilkan halaman edit profil
    public function edit()
    {
        $user = Auth::user(); // Ambil data user yang sedang login
        return view('profile.index', compact('user'));
    }

    // Proses update data profil
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update data teks
        $user->name = $request->name;
        $user->no_hp = $request->no_hp;
        $user->alamat = $request->alamat;

        // Update foto jika diunggah
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && File::exists(public_path('foto_profil/' . $user->foto))) {
                File::delete(public_path('foto_profil/' . $user->foto));
            }

            // Simpan foto baru
            $filename = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('foto_profil'), $filename);
            $user->foto = $filename;
        }

        $user->save();

        return redirect()->route('profil.edit')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ]);

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->with('password_error', 'Password lama salah.');
    }

    $user->password = bcrypt($request->new_password);
    $user->save();

    return back()->with('password_success', 'Password berhasil diubah.');
}

}