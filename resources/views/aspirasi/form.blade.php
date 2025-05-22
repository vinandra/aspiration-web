
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Aspirasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .navbar {
            margin-bottom: 30px;
        }
        .card {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border: none;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            padding: 15px 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Sistem Aspirasi</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register.resident') }}">Register</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Sampaikan Aspirasi Anda</div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if (session('warning'))
                            <div class="alert alert-warning" role="alert">
                                {{ session('warning') }}
                                <a href="{{ route('login') }}" class="btn btn-sm btn-primary mt-2">Login</a>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('aspirasi.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row mb-3">
                                <label for="nik" class="col-md-4 col-form-label text-md-end">NIK</label>
                                <div class="col-md-6">
                                    <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik') }}" required>
                                    @error('nik')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="title" class="col-md-4 col-form-label text-md-end">Judul</label>
                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="kategori" class="col-md-4 col-form-label text-md-end">Kategori</label>
                                <div class="col-md-6">
                                    <select id="kategori" class="form-control @error('kategori') is-invalid @enderror" name="kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="Pembangunan" {{ old('kategori') == 'Pembangunan' ? 'selected' : '' }}>Pembangunan</option>
                                        <option value="Kesejahteraan Sosial" {{ old('kategori') == 'Kesejahteraan Sosial' ? 'selected' : '' }}>Kesejahteraan Sosial</option>
                                        <option value="Ketentraman dan Ketertiban Umum" {{ old('kategori') == 'Ketentraman dan Ketertiban Umum' ? 'selected' : '' }}>Ketentraman dan Ketertiban Umum</option>
                                        <option value="Pengelolaan Teknologi Informasi" {{ old('kategori') == 'Pengelolaan Teknologi Informasi' ? 'selected' : '' }}>Pengelolaan Teknologi Informasi</option>
                                    </select>
                                    @error('kategori')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="content" class="col-md-4 col-form-label text-md-end">Isi Aspirasi</label>
                                <div class="col-md-6">
                                    <textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content" rows="5" required>{{ old('content') }}</textarea>
                                    @error('content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="photo_proof" class="col-md-4 col-form-label text-md-end">Bukti Foto (Opsional)</label>
                                <div class="col-md-6">
                                    <input id="photo_proof" type="file" class="form-control @error('photo_proof') is-invalid @enderror" name="photo_proof">
                                    @error('photo_proof')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Kirim Aspirasi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

