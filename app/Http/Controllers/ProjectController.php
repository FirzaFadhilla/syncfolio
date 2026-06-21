<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProjectController extends Controller
{
    // Menampilkan semua proyek milik user yang login
    public function index(): View
    {
        $projects = auth()->user()->projects()->latest()->get();
        return view('projects.index', compact('projects'));
    }

    // Menyimpan proyek baru ke database
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'link' => 'nullable|url|max:255',
        ]);

        auth()->user()->projects()->create([
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
        ]);

        return redirect()->back()->with('status', 'project-added');
    }

    // Menghapus proyek berdasarkan ID
    public function destroy($id): RedirectResponse
    {
        // Pastikan proyek yang dihapus memang milik user yang sedang login
        $project = auth()->user()->projects()->findOrFail($id);
        $project->delete();

        return redirect()->back()->with('status', 'project-deleted');
    }
}