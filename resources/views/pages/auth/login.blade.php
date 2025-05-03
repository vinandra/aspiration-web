<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Aspirasi - Login</title>
    @include('layouts.loading')

    <!-- Fonts & Icons -->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-image: url('{{ asset('images/carousel/semarang.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .card-body{
            background-image: url('{{ asset('images/carousel/semarang_malam.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .navbar a:hover {
            color: #C0392B;
        }

        .login-card {
            max-width: 450px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
           
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #4e73df;
        }

        .btn-primary {
            background-color: #4e73df;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
        }
    </style>
</head>

<body>

    @if ($errors->any())
        <script>
            Swal.fire({
                title: "Error!",
                text: "@foreach($errors->all() as $error) {{ $error }}{{ $loop->last ? '.' : ',' }} @endforeach",
                icon: "error"
            });
        </script>
    @endif

    <main class="login-container">
        <div class="card o-hidden border-0 login-card">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/carousel/pendrikan_kidul.png') }}" alt="logo kelurahan pendrikan kidul" style="max-width: 4cm ">
                    <h1 class="h4 text-gray-900">Selamat Datang Kembali!</h1>
                </div>
                <form class="user" action="/login" method="POST"
                    onsubmit="const submitBtn = document.getElementById('submitBtn'); submitBtn.disabled = true; submitBtn.textContent = 'Loading...' ">
                    @csrf
                    @method('POST')
                    <div class="form-group mb-3">
                        <input type="email" class="form-control form-control-user" id="inputEmail" name="email"
                            placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group mb-4">
                        <input type="password" class="form-control form-control-user" id="inputPassword"
                            name="password" placeholder="Password">
                    </div>
                    <button id="submitBtn" type="submit" class="btn btn-primary btn-user btn-block w-100 mb-3">
                        Login
                    </button>
                </form>
                <div class="text-center">
                    <a class="small" href="/register">Buat akun baru!</a>
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
