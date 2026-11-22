<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Project - Garuda Hub</title>
</head>
<body>
    <h2>Detail Project</h2>

    <h3>{{ $project->judul }}</h3>
    <p><strong>Klien:</strong> {{ $project->client->nama ?? '-' }}</p>
    <p><strong>Kategori:</strong> {{ $project->kategori }}</p>
    <p><strong>Deskripsi:</strong> {{ $project->deskripsi }}</p>

    <hr>

    <h3>Daftar Penawaran</h3>

    @foreach ($project->bids as $bid)
        <div style="border:1px solid #ddd; padding:15px; margin-bottom:15px;">
            <p><strong>Developer:</strong> {{ $bid->developer->nama ?? '-' }}</p>
            <p><strong>Harga:</strong> Rp{{ number_format($bid->harga, 0, ',', '.') }}</p>
            <p><strong>Durasi:</strong> {{ $bid->durasi }} hari</p>
            <p><strong>Proposal:</strong> {{ $bid->proposal }}</p>
            <p><strong>Pemenang:</strong> {{ $bid->is_winner ? 'Ya' : 'Tidak' }}</p>

            @if ($bid->is_winner && auth()->id() == $project->client_id)
                <hr>
                <h4>Rating Developer</h4>

                @php
                    $existingRating = $project->ratings->firstWhere(
                        'developer_id',
                        $bid->developer_id
                    );
                @endphp

                @if ($existingRating)
                    <p>Rating: {{ $existingRating->rating }}/5 ⭐</p>
                    <p>Komentar: {{ $existingRating->komentar ?? '-' }}</p>
                    <p>Developer ini sudah kamu beri rating.</p>
                @else
                    <form action="{{ route('ratings.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <input type="hidden" name="developer_id" value="{{ $bid->developer_id }}">

                        <label>Berikan Rating:</label>
                        <select name="rating" required>
                            <option value="">Pilih Rating</option>
                            <option value="5">5 - Sangat Baik ⭐⭐⭐⭐⭐</option>
                            <option value="4">4 - Baik ⭐⭐⭐⭐</option>
                            <option value="3">3 - Cukup ⭐⭐⭐</option>
                            <option value="2">2 - Kurang ⭐⭐</option>
                            <option value="1">1 - Sangat Kurang ⭐</option>
                        </select>

                        <br><br>

                        <label>Komentar:</label>
                        <textarea name="komentar" maxlength="1000"
                            placeholder="Tulis komentar untuk developer..."></textarea>

                        <br><br>

                        <button type="submit">Kirim Rating</button>
                    </form>
                @endif
            @endif
        </div>
    @endforeach

    <a href="{{ route('projects.index') }}">Kembali</a>
</body>
</html>
