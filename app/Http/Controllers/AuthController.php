<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function login()
    {
        if (Auth::check()) {
            return back();
        }
        return view('pages.auth.login');
    }

    // Proses autentikasi login
    public function authenticate(Request $request)
    {
        if (Auth::check()) {
            return back();
        }

        // Validasi inputan
        $credentials = $request->validate([
            'nik' => ['required', 'numeric', 'digits:16'],  // Validasi NIK harus angka dan 16 digit
            'password' => ['required'],
        ], [
            'nik.required' => 'NIK tidak boleh kosong',
            'nik.numeric' => 'NIK harus berupa angka',
            'nik.digits' => 'NIK harus terdiri dari 16 digit',
            'password.required' => 'Password tidak boleh kosong',
        ]);

        // Cek autentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $userStatus = Auth::user()->status;
            
            if ($userStatus == "submitted") {
                $this->_logout($request);
                return back()->withErrors([
                    'nik' => 'Akun anda masih menunggu persetujuan admin',
                ]);
            } else if ($userStatus == "rejected") {
                $this->_logout($request);
                return back()->withErrors([
                    'nik' => 'Akun anda ditolak.',
                ]);
            }

            return redirect()->intended('dashboard');
        }
        
        return back()->withErrors([
            'nik' => 'Terjadi kesalahan, periksa kembali NIK atau password Anda.',
        ])->onlyInput('nik');
    }

    // Menampilkan halaman registrasi
    public function registerView()
    {
        if (Auth::check()) {
            return back();
        }
        
        return view('pages.auth.register');
    }

    // Proses pendaftaran
    public function register(Request $request)
    {
        if (Auth::check()) {
            return back();
        }
        $validated = $request->validate([
            'name' => ['required'],
            'nik' => ['required', 'numeric', 'digits:16'],  // Validasi NIK harus angka dan 16 digit
            'password' => ['required'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ], [
            'name.required' => 'Nama lengkap harus diisi',
            'nik.required' => 'NIK harus diisi',
            'nik.numeric' => 'NIK harus berupa angka',
            'nik.digits' => 'NIK harus terdiri dari 16 digit',
            'password.required' => 'Password harus diisi',
            'photo.image' => 'Foto harus berupa gambar',
            'photo.mimes' => 'Foto harus berekstensi jpeg, png, jpg, gif, atau svg',
            'photo.max' => 'Ukuran foto maksimal 2MB',
        ]);

        // Simpan data pengguna baru
        $user = new User();
        $user->name = $request->input('name');
        $user->nik = $request->input('nik');
        $user->password = Hash::make($request->input('password'));
        $user->role_id = 2; // Misal, untuk role user

        // Menyimpan foto profil jika ada
        if ($request->hasFile('photo')) {
            // Simpan foto di folder 'public/profile_photos'
            $photoPath = $request->file('photo')->store('profile_photos', 'public'); 
            $user->profile_photo = $photoPath; // Simpan path foto di database
        }

        $user->save();

        return redirect('/')->with('success', 'Berhasil mendaftar, silakan tunggu konfirmasi admin');
    }

    // Fungsi untuk logout
    public function _logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    // Logout dan redirect ke halaman utama
    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/');
        }
        
        $this->_logout($request);
        return redirect('/');
    }
}