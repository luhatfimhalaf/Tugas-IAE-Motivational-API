<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Quotes Dashboard</title>
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
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #3498db;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        .input-group {
            margin-bottom: 20px;
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
        .btn-warning, .btn-danger {
            margin: 0 5px;
            padding: 5px 10px;
            transition: all 0.3s ease;
        }
        .btn-warning {
            background-color: #f1c40f;
            border: none;
        }
        .btn-warning:hover {
            background-color: #d4ac0d;
            transform: translateY(-2px);
        }
        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
        }
        .pagination {
            justify-content: center;
        }
        .modal-content {
            border-radius: 10px;
        }
        .modal-header {
            background-color: #3498db;
            color: #fff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .modal-footer .btn-primary {
            background-color: #3498db;
        }
        .modal-footer .btn-primary:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>My Quotes Dashboard</h1>
        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('quotes.create') }}" class="btn btn-primary">Add New Quote</a>
            <div class="input-group w-50">
                <input type="text" name="keyword" class="form-control" placeholder="Search your quotes..." required>
                <button type="submit" class="btn btn-info" formaction="{{ route('quotes.search') }}">Search</button>
            </div>
        </div>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Quote</th>
                    <th>Author</th>
                    <th>Religion</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($quotes as $quote)
                    <tr>
                        <td>{{ $quote->phrase }}</td>
                        <td>{{ $quote->author }}</td>
                        <td>{{ $quote->religion ? 'Religious' : 'Non-Religious' }}</td>
                        <td>
                            <!-- Tombol Edit (Memicu Modal) -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $quote->id }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <!-- Tombol Delete -->
                            <form action="{{ route('quotes.destroy', $quote) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal untuk Edit -->
                    <div class="modal fade" id="editModal{{ $quote->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $quote->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $quote->id }}">Edit Quote</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('quotes.update', $quote) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="phrase{{ $quote->id }}" class="form-label">Quote</label>
                                            <input type="text" name="phrase" id="phrase{{ $quote->id }}" value="{{ $quote->phrase }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="author{{ $quote->id }}" class="form-label">Author</label>
                                            <input type="text" name="author" id="author{{ $quote->id }}" value="{{ $quote->author }}" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="religion{{ $quote->id }}" class="form-label">Religion</label>
                                            <select name="religion" id="religion{{ $quote->id }}" class="form-control">
                                                <option value="0" {{ $quote->religion == 0 ? 'selected' : '' }}>Non-Religious</option>
                                                <option value="1" {{ $quote->religion == 1 ? 'selected' : '' }}>Religious</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No quotes in your dashboard yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $quotes->links() }}
    </div>

    <!-- Bootstrap JS dan Font Awesome JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
