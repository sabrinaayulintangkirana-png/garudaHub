<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Project - Garuda-Hub</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h1 {
            margin-top: 0;
        }

        label {
            display: block;
            margin-top: 16px;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input, textarea, select {
            width: 100%;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .button {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 11px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 20px;
        }

        .back {
            background: #6b7280;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .alert {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>Tambah Project</h1>
    <p>Isi formulir berikut untuk menambahkan project baru.</p>

    @if($errors->any())
        <div class="alert">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf

        <label>Klien</label>
        <select name="client_id" required>
            <option value="">-- Pilih Klien --</option>

            @foreach($clients as $client)
                <option value="{{ $client->id }}"
                    {{ old('client_id') == $client->id ? 'selected' : '' }}>
                    {{ $client->nama }}
                </option>
            @endforeach
        </select>

        <label>Judul Project</label>
        <input type="text" name="judul"
               value="{{ old('judul') }}"
               maxlength="200" required>
        @error('judul')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Deskripsi</label>
        <textarea name="deskripsi" required>{{ old('deskripsi') }}</textarea>
        @error('deskripsi')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Kategori</label>
        <input type="text" name="kategori"
               value="{{ old('kategori') }}"
               maxlength="50" required>
        @error('kategori')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Budget Minimum (Rp)</label>
        <input type="number" name="budget_min"
               value="{{ old('budget_min', 0) }}"
               min="0" required>

        <label>Budget Maksimum (Rp)</label>
        <input type="number" name="budget_max"
               value="{{ old('budget_max', 0) }}"
               min="0" required>

        <label>Batas Lelang</label>
        <input type="date" name="batas_lelang"
               value="{{ old('batas_lelang') }}" required>

        <label>Status Project</label>
        <select name="status" required>
            <option value="terbuka"
                {{ old('status', 'terbuka') == 'terbuka' ? 'selected' : '' }}>
                Terbuka
            </option>
            <option value="ditutup"
                {{ old('status') == 'ditutup' ? 'selected' : '' }}>
                Ditutup
            </option>
        </select>

        <button type="submit" class="button">
            Simpan Project
        </button>

        <a href="{{ route('projects.index') }}" class="button back">
            Kembali
        </a>
    </form>

</div>

</body>
</html>
