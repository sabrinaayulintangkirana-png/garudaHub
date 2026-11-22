<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Project - Garuda-Hub</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 30px; color: #333; }
        .container { max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 10px; }
        .item { padding: 12px 0; border-bottom: 1px solid #eee; }
        .button { display: inline-block; padding: 10px 16px; margin-top: 20px; background: #2563eb; color: white; text-decoration: none; border-radius: 5px; }
        .back { background: #6b7280; }
    </style>
</head>
<body>
<div class="container">
    <h1>Detail Project</h1>

    <div class="item"><strong>Judul:</strong> {{ $project->judul }}</div>
    <div class="item"><strong>Klien:</strong> {{ $project->client->nama }}</div>
    <div class="item"><strong>Deskripsi:</strong> {{ $project->deskripsi }}</div>
    <div class="item"><strong>Kategori:</strong> {{ $project->kategori }}</div>
    <div class="item"><strong>Budget Minimum:</strong> Rp{{ number_format($project->budget_min, 0, ',', '.') }}</div>
    <div class="item"><strong>Budget Maksimum:</strong> Rp{{ number_format($project->budget_max, 0, ',', '.') }}</div>
    <div class="item"><strong>Batas Lelang:</strong> {{ $project->batas_lelang }}</div>
    <div class="item"><strong>Status:</strong> {{ ucfirst($project->status) }}</div>

    <h2>Daftar Penawaran</h2>

    @forelse($project->bids as $bid)
        <div class="item">
            <strong>Developer:</strong> {{ $bid->developer->nama }}<br>
            <strong>Harga:</strong> Rp{{ number_format($bid->harga, 0, ',', '.') }}<br>
            <strong>Durasi:</strong> {{ $bid->durasi }} hari<br>
            <strong>Proposal:</strong> {{ $bid->proposal }}<br>
            <strong>Pemenang:</strong> {{ $bid->is_winner ? 'Ya' : 'Tidak' }}
        </div>
    @empty
        <p>Belum ada penawaran untuk project ini.</p>
    @endforelse

    <a href="{{ route('projects.index') }}" class="button back">Kembali</a>
    <a href="{{ route('bids.create') }}" class="button">Tambah Penawaran</a>
</div>
</body>
</html>
