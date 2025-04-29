<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function account_request_view()
    {
        $users = User::where('status','submitted')->paginate(10);
        $residents = Resident::where('user_id', null)->get();

        return view('pages.account-request.index',[
        'users' => $users,
        'residents' => $residents,
        ]);
    }
    public function account_approval(Request $request, $userId)
    {
        $request->validate([
            'for' => ['required', Rule::in(['approve', 'reject', 'activate', 'deactivate'])],
            'resident_id' => ['nullable', 'exists:residents,id']
        ]);
        
        $for = $request->input('for');


        $users = User::findOrFail($userId);
        $users->status = $for == 'approve' || $for == 'activate'? 'approved' : 'rejected';
        $users->save();

        $residentId = $request->input('resident_id');

        if ($request->has('resident_id') && isset($residentId)){
            Resident::where('id', $residentId)->update([
                'user_id' => $users->id,
            ]);
        }

        if($for == 'activate') {
            return back()->with('success', 'Berhasil mengaktifkan akun');
        } elseif($for == 'deactivate'){
            return back()->with('success', 'Berhasil menon-aktifkan akun');
        }
        
        return back()->with('success', $for == 'approve' ? 'Berhasil menyetujui akun' : 'Berhasil menolak akun');
    }

    public function account_list_view()
    {
        $users = User::where('role_id', 2)->where('status', '!=', 'submitted')->paginate(10);

        return view('pages.account-list.index', [
            'users' => $users,
        ]);
    }

    public function profile_view()
    {
        return view('pages.profile.index');
    }

    public function update_profile(Request $request, $userId)
    {
        $request->validate([
            'name' => 'required|min:3'
        ]);
        $user = User::findOrFail($userId);
        $user->name = $request->input('name');
        $user->save();

        return back()->with('success', 'Berhasil mengubah data');
    }

    public function chage_password_view()
    {
        return view('pages.profile.change-password');
    }

    public function change_password(Request $request, $userId)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
        ]);

        $user = User::findOrFail($userId);
        
        $currentPasswordIsValid = Hash::check($request->input('old_password'), $user->password);

        if ($currentPasswordIsValid) {
            $user->password = $request->input('new_password');
            $user->save();
            return back()->with('success', 'Berhasil mengubah data');
        }

        return back()->with('error', 'Gagal mengubah data, password lama tidak sesuai');
    }
} 
