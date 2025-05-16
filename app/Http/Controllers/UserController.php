<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function profile_view()
    {
        return view('pages.profile.index');
    }

    public function update_profile(Request $request, $userId)
    {
        $request->validate([
            'name' => 'required|min:3',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $user = User::findOrFail($userId);
        $user->name = $request->input('name');
    
        // Jika foto di-upload, proses penyimpanan foto
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profile_photos', 'public');
    
            // Hapus foto lama jika ada
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
    
            $user->profile_photo = $photoPath;
        }
    
        $user->save();
    
        return back()->with('success', 'Berhasil mengubah data');
    }

    public function change_password_view()
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
            $user->password = Hash::make($request->input('new_password'));
            $user->save();
            return back()->with('success', 'Berhasil mengubah data');
        }

        return back()->with('error', 'Gagal mengubah data, password lama tidak sesuai');
    }
} 