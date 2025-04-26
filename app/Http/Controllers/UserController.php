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
        $users->status = $for == 'approve' ? 'approved' : 'rejected';
        $users->save();

        return back()->with('success', $for == 'approve' ? 'Berhasil menyetujui akun' : 'Berhasil menolak akun');
    }
} 
