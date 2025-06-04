<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Register Kelurahan Pendrikan Kidul">
    <meta name="author" content="">

    <title>Aspirasi - Register</title>

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

        .card-header img {
            max-height: 80px;
        }

        .text-center a {
            color: #c0392b;
        }

        .text-center a:hover {
            color: #922b21;
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

        .text-primary {
            color: #c0392b !important;
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
        <div class="card" style="max-width: 700px; width: 100%;">
            <div class="card-header text-center bg-white border-0">
                <img src="{{ asset('images/carousel/pendrikan_kidul.png') }}" alt="Logo" style="max-height: 80px;" class="mb-2">
                <h4 class="text-primary fw-bold mb-0">REGISTRASI</h4>
            </div>
            <div class="card-body px-4 py-4">
                <form class="user" action="{{ route('register.resident.post') }}" method="POST" enctype="multipart/form-data" onsubmit="const submitBtn = document.getElementById('submitBtn'); submitBtn.disabled = true; submitBtn.textContent = 'Loading...';">
                    @csrf
                    @method('POST')

                    <div class="mb-3">
                        <label for="inputName" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" name="name" placeholder="Masukkan Nama Lengkap" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="inputnik" class="form-label">Masukkan NIK</label>
                        <input type="text" class="form-control @error('nik') is-invalid @enderror" id="inputnik" name="nik" placeholder="Masukkan NIK" required>
                        @error('nik')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="inputGender" class="form-label">Jenis Kelamin</label>
                        <select class="form-control @error('gender') is-invalid @enderror" id="inputGender" name="gender" required>
                            <option value="male">Laki-laki</option>
                            <option value="female">Perempuan</option>
                        </select>
                        @error('gender')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="inputBirthDate" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="inputBirthDate" name="birth_date" required>
                        @error('birth_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="inputBirthPlace" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control @error('birth_place') is-invalid @enderror" id="inputBirthPlace" name="birth_place" placeholder="Masukkan Tempat Lahir" required>
                        @error('birth_place')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="inputAddress" class="form-label">Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="inputAddress" name="address" rows="3" placeholder="Masukkan Alamat" required></textarea>
                        @error('address')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="inputReligion" class="form-label">Agama</label>
                        <input type="text" class="form-control @error('religion') is-invalid @enderror" id="inputReligion" name="religion" placeholder="Masukkan Agama">
                        @error('religion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="inputMaritalStatus" class="form-label">Status Pernikahan</label>
                        <select class="form-control @error('marital_status') is-invalid @enderror" id="inputMaritalStatus" name="marital_status" required>
                            <option value="single">Belum Menikah</option>
                            <option value="married">Menikah</option>
                            <option value="divorced">Cerai</option>
                            <option value="widowed">Janda/Duda</option>
                        </select>
                        @error('marital_status')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="inputOccupation" class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control @error('occupation') is-invalid @enderror" id="inputOccupation" name="occupation" placeholder="Masukkan Pekerjaan">
                        @error('occupation')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="inputPhone" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="inputPhone" name="phone" placeholder="Masukkan Nomor Telepon">
                        @error('phone')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="inputStatus" class="form-label">Status</label>
                        <select class="form-control @error('status') is-invalid @enderror" id="inputStatus" name="status" required>
                            <option value="active">Aktif</option>
                            <option value="moved">Pindah</option>
                            <option value="deceased">Meninggal</option>
                        </select>
                        @error('status')
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

    <!-- Aspirasi Table Read More Toggle (Example, place this in table page for admin) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-read-more').forEach(btn => {
                btn.addEventListener('click', function () {
                    const parent = this.closest('td');
                    parent.querySelector('.short-content').classList.toggle('d-none');
                    parent.querySelector('.full-content').classList.toggle('d-none');
                    this.remove(); // optional: remove button after expanding
                });
            });
        });
    </script>

</body>

</html>
