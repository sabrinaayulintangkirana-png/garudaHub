<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project - Garuda-Hub</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 30px; color: #333; }
        .container { max-width: 700px; margin: auto; background: white; padding: 30px; border-radius: 10px; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 11px; margin-top: 7px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 5px; }
        textarea { min-height: 100px; }
        button, .button { display: inline-block; padding: 11px 18px; margin-top: 20px; border: 0; border-radius: 5px; background: #2563eb; color: white; text-decoration: none; cursor: pointer; }
        .back { background: #6b7280; }
        .error { color: red; margin-top: 5px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Edit Project</h1>
    <p>Perbarui informasi project berikut.</p>

    @if($errors->any())
        <ul class="error">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Klien</label>
        <select name="client_id" required>
            @foreach($clients as $client)
                <option value="{{ $client->id }}"
                    {{ old('client_id', $project->client_id) == $client->id ? 'selected' : '' }}>
                    {{ $client->nama }}
                </option>
            @endforeach
        </select>

        <label>Judul Project</label>
        <input type="text" name="judul" value="{{ old('judul', $project->judul) }}" required>

        <label>Deskripsi</label>
        <textarea name="deskripsi" required>{{ old('deskripsi', $project->deskripsi) }}</textarea>

        <label>Kategori</label>
        <input type="text" name="kategori" value="{{ old('kategori', $project->kategori) }}" required>

        <label>Budget Minimum (Rp)</label>
        <input type="number" name="budget_min" min="0" value="{{ old('budget_min', $project->budget_min) }}" required>

        <label>Budget Maksimum (Rp)</label>
        <input type="number" name="budget_max" min="0" value="{{ old('budget_max', $project->budget_max) }}" required>

        <label>Batas Lelang</label>
        <input type="date" name="batas_lelang" value="{{ old('batas_lelang', $project->batas_lelang) }}" required>

        <label>Status</label>
        <select name="status" required>
            <option value="terbuka" {{ old('status', $project->status) == 'terbuka' ? 'selected' : '' }}>Terbuka</option>
            <option value="ditutup" {{ old('status', $project->status) == 'ditutup' ? 'selected' : '' }}>Ditutup</option>
        </select>

        <button type="submit">Simpan Perubahan</button>
        <a href="{{ route('projects.index') }}" class="button back">Kembali</a>
    </form>
</div>
</body>
</html>
