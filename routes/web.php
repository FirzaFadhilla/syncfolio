<?php

use App\Http\Controllers\CollaborationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Halaman Publik)
|--------------------------------------------------------------------------
*/

Route::get('/', function (Request $request) {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    $query = User::with(['skills', 'projects'])->latest();

    // Filter Berdasarkan Skill
    if ($request->filled('skill')) {
        $skillSlug = $request->skill;
        $query->whereHas('skills', function ($q) use ($skillSlug) {
            $q->where('slug', $skillSlug);
        });
    }

    // Filter Pencarian Publik (Nama, Bio, Lokasi)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('bio', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%");
        });
    }

    $users = $query->paginate(10)->withQueryString();
    $skills = Skill::all(); 

    // Rekomendasi 3 User secara acak/ketersediaan
    $suggestedUsers = User::with('skills')
        ->orderByRaw("FIELD(availability_status, 'Mencari Kolaborator', 'Terbuka Gabung Proyek', 'Tidak Tersedia') ASC")
        ->take(3)
        ->get();
    
    // Top 3 Skill berdasarkan jumlah user
    $totalUsersCount = User::count();
    $topSkills = Skill::withCount('users')
                    ->orderByDesc('users_count')
                    ->take(3)
                    ->get();

    return view('welcome', compact('users', 'skills', 'suggestedUsers', 'topSkills', 'totalUsersCount'));
})->name('welcome');


/*
|--------------------------------------------------------------------------
| GERBANG AUTENTIKASI (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    /**
     * 1. DASHBOARD & DISCOVER
     */
    Route::get('/dashboard', function (Request $request) {
        $authId = auth()->id();
        $authUser = auth()->user();

        // Query dasar ambil user lain
        $query = User::where('id', '!=', $authId)->with(['skills', 'projects'])->latest();

        // Filter Berdasarkan Skill
        if ($request->filled('skill')) {
            $skillSlug = $request->skill;
            $query->whereHas('skills', function ($q) use ($skillSlug) {
                $q->where('slug', $skillSlug);
            });
        }

        // Filter Berdasarkan Text Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('bio', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10)->withQueryString();
        $skills = Skill::all(); 
        $sentRequestUserIds = $authUser->sentRequests()->pluck('receiver_id')->toArray();
        
        // KODE BARU: Ambil ID talenta yang sudah di-bookmark
        $bookmarkIds = $authUser->savedTalents()->pluck('talent_id')->toArray();

        // Logika rekomendasi pintar
        $mySkillNames = $authUser->skills()->pluck('name')->toArray();
        $complementarySkills = [];
        
        if (in_array('Laravel', $mySkillNames) || in_array('Python', $mySkillNames) || in_array('Dart', $mySkillNames) || in_array('Flutter', $mySkillNames)) {
            $complementarySkills = ['UI/UX Design', 'React'];
        } elseif (in_array('UI/UX Design', $mySkillNames) || in_array('React', $mySkillNames)) {
            $complementarySkills = ['Laravel', 'Flutter', 'Python'];
        } else {
            $complementarySkills = ['Laravel', 'Flutter', 'UI/UX Design', 'React', 'Python', 'Dart'];
        }

        $suggestedUsers = User::where('id', '!=', $authId)
            ->whereHas('skills', function ($q) use ($complementarySkills) {
                $q->whereIn('name', $complementarySkills);
            })
            ->with('skills')
            ->orderByRaw("FIELD(availability_status, 'Mencari Kolaborator', 'Terbuka Gabung Proyek', 'Tidak Tersedia') ASC")
            ->take(3)
            ->get();

        // Top 3 Skill berdasarkan jumlah user
        $totalUsersCount = User::count();
        $topSkills = Skill::withCount('users')
                        ->orderByDesc('users_count')
                        ->take(3)
                        ->get();

        return view('dashboard', compact('users', 'skills', 'sentRequestUserIds', 'suggestedUsers', 'topSkills', 'totalUsersCount', 'bookmarkIds'));
    })->name('dashboard');


    /**
     * 2. PENGATURAN PROFIL
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    /**
     * 3. DETAIL KREATOR & BOOKMARK (SAVED TALENTS)
     */
    // Halaman Detail Profil Kreator (Dipindah ke dalam auth agar tidak error)
    Route::get('/kreator/{id}', function ($id) {
        $user = User::with(['skills', 'projects'])->findOrFail($id);
        $sentRequestUserIds = auth()->user()->sentRequests()->pluck('receiver_id')->toArray();
        
        return view('profile.show', compact('user', 'sentRequestUserIds'));
    })->name('kreator.show');

    // Rute untuk Simpan / Batal Simpan Talenta
    Route::post('/bookmark/{id}', function ($id) {
        auth()->user()->savedTalents()->toggle($id);
        return back();
    })->name('talent.bookmark');

    // Halaman List Talenta Tersimpan
    Route::get('/saved-talents', function () {
        $savedTalents = auth()->user()->savedTalents()->with(['skills', 'projects'])->latest()->get();
        return view('profile.saved', compact('savedTalents'));
    })->name('talent.saved');


    /**
     * 4. UNDANGAN & KONEKSI KOLABORASI
     */
    Route::post('/collaboration/request/{receiver_id}', [CollaborationController::class, 'store'])->name('collaboration.request');
    Route::get('/collaboration/requests', [CollaborationController::class, 'index'])->name('collaboration.index');
    Route::patch('/collaboration/requests/{id}/accept', [CollaborationController::class, 'accept'])->name('collaboration.accept');
    Route::patch('/collaboration/requests/{id}/reject', [CollaborationController::class, 'reject'])->name('collaboration.reject');


    /**
     * 5. RUANG OBROLAN (CHAT ROOM)
     */
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/{receiver_id}', [MessageController::class, 'store'])->name('messages.store');


    /**
     * 6. MANAJEMEN PORTOS (PROJECT SHOWCASE)
     */
    Route::get('/my-projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/my-projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::delete('/my-projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');

});
// --- FITUR LAPORKAN PENGGUNA (Oleh User Biasa) ---
    Route::post('/report/{user}', function (\Illuminate\Http\Request $request, \App\Models\User $user) {
        $request->validate(['reason' => 'required|string', 'description' => 'nullable|string']);
        
        \App\Models\Report::create([
            'reporter_id' => auth()->id(),
            'reported_user_id' => $user->id,
            'reason' => $request->reason,
            'description' => $request->description,
        ]);
        return back()->with('status', 'report-sent');
    })->name('report.store');


    // --- PANEL KONTROL KHUSUS ADMIN ---
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Halaman Utama Dashboard Admin
        Route::get('/', function () {
            if (!auth()->user()->is_admin) abort(403, 'Akses Ditolak. Anda bukan Admin.');
            
            $reports = \App\Models\Report::with(['reporter', 'reportedUser'])->where('status', 'pending')->latest()->get();
            $users = \App\Models\User::where('is_admin', false)->latest()->get();
            
            return view('admin.dashboard', compact('reports', 'users'));
        })->name('dashboard');

        // Aksi Takedown / Hapus Akun Permanen
        Route::delete('/user/{user}', function (\App\Models\User $user) {
            if (!auth()->user()->is_admin) abort(403);
            $user->delete(); // Otomatis menghapus portofolio & laporannya
            return back()->with('status', 'user-deleted');
        })->name('user.destroy');

        // Aksi Abaikan Laporan (Jika tidak terbukti bersalah)
        Route::patch('/report/{report}/resolve', function (\App\Models\Report $report) {
            if (!auth()->user()->is_admin) abort(403);
            $report->update(['status' => 'resolved']);
            return back()->with('status', 'report-resolved');
        })->name('report.resolve');

        // Toggle Suspend / Unsuspend Account
     // Toggle Suspend / Unsuspend Account with Reason
        Route::patch('/user/{user}/suspend', function (\App\Models\User $user, Illuminate\Http\Request $request) {
            if (!auth()->user()->is_admin) abort(403);
            
            $isSuspending = !$user->is_suspended;
            $user->update([
                'is_suspended' => $isSuspending,
                'suspend_reason' => $isSuspending ? $request->input('reason') : null, // Simpan alasan
            ]);
            
            return back()->with('status', $isSuspending ? 'user-suspended' : 'user-restored');
        })->name('user.suspend');

    });

// Rute Autentikasi Bawaan Breeze (Login, Register, dll)
require __DIR__.'/auth.php';