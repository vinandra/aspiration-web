<style>
    .navbar.navbar-atas .navbar-brand:hover,
    .navbar.navbar-atas .nav-link:hover {
        color: white !important;
        text-decoration: underline;
        transition: color 0.3s ease;
    }

    .navbar.navbar-bawah .navbar-brand:hover,
    .navbar.navbar-bawah .nav-link:hover {
        color: #C0392B !important;
        transition: color 0.3s ease;
    }
</style>

<nav class="navbar navbar-expand-lg fixed-top navbar-atas" style="background-color:#C0392B;">
    <div class="container-fluid text-white">
        <a class="navbar-brand text-white" href="#">
            <i class="bi bi-telephone-fill me-2"></i>024-3553232
        </a>
        <a class="navbar-brand text-white" href="/login">
            <i class="bi bi-box-arrow-in-right me-2"></i>Login
        </a>
    </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow fixed-top navbar-bawah" style="top: 56px;">
    <div class="container">
        <a class="navbar-brand" href="{{ route('welcome') }}">
            <img src="{{ asset('images/carousel/pendrikan_kidul.png') }}" alt="Logo" style="height: 50px;">
        </a>
        <button class="navbar-toggler bg-danger" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
            aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarMain">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item px-3">
                    <a class="nav-link" aria-current="page" href="{{ route('welcome') }}">Beranda</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="https://pendrikankidul.semarangkota.go.id/">Pendrikan Kidul</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="{{ route('aspirasi.form') }}">Aspirasi</a>
                </li>
            </ul>
        </div>
    </div>
</nav>