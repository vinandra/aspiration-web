<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Register Kelurahan Pendrikan Kidul">
    <meta name="author" content="">

    <title>Aspirasi - Register Akun</title>

    <!-- Fonts & Icons -->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            margin: 0;
            font-family: 'Nunito', sans-serif;
            background-color: #ffffff;
        }

        main {
            min-height: 100vh;
            background: url('{{ asset('images/carousel/image25.png') }}') center/cover no-repeat;
            padding-top: 100px;
            padding-bottom: 50px;
        }

        .card-body {
            background-color: rgba(255, 255, 255, 0.95);
            color: #333;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #c0392b;
        }

        .btn-primary {
            background-color: #c0392b;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #922b21;
        }

        .header-contact {
            background-color: #c0392b;
            color: white;
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .card-header img {
            max-height: 80px;
        }

        .text-center a {
            color: #c0392b;
        }

        .text-center a:hover {
            color: #922b21;
        }

        .text-primary {
            color: #c0392b !important;
        }
    </style>
</head>

<body>

    @if ($errors->any())
        <script>
            Swal.fire({
                title: "Error!",
                text: "@foreach($errors->all() as $error) {{ $error }}{{ $loop->last ? '.' : ', ' }} @endforeach",
                icon: "error"
            });
        </script>
    @endif

    <!-- Kontak Atas -->
    <div class="header-contact d-flex justify-content-between px-4 py-2 align-items-center">
        <div><i class="bi bi-telephone-fill me-2"></i>024-3553232</div>
        <div><i class="bi bi-envelope-fill me-2"></i>pendrikankidul2@gmail.com</div>
    </div>

    <!-- Konten Register -->
    <main class="d-flex justify-content-center align-items-center">
        <div class="card" style="max-width: 550px; width: 100%;">
            <div class="card-header text-center bg-white border-0">
                <img src="{{ asset('images/carousel/pendrikan_kidul.png') }}" alt="Logo" style="max-height: 80px;" class="mb-2">
                <h4 class="text-primary fw-bold mb-0">KELURAHAN PENDRIKAN KIDUL</h4>
            </div>
            <div class="card-body px-4 py-4">
                <h5 class="text-center mb-4">Registrasi Akun</h5>
                <form class="user" action="{{ route('register.account.post', ['resident_id' => $resident->id]) }}" method="POST" enctype="multipart/form-data" onsubmit="const submitBtn = document.getElementById('submitBtn'); submitBtn.disabled = true; submitBtn.textContent = 'Loading...';">
                    @csrf
                    @method('POST')

                    <div class="mb-3">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="inputPassword" name="password" placeholder="Masukkan Password" required>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="inputPhoto" class="form-label">Foto Profil</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="inputPhoto" name="photo" accept="image/*">
                        @error('photo')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <button id="submitBtn" type="submit" class="btn btn-primary w-100">Simpan</button>
                </form>
                <div class="text-center mt-3">
                    <a href="/login" class="text-dark small">Sudah punya akun? Login</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
