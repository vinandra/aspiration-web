<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kelurahan Pendrikan Kidul</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
      body {
        padding-top: 112px;
      }
      .navbar a:hover{
        color: #C0392B;
      }
    </style>
  </head>
  <body style="background-color: #D7D7D7;">
    <!-- Nav-1: Kontak -->
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color:#C0392B;">
      <div class="container-fluid text-white">
        <a class="navbar-brand text-white" href="#">
          <i class="bi bi-telephone-fill me-2"></i>024-3553232
        </a>
        <a class="navbar-brand text-white" href="mailto:pendrikankidul2@gmail.com">
          <i class="bi bi-envelope-fill me-2"></i>Email
        </a>
      </div>
    </nav>

    <!-- Nav-2: Menu Utama -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow fixed-top" style="top: 56px;">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img src="https://via.placeholder.com/100x50?text=Logo" alt="Logo" style="height: 50px;">
        </a>
        <button class="navbar-toggler bg-danger" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
          aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarMain">
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item px-3">
              <a class="nav-link active" aria-current="page" href="#">Beranda</a>
            </li>
            <li class="nav-item px-3">
              <a class="nav-link" href="https://pendrikankidul.semarangkota.go.id/">Pendrikan Kidul</a>
            </li>
            <li class="nav-item px-3">
              <a class="nav-link" href="#">Aspirasi</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Konten Utama -->
    <main class="container my-5">
      <h3 class="text-center mb-3">KELURAHAN PENDRIKAN KIDUL</h3>
      <p class="text-center text-danger fw-semibold mb-4">
        Selamat Datang di Website Portal Kelurahan Pendrikan Kidul
      </p>

      <!-- Sambutan Lurah -->
      <div class="card shadow p-4 rounded-4 mx-auto" style="max-width: 900px;">
        <div class="row g-4 align-items-center">
          <div class="col-md-4 text-center">
            <img src="https://via.placeholder.com/200" alt="Kepala Organisasi" class="img-fluid rounded-circle shadow" style="max-width: 200px;">
            <h5 class="mt-3">Nama Kepala</h5>
            <p class="text-muted mb-0">Lurah</p>
          </div>
          <div class="col-md-8">
            <h4 class="mb-3">Sambutan Lurah</h4>
            <p class="text-justify">
              Assalamualaikum Warahmatullahi Wabarakaatuh,
              <br><br>
              Pertama-tama kami panjatkan puji syukur atas limpahan rahmat-Nya, sehingga situs web 
              <a href="http://www.pendrikankidul.semarangkota.go.id" target="_blank">www.pendrikankidul.semarangkota.go.id</a> 
              ini dapat kami selesaikan dengan baik. Tak lupa kami ucapkan terima kasih kepada jajaran Dinas Komunikasi, Informatika, Statistik dan Persandian Kota Semarang.
              <br><br>
              Situs ini sebagai wujud komitmen kami dalam memberikan informasi seluas-luasnya kepada masyarakat. Kami berharap masyarakat dapat mengikuti informasi terbaru secara berkala.
              <br><br>
              Wassalamualaikum warahmatullahi wabarakaatuh.
            </p>
          </div>
        </div>
      </div>

      <!-- YouTube Section -->
      <div class="card shadow p-4 rounded-4 mt-5 mx-auto" style="max-width: 900px;">
        <h4 class="text-center mb-4 text-danger fw-semibold">Youtube Kelurahan Pendrikan Kidul</h4>
        <div class="ratio ratio-16x9 rounded">
          <iframe src="https://www.youtube.com/embed/YTHsg4W-Thg" title="YouTube video" allowfullscreen></iframe>
        </div>
      </div>
    </main>

    <!-- Footer -->
    <!-- Footer -->
    @include('layouts.footer')
    <!-- End of Footer -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
