<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Quote</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background: url('https://source.unsplash.com/1600x900/?inspiration') no-repeat center center fixed;
            background-size: cover;
            color: #333;
            font-family: 'Arial', sans-serif;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        h1, h3 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .btn-secondary, .btn-info, .btn-success {
            border: none;
            transition: all 0.3s ease;
        }
        .btn-secondary {
            background-color: #95a5a6;
        }
        .btn-secondary:hover {
            background-color: #7f8c8d;
            transform: translateY(-2px);
        }
        .btn-info {
            background-color: #3498db;
            padding: 10px 20px;
            font-size: 16px;
        }
        .btn-info:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        .btn-success {
            background-color: #2ecc71;
        }
        .btn-success:hover {
            background-color: #27ae60;
            transform: translateY(-2px);
        }
        .input-group {
            margin-bottom: 20px;
        }
        .input-group .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        .input-group .btn-info {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
        table {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
        }
        th {
            background-color: #3498db;
            color: #fff;
            text-align: center;
        }
        td {
            vertical-align: middle;
            text-align: center;
            padding: 15px;
        }
        tr:hover {
            background-color: #ecf0f1;
            transition: all 0.3s ease;
        }
        .btn-sm {
            padding: 5px 10px;
        }
        .decoration {
            position: absolute;
            top: 20px;
            right: 20px;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <!-- Dekorasi (Ikon atau Gambar Kecil) -->
    <img src="https://img.icons8.com/ios-filled/50/3498db/quote.png" alt="Quote Icon" class="decoration">

    <div class="container mt-5">
        <h1>Add Quote</h1>
        <a href="{{ route('quotes.index') }}" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>

        <!-- Form cari author (Diperbarui) -->
        <form action="{{ route('quotes.searchAuthor') }}" method="POST" class="mb-4">
            @csrf
            <div class="input-group">
                <input type="text" name="author" class="form-control" placeholder="Search author (e.g., Steve Jobs)" required aria-label="Search author">
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </form>

        <!-- Tampilkan rekomendasi -->
        @if (!empty($recommendations))
            <h3>Choose a Quote</h3>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Quote</th>
                        <th>Author</th>
                        <th>Religion</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recommendations as $recommendation)
                        <tr>
                            <td>{{ $recommendation['phrase'] }}</td>
                            <td>{{ $recommendation['author'] }}</td>
                            <td>{{ $recommendation['religion'] ? 'Religious' : 'Non-Religious' }}</td>
                            <td>
                                <form action="{{ route('quotes.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="phrase" value="{{ $recommendation['phrase'] ?? '' }}">
                                    <input type="hidden" name="author" value="{{ $recommendation['author'] ?? '' }}">
                                    <input type="hidden" name="religion" value="{{ $recommendation['religion'] ?? 0 }}">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-plus"></i> Add to Dashboard
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Form custom quote -->
        <h3>Or Add Your Own Quote</h3>
        <form action="{{ route('quotes.store') }}" method="POST" class="mb-3">
            @csrf
            <div class="mb-3">
                <label for="phrase" class="form-label">Your Quote</label>
                <input type="text" name="phrase" id="phrase" class="form-control" placeholder="Your quote" required>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Author (Optional)</label>
                <input type="text" name="author" id="author" class="form-control" placeholder="Author (optional)">
            </div>
            <div class="mb-3">
                <label for="religion" class="form-label">Religion</label>
                <select name="religion" id="religion" class="form-control">
                    <option value="0">Non-Religious</option>
                    <option value="1">Religious</option>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add to Dashboard
                </button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
