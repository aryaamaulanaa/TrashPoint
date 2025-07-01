<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile detail view.
     */
    public function show(Request $request): View // <--- METHOD BARU UNTUK MENAMPILKAN DETAIL PROFIL
    {
        return view('profile.show', [
            'user' => $request->user(), // Mengambil user yang sedang login
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Ambil semua data yang sudah divalidasi
        $validatedData = $request->validated();

        // Handle Upload Foto Profil Baru
        if ($request->hasFile('profile_picture')) {
            // Hapus foto profil lama jika ada dan BUKAN 'images/default_profile.jpeg'
            if ($user->profile_picture && $user->profile_picture !== 'images/default_profile.jpeg' && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Simpan foto profil baru ke folder 'profile_pictures' di disk 'public'
            $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $imagePath;
        }

        // Hapus 'profile_picture' dari array data yang divalidasi jika ada, agar tidak menimpa path yang sudah di-set
        if (array_key_exists('profile_picture', $validatedData)) {
            unset($validatedData['profile_picture']);
        }

        // Isi data lainnya ke user model
        $user->fill($validatedData);

        // Penanganan jika email berubah (bawaan Breeze)
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save(); // Simpan semua perubahan ke database

        // PASTIKAN BARIS INI ADA DAN MENYETEL SESSION STATUS DENGAN BENAR
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Handle the deletion of the user's profile picture.
     */
    public function deleteProfilePicture(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Pastikan user memiliki foto profil dan bukan yang 'images/default_profile.jpeg'
        if ($user->profile_picture && $user->profile_picture !== 'images/default_profile.jpeg') {
            // Hapus file gambar dari storage jika memang ada di sana
            if (Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            // Set kolom profile_picture di database ke 'images/default_profile.jpeg'
            $user->profile_picture = 'images/default_profile.jpeg';
            $user->save();

            return Redirect::route('profile.edit')->with('status', 'Foto profil berhasil dihapus dan dikembalikan ke default.');
        }

        return Redirect::route('profile.edit')->with('error', 'Tidak ada foto profil kustom yang bisa dihapus.');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Hapus foto profil user sebelum menghapus user
        // HANYA HAPUS FOTO KUSTOM, JANGAN 'images/default_profile.jpeg'
        if ($user->profile_picture && $user->profile_picture !== 'images/default_profile.jpeg' && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}