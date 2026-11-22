<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BidController extends Controller
{
    // Menampilkan seluruh penawaran
    public function index()
    {
        $bids = Bid::with(['project', 'developer'])->latest()->get();

        return view('bids.index', compact('bids'));
    }

    // Menampilkan form tambah penawaran
    public function create()
    {
        $projects = Project::where('status', 'terbuka')->get();
        $developers = User::where('role', 'developer')->get();

        return view('bids.create', compact('projects', 'developers'));
    }

    // Menyimpan penawaran baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => [
                'required',
                Rule::exists('projects', 'id')->where('status', 'terbuka'),
            ],
            'developer_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'developer'),
                Rule::unique('bids', 'developer_id')
                    ->where(fn ($query) => $query->where(
                        'project_id',
                        $request->input('project_id')
                    )),
            ],
            'harga' => 'required|integer|min:1',
            'durasi' => 'required|integer|min:1',
            'proposal' => 'required|string',
        ]);

        Bid::create($validated);

        return redirect()->route('bids.index')
            ->with('success', 'Penawaran berhasil ditambahkan.');
    }

    // Menampilkan detail penawaran
    public function show(Bid $bid)
    {
        $bid->load(['project', 'developer']);

        return view('bids.show', compact('bid'));
    }

    // Menampilkan form edit penawaran
    public function edit(Bid $bid)
    {
        $projects = Project::all();
        $developers = User::where('role', 'developer')->get();

        return view('bids.edit', compact('bid', 'projects', 'developers'));
    }

    // Memperbarui penawaran
    public function update(Request $request, Bid $bid)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'developer_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'developer'),
                Rule::unique('bids', 'developer_id')
                    ->where(fn ($query) => $query->where(
                        'project_id',
                        $request->input('project_id')
                    ))
                    ->ignore($bid->id),
            ],
            'harga' => 'required|integer|min:1',
            'durasi' => 'required|integer|min:1',
            'proposal' => 'required|string',
            'is_winner' => 'required|boolean',
        ]);

        // Project tertutup tidak boleh dipilih sebagai project baru
        if (
            $validated['project_id'] != $bid->project_id &&
            Project::where('id', $validated['project_id'])
                ->where('status', 'terbuka')
                ->doesntExist()
        ) {
            return back()->withErrors([
                'project_id' => 'Project sudah ditutup.',
            ])->withInput();
        }

        $bid->update($validated);

        return redirect()->route('bids.index')
            ->with('success', 'Penawaran berhasil diperbarui.');
    }

    // Menghapus penawaran
    public function destroy(Bid $bid)
    {
        $bid->delete();

        return redirect()->route('bids.index')
            ->with('success', 'Penawaran berhasil dihapus.');
    }
}
