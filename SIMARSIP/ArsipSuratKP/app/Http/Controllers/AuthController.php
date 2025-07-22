<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan Halaman Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Cek Login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            return redirect()->route('dashboard');
        }

        return redirect()->back()->with('error', 'Email atau password salah.');
    }

    // create akun
    public function createAkun()
    {
        $users = User::all(); // Ambil semua user
        return view('kelolaPengguna', compact('users'));
    }

    // form tambah akun
    public function formTambahAkun()
    {
        return view('tambahPengguna');
    }

    public function storeAkun(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('kelolaPengguna')->with('success', 'Admin baru berhasil ditambahkan.');
    }

    // Menampilkan halaman edit
    public function editAkun($id)
    {
        if (Auth::id() != $id) {
            return redirect()->route('kelolaPengguna')->with('error', 'Anda hanya bisa mengedit akun Anda sendiri.');
        }

        $user = User::findOrFail($id);
        return view('editPengguna', compact('user'));
    }

    // Update akun & menyimpan ke database
    public function updateAkun(Request $request, $id)
    {
        if (Auth::id() != $id) {
            return redirect()->route('kelolaPengguna')->with('error', 'Anda hanya bisa mengedit akun Anda sendiri.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('kelolaPengguna')->with('success', 'Data admin berhasil diperbarui.');
    }   

    // Logout
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}
