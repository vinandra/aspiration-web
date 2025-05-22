<?php
namespace App\Http\Controllers;
use App\Models\AspirasiTampung;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class AspirasiTampungController extends Controller
{
    public function index()
    {
        return view('aspirasi.form');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:16',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'kategori' => 'required|string',
            'photo_proof' => 'nullable|image|max:2048',
        ]);
        // Cek apakah NIK sudah terdaftar sebagai user
        $user = User::where('nik', $validated['nik'])->first();
        
        if ($user) {
            // Jika NIK sudah terdaftar, minta login
            return redirect()->back()->with('warning', 'NIK Anda sudah terdaftar dalam sistem. Silahkan login untuk mengirim aspirasi.');
        }
        // Simpan file jika ada
        if ($request->hasFile('photo_proof')) {
            $path = $request->file('photo_proof')->store('aspirasi_proofs', 'public');
            $validated['photo_proof'] = $path;
        }
        // Simpan aspirasi
        AspirasiTampung::create($validated);
        // Tampilkan pesan sukses
        return redirect()->back()->with('success', 'Aspirasi Anda berhasil dikirim! Untuk memantau status aspirasi, silahkan daftar atau login dengan NIK yang sama.');
    }
}