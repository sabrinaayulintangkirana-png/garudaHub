<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penawaran - Garuda-Hub</title>
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
    <h1>Edit Penawaran</h1>

    @if($errors->any())
        <ul class="error">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('bids.update', $bid->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Project</label>
        <select name="project_id" required>
            @foreach($projects as $project)
                <option value="{{ $project->id }}"
                    {{ old('project_id', $bid->project_id) == $project->id ? 'selected' : '' }}>
                    {{ $project->judul }}
                </option>
            @endforeach
        </select>

        <label>Developer</label>
        <select name="developer_id" required>
            @foreach($developers as $developer)
                <option value="{{ $developer->id }}"
                    {{ old('developer_id', $bid->developer_id) == $developer->id ? 'selected' : '' }}>
                    {{ $developer->nama }}
                </option>
            @endforeach
        </select>

        <label>Harga Penawaran (Rp)</label>
        <input type="number" name="harga" min="1"
               value="{{ old('harga', $bid->harga) }}" required>

        <label>Durasi Pengerjaan (hari)</label>
        <input type="number" name="durasi" min="1"
               value="{{ old('durasi', $bid->durasi) }}" required>

        <label>Proposal</label>
        <textarea name="proposal" required>{{ old('proposal', $bid->proposal) }}</textarea>

        <label>
            <input type="hidden" name="is_winner" value="0">
            <input type="checkbox" name="is_winner" value="1"
                   style="width:auto;"
                   {{ old('is_winner', $bid->is_winner) ? 'checked' : '' }}>
            Jadikan pemenang
        </label>

        <button type="submit">Simpan Perubahan</button>
        <a href="{{ route('bids.index') }}" class="button back">Kembali</a>
    </form>
</div>
</body>
</html>
