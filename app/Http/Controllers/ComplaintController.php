<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use App\Models\Role;
use App\Models\AspirasiTampung; // Tambahkan import
use App\Notifications\ComplaintStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;

class ComplaintController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $residentId = $user->resident->id ?? null;

        $middleRoles = [Role::ROLE_KASI_PEMBANGUNAN, Role::ROLE_SEKRETARIS_LURAH, Role::ROLE_LURAH];
        
        // Tambahkan filter parameter
        $filter = $request->get('filter', 'all'); // all, registered, anonymous

        if ($user->role_id == Role::ROLE_USER) {
            // User biasa hanya melihat complaint miliknya sendiri
            $complaints = Complaint::where('resident_id', $residentId)
                ->latest()
                ->paginate(10);
        } else {
            // Admin dan role lainnya
            if ($filter === 'registered') {
                // Hanya complaints dari database complaints (pengguna terdaftar)
                $complaints = Complaint::query()
                    ->when(in_array($user->role_id, $middleRoles), fn($q) => $q->where('forwarded_to', $user->role_id))
                    ->with('resident')
                    ->latest()
                    ->paginate(10);
                    
                // Tambahkan marker untuk membedakan
                foreach ($complaints as $complaint) {
                    $complaint->source_type = 'registered';
                    $complaint->complainant_name = $complaint->resident ? $complaint->resident->name : 'Unknown';
                }
            } elseif ($filter === 'anonymous') {
                // Hanya aspirasi dari database aspirasi_tampung (pengguna anonim)
                $aspirasiTampung = AspirasiTampung::latest()->paginate(10);
                
                // Transform aspirasi tampung ke format complaint
                $complaints = $aspirasiTampung->through(function ($aspirasi) {
                    $complaint = new \stdClass();
                    $complaint->id = $aspirasi->id;
                    $complaint->title = $aspirasi->title;
                    $complaint->content = $aspirasi->content;
                    $complaint->kategori = $aspirasi->kategori;
                    $complaint->status = $aspirasi->status;
                    $complaint->photo_proof = $aspirasi->photo_proof;
                    $complaint->created_at = $aspirasi->created_at;
                    $complaint->updated_at = $aspirasi->updated_at;
                    $complaint->report_date = $aspirasi->created_at;
                    $complaint->source_type = 'anonymous';
                    $complaint->complainant_name = 'Anonim';
                    
                    // Tambahkan properties yang dibutuhkan view
                    $complaint->status_label = match ($aspirasi->status) {
                        'new' => 'Baru',
                        'processing' => 'Sedang Diproses', 
                        'completed' => 'Selesai',
                        default => 'Tidak Diketahui',
                    };
                    $complaint->status_color = match ($aspirasi->status) {
                        'new' => 'info',
                        'processing' => 'warning',
                        'completed' => 'success',
                        default => 'secondary',
                    };
                    $complaint->report_date_label = \Carbon\Carbon::parse($aspirasi->created_at)->format('d M Y');
                    $complaint->forwarded_to = null;
                    $complaint->is_published = false;
                    
                    return $complaint;
                });
            } else {
                // Gabungkan kedua database (default: all)
                $complaints = Complaint::query()
                    ->when(in_array($user->role_id, $middleRoles), fn($q) => $q->where('forwarded_to', $user->role_id))
                    ->with('resident')
                    ->latest()
                    ->get();
                    
                // Tambahkan marker untuk complaints
                foreach ($complaints as $complaint) {
                    $complaint->source_type = 'registered';
                    $complaint->complainant_name = $complaint->resident ? $complaint->resident->name : 'Unknown';
                }
                
                // Ambil aspirasi tampung
                $aspirasiTampung = AspirasiTampung::latest()->get();
                
                // Transform aspirasi tampung
                $transformedAspirasi = $aspirasiTampung->map(function ($aspirasi) {
                    $complaint = new \stdClass();
                    $complaint->id = $aspirasi->id;
                    $complaint->title = $aspirasi->title;
                    $complaint->content = $aspirasi->content;
                    $complaint->kategori = $aspirasi->kategori;
                    $complaint->status = $aspirasi->status;
                    $complaint->photo_proof = $aspirasi->photo_proof;
                    $complaint->created_at = $aspirasi->created_at;
                    $complaint->updated_at = $aspirasi->updated_at;
                    $complaint->report_date = $aspirasi->created_at;
                    $complaint->source_type = 'anonymous';
                    $complaint->complainant_name = 'Anonim';
                    
                    // Tambahkan properties yang dibutuhkan view
                    $complaint->status_label = match ($aspirasi->status) {
                        'new' => 'Baru',
                        'processing' => 'Sedang Diproses',
                        'completed' => 'Selesai',
                        default => 'Tidak Diketahui',
                    };
                    $complaint->status_color = match ($aspirasi->status) {
                        'new' => 'info',
                        'processing' => 'warning',
                        'completed' => 'success',
                        default => 'secondary',
                    };
                    $complaint->report_date_label = \Carbon\Carbon::parse($aspirasi->created_at)->format('d M Y');
                    $complaint->forwarded_to = null;
                    $complaint->is_published = false;
                    
                    return $complaint;
                });
                
                // Gabungkan dan urutkan berdasarkan tanggal
                $allComplaints = $complaints->concat($transformedAspirasi)->sortByDesc('created_at');
                
                // Manual pagination
                $page = $request->get('page', 1);
                $perPage = 10;
                $total = $allComplaints->count();
                
                $complaints = new \Illuminate\Pagination\LengthAwarePaginator(
                    $allComplaints->forPage($page, $perPage)->values(),
                    $total,
                    $perPage,
                    $page,
                    [
                        'path' => $request->url(),
                        'pageName' => 'page',
                        'query' => $request->query(),
                    ]
                );
            }
        }

        return view('pages.complaint.index', compact('complaints', 'filter'));
    }

    // Tambahkan method untuk update status aspirasi tampung
    public function updateStatusAspirasiTampung(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(['new', 'processing', 'completed'])],
        ]);

        $aspirasi = AspirasiTampung::findOrFail($id);
        $aspirasi->status = $request->status;
        $aspirasi->save();

        return redirect('/complaint')->with('success', 'Berhasil mengubah status');
    }

    // Method lainnya tetap sama seperti sebelumnya...
    public function create()
    {
        return view('pages.complaint.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'content' => ['required', 'min:3', 'max:2000'],
            'kategori' => ['required', Rule::in(['Pembangunan', 'Kesejahteraan Sosial', 'Ketentraman dan Ketertiban Umum', 'Pengelolaan Teknologi Informasi'])],
            'photo_proof' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $resident = Auth::user()->resident;

        if (!$resident) {
            return redirect('/complaint')->with('error', 'Akun anda belum terhubung dengan data penduduk manapun');
        }

        $complaint = new Complaint();
        $complaint->resident_id = $resident->id;
        $complaint->title = $request->title;
        $complaint->content = $request->content;
        $complaint->kategori = $request->kategori;

        if ($request->hasFile('photo_proof')) {
            $filePath = $request->file('photo_proof')->store('public/uploads');
            $complaint->photo_proof = $filePath;
        }

        $complaint->save();

        // Kirim notifikasi ke semua admin
        $adminUsers = User::where('role_id', Role::ROLE_ADMIN)->get();
        foreach ($adminUsers as $admin) {
            $admin->notify(new ComplaintStatusChanged(
                $complaint,
                null,            
                'new',           
                'Admin',         
                true              
            ));
        }

        return redirect('/complaint')->with('success', 'Berhasil mengajukan aspirasi');
    }

    public function edit($id)
    {
        $resident = Auth::user()->resident;
        if (!$resident) {
            return redirect('/complaint')->with('error', 'Akun anda belum terhubung dengan data penduduk manapun');
        }

        $complaint = Complaint::findOrFail($id);

        if ($complaint->resident_id !== $resident->id) {
            return redirect('/complaint')->with('error', 'Anda tidak memiliki akses untuk mengubah aduan ini.');
        }

        return view('pages.complaint.edit', compact('complaint'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'content' => ['required', 'min:3', 'max:2000'],
            'kategori' => ['required', Rule::in(['Pembangunan', 'Kesejahteraan Sosial', 'Ketentraman dan Ketertiban Umum', 'Pengelolaan Teknologi Informasi'])],
            'photo_proof' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $resident = Auth::user()->resident;
        if (!$resident) {
            return redirect('/complaint')->with('error', 'Akun anda belum terhubung dengan data penduduk manapun');
        }

        $complaint = Complaint::findOrFail($id);

        if ($complaint->resident_id !== $resident->id) {
            return redirect('/complaint')->with('error', 'Anda tidak memiliki akses untuk mengubah aduan ini.');
        }

        if ($complaint->status !== 'new') {
            return redirect('/complaint')->with('error', "Gagal mengubah aduan, status aduan anda saat ini adalah $complaint->status_label");
        }

        $complaint->title = $request->title;
        $complaint->content = $request->content;
        $complaint->kategori = $request->kategori;

        if ($request->hasFile('photo_proof')) {
            if ($complaint->photo_proof) {
                Storage::delete($complaint->photo_proof);
            }
            $filePath = $request->file('photo_proof')->store('public/uploads');
            $complaint->photo_proof = $filePath;
        }

        $complaint->save();

        return redirect('/complaint')->with('success', 'Berhasil mengubah aspirasi');
    }

    public function destroy($id)
    {
        $resident = Auth::user()->resident;
        if (!$resident) {
            return redirect('/complaint')->with('error', 'Akun anda belum terhubung dengan data penduduk manapun');
        }

        $complaint = Complaint::findOrFail($id);

        if ($complaint->resident_id !== $resident->id) {
            return redirect('/complaint')->with('error', 'Anda tidak memiliki akses untuk menghapus aduan ini.');
        }

        if ($complaint->status !== 'new') {
            return redirect('/complaint')->with('error', "Gagal menghapus aduan, status aduan anda saat ini adalah $complaint->status_label");
        }

        if ($complaint->photo_proof) {
            Storage::delete($complaint->photo_proof);
        }

        $complaint->delete();

        return redirect('/complaint')->with('success', 'Berhasil menghapus aspirasi');
    }

    public function update_status(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(['new', 'processing', 'completed'])],
        ]);

        $user = Auth::user();
        $complaint = Complaint::findOrFail($id);

        if ($user->role_id == Role::ROLE_USER) {
            return redirect('/complaint')->with('error', 'Anda tidak memiliki akses untuk mengubah status aduan.');
        }

        $oldStatus = $complaint->status_label;
        $complaint->status = $request->status;
        $complaint->save();

        $userToNotify = User::find(optional($complaint->resident)->user_id);
        if ($userToNotify) {
            $userToNotify->notify(new ComplaintStatusChanged(
                $complaint,
                $oldStatus,
                $complaint->status_label
            ));
        }

        return redirect('/complaint')->with('success', 'Berhasil mengubah status');
    }

    public function forward(Request $request, $id)
    {
        $request->validate([
            'forward_to' => ['required', Rule::in([
                Role::ROLE_KASI_PEMBANGUNAN,
                Role::ROLE_SEKRETARIS_LURAH,
                Role::ROLE_LURAH,
                Role::ROLE_KASI_KESEJAHTERAAN_SOSIAL,
                Role::ROLE_KASI_PEMERINTAHAN_KETENTRAMAN,
                Role::ROLE_PENGADMINISTRASI_UMUM
            ])],
        ]);

        $user = Auth::user();
        if (!in_array($user->role_id, [
            Role::ROLE_ADMIN,
            Role::ROLE_KASI_PEMBANGUNAN,
            Role::ROLE_SEKRETARIS_LURAH,
            Role::ROLE_LURAH,
            Role::ROLE_KASI_KESEJAHTERAAN_SOSIAL,
            Role::ROLE_KASI_PEMERINTAHAN_KETENTRAMAN,
            Role::ROLE_PENGADMINISTRASI_UMUM
        ])) {
            return redirect('/complaint')->with('error', 'Anda tidak memiliki akses untuk meneruskan aduan.');
        }

        $complaint = Complaint::findOrFail($id);
        $complaint->forwarded_to = $request->forward_to;
        $complaint->status = 'processing';
        $complaint->save();

        $usersToNotify = User::with('role')->where('role_id', $request->forward_to)->get();

        foreach ($usersToNotify as $userToNotify) {
            $roleName = optional($userToNotify->role)->name ?? 'tanpa nama role';
            $userToNotify->notify(new ComplaintStatusChanged(
                $complaint,
                null,
                null,
                $roleName,
                true
            ));
        }

        return redirect()->back()->with('success', 'Aspirasi berhasil diteruskan.');
    }

    public function publish($id)
    {
        $user = Auth::user();
        if ($user->role_id !== Role::ROLE_ADMIN) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mempublikasikan aduan.');
        }

        $complaint = Complaint::findOrFail($id);
        $complaint->publish();
        return redirect()->back()->with('success', 'Aduan berhasil dipublikasikan.');
    }

    public function unpublish($id)
    {
        $user = Auth::user();
        if ($user->role_id !== Role::ROLE_ADMIN) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk meng-unpublish aduan.');
        }

        $complaint = Complaint::findOrFail($id);
        $complaint->unpublish();
        return redirect()->back()->with('success', 'Aduan berhasil di-unpublish.');
    }
}