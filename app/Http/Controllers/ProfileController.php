<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Skill;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
{
    return view('profile.edit', [
        'user' => $request->user(),
        'skills' => Skill::all(), // Kirim semua data skill ke tampilan
    ]);
}

    /**
     * Update the user's profile information.
     */
   public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();
    $user->fill($request->validated());

    // Cek apakah ada file foto yang diunggah
    if ($request->hasFile('avatar')) {
        // Hapus foto profil lama dari storage jika bukan file bawaan
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Simpan foto baru ke folder 'public/avatars'
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
    }

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    // Logika sinkronisasi skill (tetap pertahankan yang sudah kita buat sebelumnya)
    if ($request->has('skills')) {
        $user->skills()->sync($request->skills);
    } else {
        $user->skills()->detach();
    }

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
