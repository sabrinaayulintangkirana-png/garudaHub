<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Project - Garuda-Hub</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        h1 {
            margin-bottom: 5px;
        }

        .subtitle {
            color: #777;
            margin-bottom: 25px;
        }

        .button {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 6px;
            border: none;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #e9efff;
        }

        .badge {
            padding: 5px 9px;
            border-radius: 5px;
            font-size: 12px;
        }

        .terbuka {
            background: #dcfce7;
            color: #166534;
        }

        .ditutup {
            background: #fee2e2;
            color: #991b1b;
        }

        .action a {
            margin-right: 8px;
        }

        .delete-button {
            background: #dc2626;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .logout-button {
            background: #dc2626;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 6px;
            margin: 15px 0;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- Header dan tombol Logout -->
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">

        <div>
            <h1>Garuda-Hub</h1>
            <p class="subtitle">Daftar Project yang tersedia</p>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="logout-button">
                Logout
            </button>
        </form>

    </div>

    <!-- Tombol navigasi -->
    <a href="{{ route('projects.create') }}" class="button">
        + Tambah Project
    </a>

    <a href="{{ route('bids.index') }}" class="button">
        Lihat Penawaran
    </a>

    <!-- Pesan sukses -->
    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel daftar project -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Project</th>
                <th>Klien</th>
                <th>Kategori</th>
                <th>Budget</th>
                <th>Batas Lelang</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($projects as $project)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $project->judul }}</td>

                    <td>{{ $project->client->nama }}</td>

                    <td>{{ $project->kategori }}</td>

                    <td>
                        Rp{{ number_format($project->budget_min, 0, ',', '.') }}
                        -
                        Rp{{ number_format($project->budget_max, 0, ',', '.') }}
                    </td>

                    <td>{{ $project->batas_lelang }}</td>

                    <td>
                        <span class="badge {{ $project->status }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    </td>

                    <td class="action">

                        <a href="{{ route('projects.show', $project->id) }}">
                            Detail
                        </a>

                        <a href="{{ route('projects.edit', $project->id) }}">
                            Edit
                        </a>

                        <form action="{{ route('projects.destroy', $project->id) }}"
                              method="POST"
                              style="display:inline;">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="delete-button"
                                    onclick="return confirm('Yakin ingin menghapus project ini?')">
                                Hapus
                            </button>

                        </form>

                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">
                        Belum ada data project.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

</body>
</html>
