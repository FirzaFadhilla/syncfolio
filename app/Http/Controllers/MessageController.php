<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    // Menampilkan halaman chat utama
    public function index(Request $request): View
    {
        $authId = auth()->id();

        // 1. Ambil daftar orang yang pernah chat dengan kita
        $chatWithUserIds = Message::where('sender_id', $authId)
            ->orWhere('receiver_id', $authId)
            ->get()
            ->map(function ($message) use ($authId) {
                return $message->sender_id == $authId ? $message->receiver_id : $message->sender_id;
            })->unique();

        $activeChats = User::whereIn('id', $chatWithUserIds)->get();

        // 2. Jika ada pengguna spesifik yang sedang dibuka chat-nya (?user=ID)
        $selectedUser = null;
        $messages = collect();

        if ($request->has('user')) {
            $selectedUser = User::findOrFail($request->user);
            
            // KODE BARU: Otomatis tandai semua pesan MASUK dari user ini sebagai "Sudah Dibaca" (is_read = true)
            Message::where('sender_id', $selectedUser->id)
                ->where('receiver_id', $authId)
                ->where('is_read', false)
                ->update(['is_read' => true]);

            // Ambil riwayat chat antara kita dengan user tersebut
            $messages = Message::where(function($q) use ($authId, $selectedUser) {
                $q->where('sender_id', $authId)->where('receiver_id', $selectedUser->id);
            })->orWhere(function($q) use ($authId, $selectedUser) {
                $q->where('sender_id', $selectedUser->id)->where('receiver_id', $authId);
            })->orderBy('created_at', 'asc')->get();
        }

        return view('messages.index', compact('activeChats', 'selectedUser', 'messages'));
    }

    // Menyimpan/Mengirim pesan baru
    public function store(Request $request, $receiverId): RedirectResponse
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiverId,
            'body' => $request->body,
            'is_read' => false, // Pesan baru otomatis berstatus belum dibaca oleh penerima
        ]);

        return redirect()->route('messages.index', ['user' => $receiverId]);
    }
}