<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penawaran - Garuda-Hub</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 30px; color: #333; }
        .container { max-width: 1100px; margin: auto; }
        table { width: 100%; border-collapse: collapse; background: white; margin-top: 20px; }
        th, td { padding: 13px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #e9efff; }
        .button { display: inline-block; padding: 10px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 5px; }
        .delete { padding: 7px 10px; background: #dc2626; color: white; border: 0; border-radius: 4px; cursor: pointer; }
        .success { padding: 12px; background: #dcfce7; color: #166534; margin: 15px 0; border-radius: 5px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Garuda-Hub</h1>
    <p>Daftar Penawaran Developer</p>

    <a href="{{ route('bids.create') }}" class="button">+ Tambah Penawaran</a>
    <a href="{{ route('projects.index') }}" class="button">Daftar Project</a>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Project</th>
                <th>Developer</th>
                <th>Harga</th>
                <th>Durasi</th>
                <th>Pemenang</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bids as $bid)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $bid->project->judul }}</td>
                    <td>{{ $bid->developer->nama }}</td>
                    <td>Rp{{ number_format($bid->harga, 0, ',', '.') }}</td>
                    <td>{{ $bid->durasi }} hari</td>
                    <td>{{ $bid->is_winner ? 'Ya' : 'Tidak' }}</td>
                    <td>
                        <a href="{{ route('bids.show', $bid->id) }}">Detail</a>
                        <a href="{{ route('bids.edit', $bid->id) }}">Edit</a>

                        <form action="{{ route('bids.destroy', $bid->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete" onclick="return confirm('Hapus penawaran ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;">Belum ada penawaran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</body>
</html>
