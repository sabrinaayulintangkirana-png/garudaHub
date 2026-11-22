<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'developer_id' => ['required', 'exists:users,id'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'komentar' => ['nullable', 'string', 'max:1000'],
        ]);

        $project = Project::findOrFail($validated['project_id']);

        // Hanya client pemilik project yang boleh memberi rating.
        abort_unless(
            (int) $project->client_id === (int) $request->user()->id,
            403
        );

        // Hanya developer pemenang yang boleh menerima rating.
        $isWinner = $project->bids()
            ->where('developer_id', $validated['developer_id'])
            ->where('is_winner', true)
            ->exists();

        abort_unless(
            $isWinner,
            403,
            'Rating hanya dapat diberikan kepada developer pemenang.'
        );

        // Mencegah client memberi rating berulang.
        $alreadyRated = Rating::where('project_id', $project->id)
            ->where('client_id', $request->user()->id)
            ->where('developer_id', $validated['developer_id'])
            ->exists();

        if ($alreadyRated) {
            return back()->withErrors([
                'rating' => 'Developer ini sudah pernah kamu beri rating.',
            ]);
        }

        Rating::create([
            'project_id' => $project->id,
            'client_id' => $request->user()->id,
            'developer_id' => $validated['developer_id'],
            'rating' => $validated['rating'],
            'komentar' => $validated['komentar'] ?? null,
        ]);

        return back()->with('success', 'Rating berhasil diberikan.');
    }
}
