<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Mahasiswa;

class AuthController extends Controller
{
    // 🔹 Halaman Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 🔹 Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        // cek user login untuk seterusnya/asli
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('mahasiswa.dashboard');
            }
        }

        // cara sementara untuk auth
        // if (Auth::user()->role === 'admin') {
        //     return redirect('/admin-test'); // sementara
        // } else {
        //     return redirect('/mahasiswa-test'); // sementara
        // }

        // return back()->withErrors([
        //     'email' => 'Email atau password salah.',
        // ]);
    }

    // 🔹 Halaman Register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // 🔹 Proses Register Mahasiswa
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa'
        ]);

        // ini buat percobaan nanti dihapus
        // Buat data mahasiswa kosong dulu
        // Mahasiswa::create([
        //     'user_id' => $user->id,
        //     'nama_lengkap' => 'Belum diisi', // biar tidak error NOT NULL
        //     'email' => $user->email
        // ]);

        // Setelah register, arahkan ke login
        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    // 🔹 Ganti Password (Anti Error)
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed'
        ]);

        $user = User::find(Auth::id());

        if (!$user) {
            return back()->withErrors(['user' => 'User tidak ditemukan.']);
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama salah.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah.');
    }

    // 🔹 Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
