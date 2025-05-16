<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resident;  
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
            return redirect()->intended('dashboard');
        }
        
        return back()->withErrors([
            'nik' => 'Terjadi kesalahan, periksa kembali NIK atau password Anda.',
        ])->onlyInput('nik');
    }

    // Menampilkan halaman registrasi Resident (form pertama)
    public function registerResidentView()
    {
        return view('pages.auth.registerResident');
    }

    // Fungsi untuk menyimpan data Resident
    public function registerResident(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'nik' => ['required', 'numeric', 'digits:16', 'unique:residents,nik'],  // Tambah unique validation
            'gender' => ['required', 'in:male,female'],  // Validasi gender
            'birth_date' => ['required', 'date'],  // Validasi tanggal lahir
            'birth_place' => ['required'],  // Validasi tempat lahir
            'address' => ['required'],  // Validasi alamat
            'religion' => ['nullable', 'string'],  // Validasi agama
            'marital_status' => ['required', 'in:single,married,divorced,widowed'],  // Validasi status pernikahan
            'occupation' => ['nullable'],  // Validasi pekerjaan
            'phone' => ['nullable', 'string'],  // Validasi nomor telepon
            'status' => ['required', 'in:active,moved,deceased'],  // Validasi status resident
        ], [
            'name.required' => 'Nama lengkap harus diisi',
            'nik.required' => 'NIK harus diisi',
            'nik.numeric' => 'NIK harus berupa angka',
            'nik.digits' => 'NIK harus terdiri dari 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'gender.required' => 'Jenis kelamin harus diisi',
            'birth_date.required' => 'Tanggal lahir harus diisi',
            'birth_place.required' => 'Tempat lahir harus diisi',
            'address.required' => 'Alamat harus diisi',
            'marital_status.required' => 'Status pernikahan harus diisi',
            'status.required' => 'Status harus diisi',
        ]);

        // Simpan data resident
        $resident = new Resident();
        $resident->name = $request->input('name');
        $resident->nik = $request->input('nik');
        $resident->gender = $request->input('gender');
        $resident->birth_date = $request->input('birth_date');
        $resident->birth_place = $request->input('birth_place');
        $resident->address = $request->input('address');
        $resident->religion = $request->input('religion');
        $resident->marital_status = $request->input('marital_status');
        $resident->occupation = $request->input('occupation');
        $resident->phone = $request->input('phone');
        $resident->status = $request->input('status');
        $resident->save();  // Simpan data penduduk

        // Redirect ke halaman kedua untuk membuat akun dan password
        return redirect()->route('register.account', ['resident_id' => $resident->id]);
    }

    // Menampilkan halaman registrasi Akun dan Password (form kedua)
    public function registerAccountView($resident_id)
    {
        $resident = Resident::find($resident_id); // Ambil data resident berdasarkan ID
        return view('pages.auth.registerAccount', compact('resident'));
    }

    // Fungsi untuk menyimpan Akun dan Password
    public function registerAccount(Request $request, $resident_id)
    {
        $resident = Resident::find($resident_id);

        // Cek apakah resident sudah memiliki user
        if ($resident->user_id) {
            return redirect()->route('login')->with('error', 'Akun untuk NIK ini sudah ada!');
        }

        $validated = $request->validate([
            'password' => ['required', 'min:6'], // Validasi password
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], // Validasi foto profil
        ], [
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password harus minimal 6 karakter',
            'photo.image' => 'Foto harus berupa gambar',
            'photo.mimes' => 'Foto harus berekstensi jpeg, png, jpg, gif, atau svg',
            'photo.max' => 'Ukuran foto maksimal 2MB',
        ]);

        // Simpan data user
        $user = new User();
        $user->name = $resident->name;  // Ambil nama dari resident
        $user->nik = $resident->nik;    // Ambil NIK dari resident
        $user->password = Hash::make($request->input('password'));
        $user->role_id = 9;  // Misal, untuk role user

        // Menyimpan foto profil jika ada
        if ($request->hasFile('photo')) {
            // Simpan foto di folder 'public/profile_photos'
            $photoPath = $request->file('photo')->store('profile_photos', 'public');
            $user->profile_photo = $photoPath; // Simpan path foto di database
        }

        $user->save();  // Simpan data user

        // KAITKAN USER DENGAN RESIDENT
        // Update resident dengan user_id yang baru dibuat
        $resident->user_id = $user->id;
        $resident->save();

        // Sekarang juga simpan resident_id di user untuk kompatibilitas mundur
        $user->resident_id = $resident->id;
        $user->save();

        // Login otomatis setelah pendaftaran
        Auth::login($user);

        // Redirect ke halaman dashboard setelah login
        return redirect('/dashboard')->with('success', 'Berhasil mendaftar dan login, Anda dapat membuat aspirasi!');
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