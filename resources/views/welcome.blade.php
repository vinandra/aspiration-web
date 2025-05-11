@include('layouts.loading')
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
        padding-top: 80px ;
      }
      .navbar a:hover{
        color: #C0392B !important;
      }
    </style>
  </head>
  <body style="background-color: #D7D7D7;">
   {{-- navbar  --}}
    @include('layouts.navbar1')

    <!-- Carousel Section -->
  <div id="carouselExampleAutoplay" class="carousel slide mt-5" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="{{ asset('images/carousel/gambar1.jpg') }}" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('images/carousel/gambar2.jpg') }}" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('images/carousel/gambar3.jpg') }}" class="d-block w-100" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplay" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplay" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

    <!-- Konten Utama -->
    <main class="container my-5">
      <h3 class="text-center mb-3">KELURAHAN PENDRIKAN KIDUL</h3>
      <p class="text-center text-danger fw-semibold mb-4">
        Selamat Datang di Website Portal Kelurahan Pendrikan Kidul
      </p>

      <!-- Aspirasi yang Dipublikasikan -->
      <div class="card shadow p-4 rounded-4 mt-5 mx-auto" style="max-width: 900px;">
        <h4 class="text-center mb-4 text-danger fw-semibold">Aspirasi yang Dipublikasikan</h4>
        @forelse ($publishedComplaints as $complaint)
          <div class="mb-3">
            <h5>{{ $complaint->title }}</h5>
            <p>{{ $complaint->content }}</p>
            <span class="badge badge-secondary">{{ $complaint->kategori }}</span>
            <span class="badge badge-info">{{ $complaint->report_date_label }}</span>
            @if ($complaint->photo_proof)
              <div class="mt-2">
                <a href="{{ asset('storage/' . $complaint->photo_proof) }}" target="_blank" rel="noopener noreferrer">
                  <img src="{{ asset('storage/' . $complaint->photo_proof) }}" alt="Foto Bukti" style="max-width:300px;">
                </a>
              </div>
            @endif
            <a href="{{ route('complaint.edit', $complaint->id) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-pen"></i>
            </a>
          </div>
        @empty
          <p class="text-center">Tidak ada aspirasi yang dipublikasikan saat ini.</p>
        @endforelse
      </div>

      <!-- Struktur Section -->
      <div class="card shadow p-4 rounded-4 mt-5 mx-auto" style="max-width: 900px;">
        <div class="ratio ratio-16x9 rounded">
          <img src="{{ asset('images/carousel/Struktur organisasi.png') }}" title="Strukrur Organisasi"></img>
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
    @include('layouts.footer')
    <!-- End of Footer -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
