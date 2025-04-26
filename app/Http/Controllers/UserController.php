<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function account_request_view()
    {
        $users = User::where('status','submitted')->get();

        return view('pages.account-request.index', ['users' => $users,
        ]);
    }
    public function account_approval(Request $request, $userId)
    {
        $for = $request->input('for');


        $users = User::findOrFail($userId);
        $users->status = $for == 'approve' || $for == 'activate'? 'approved' : 'rejected';
        $users->save();

        if($for == 'activate') {
            return back()->with('success', 'Berhasil mengaktifkan akun');
        } elseif($for == 'deactivate'){
            return back()->with('success', 'Berhasil menon-aktifkan akun');
        }
        
        return back()->with('success', $for == 'approve' ? 'Berhasil menyetujui akun' : 'Berhasil menolak akun');
    }

    public function account_list_view()
    {
        $users = User::where('role_id', 2)->where('status', '!=', 'submitted')->get();

        return view('pages.account-list.index', [
            'users' => $users,
        ]);
    }
} 
