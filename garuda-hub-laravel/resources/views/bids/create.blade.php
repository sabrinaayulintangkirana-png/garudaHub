<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penawaran - Garuda-Hub</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 30px; color: #333; }
        .container { max-width: 700px; margin: auto; background: white; padding: 30px; border-radius: 10px; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 11px; margin-top: 7px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 5px; }
        textarea { min-height: 110px; }
        button, .button { display: inline-block; padding: 11px 18px; margin-top: 20px; border: 0; border-radius: 5px; background: #2563eb; color: white; text-decoration: none; cursor: pointer; }
        .back { background: #6b7280; }
        .error { color: red; }
    </style>
</head>
<body>
<div class="container">
    <h1>Tambah Penawaran</h1>
    <p>Masukkan informasi penawaran dari developer.</p>

    @if($errors->any())
        <ul class="error">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('bids.store') }}" method="POST">
        @csrf

        <label>Project</label>
        <select name="project_id" required>
            <option value="">-- Pilih Project --</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                    {{ $project->judul }}
                </option>
            @endforeach
        </select>

        <label>Developer</label>
        <select name="developer_id" required>
            <option value="">-- Pilih Developer --</option>
            @foreach($developers as $developer)
                <option value="{{ $developer->id }}" {{ old('developer_id') == $developer->id ? 'selected' : '' }}>
                    {{ $developer->nama }}
                </option>
            @endforeach
        </select>

        <label>Harga Penawaran (Rp)</label>
        <input type="number" name="harga" min="1" value="{{ old('harga') }}" required>

        <label>Durasi Pengerjaan (hari)</label>
        <input type="number" name="durasi" min="1" value="{{ old('durasi') }}" required>

        <label>Proposal</label>
        <textarea name="proposal" required>{{ old('proposal') }}</textarea>

        <button type="submit">Simpan Penawaran</button>
        <a href="{{ route('bids.index') }}" class="button back">Kembali</a>
    </form>
</div>
</body>
</html>
