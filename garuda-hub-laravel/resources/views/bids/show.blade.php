<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penawaran - Garuda-Hub</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 30px; color: #333; }
        .container { max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 10px; }
        .item { padding: 13px 0; border-bottom: 1px solid #eee; }
        .button { display: inline-block; padding: 10px 16px; margin-top: 20px; background: #2563eb; color: white; text-decoration: none; border-radius: 5px; }
        .back { background: #6b7280; }
    </style>
</head>
<body>
<div class="container">
    <h1>Detail Penawaran</h1>

    <div class="item">
        <strong>Project:</strong> {{ $bid->project->judul }}
    </div>

    <div class="item">
        <strong>Developer:</strong> {{ $bid->developer->nama }}
    </div>

    <div class="item">
        <strong>Harga:</strong>
        Rp{{ number_format($bid->harga, 0, ',', '.') }}
    </div>

    <div class="item">
        <strong>Durasi:</strong> {{ $bid->durasi }} hari
    </div>

    <div class="item">
        <strong>Proposal:</strong><br>
        {{ $bid->proposal }}
    </div>

    <div class="item">
        <strong>Status Pemenang:</strong>
        {{ $bid->is_winner ? 'Ya' : 'Tidak' }}
    </div>

    <a href="{{ route('bids.index') }}" class="button back">Kembali</a>
    <a href="{{ route('bids.edit', $bid->id) }}" class="button">Edit Penawaran</a>
</div>
</body>
</html>
