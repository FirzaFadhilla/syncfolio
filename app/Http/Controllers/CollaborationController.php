<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CollaborationRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CollaborationController extends Controller
{
    // 1. Mengirim Request (Sudah dibuat sebelumnya)
    public function store(Request $request, $receiverId): RedirectResponse
    {
        if (auth()->id() == $receiverId) {
            return redirect()->back()->with('error', 'Tidak bisa mengajak diri sendiri.');
        }

        CollaborationRequest::firstOrCreate([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiverId,
        ]);

        return redirect()->back()->with('success', 'Undangan kolaborasi berhasil dikirim!');
    }

    // 2. Menampilkan Daftar Request yang Masuk
    public function index(): View
    {
        // Ambil request yang tertuju ke kita dengan status 'pending'
        $incomingRequests = CollaborationRequest::where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->with('sender.skills') // Muat data pengirim dan skill-nya
            ->latest()
            ->get();

        return view('collaborations.index', compact('incomingRequests'));
    }

    // 3. Menerima Undangan
    public function accept($id): RedirectResponse
    {
        $collaboration = CollaborationRequest::where('receiver_id', auth()->id())->findOrFail($id);
        $collaboration->update(['status' => 'accepted']);

        return redirect()->back()->with('success', 'Undangan kolaborasi diterima!');
    }

    // 4. Menolak Undangan
    public function reject($id): RedirectResponse
    {
        $collaboration = CollaborationRequest::where('receiver_id', auth()->id())->findOrFail($id);
        $collaboration->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Undangan kolaborasi ditolak.');
    }
}