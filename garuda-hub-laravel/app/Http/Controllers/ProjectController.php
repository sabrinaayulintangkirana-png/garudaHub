<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    // Menampilkan seluruh project
    public function index()
    {
        $projects = Project::with('client')
            ->latest()
            ->get();

        return view('projects.index', compact('projects'));
    }

    // Menampilkan form tambah project
    public function create()
    {
        $clients = User::where('role', 'klien')->get();

        return view('projects.create', compact('clients'));
    }

    // Menyimpan project baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'klien'),
            ],
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string|max:100',
            'budget_min' => 'required|integer|min:0',
            'budget_max' => 'required|integer|min:0|gte:budget_min',
            'batas_lelang' => 'required|date',
            'status' => 'required|in:terbuka,ditutup',
        ]);

        Project::create($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil ditambahkan.');
    }

    // Menampilkan detail project beserta penawaran dan rating
    public function show(Project $project)
    {
        $project->load([
            'client',
            'bids.developer',
            'ratings',
        ]);

        return view('projects.show', compact('project'));
    }

    // Menampilkan form edit project
    public function edit(Project $project)
    {
        $clients = User::where('role', 'klien')->get();

        return view('projects.edit', compact('project', 'clients'));
    }

    // Memperbarui project
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'client_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'klien'),
            ],
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string|max:100',
            'budget_min' => 'required|integer|min:0',
            'budget_max' => 'required|integer|min:0|gte:budget_min',
            'batas_lelang' => 'required|date',
            'status' => 'required|in:terbuka,ditutup',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil diperbarui.');
    }

    // Menghapus project
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil dihapus.');
    }
}
