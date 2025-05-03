<!-- Modal Selamat Datang -->
<div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="welcomeModalLabel">Selamat Datang {{ auth()->user()->name }}</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
            <img src="{{ asset('images/carousel/pendrikan_kidul.png') }}" alt="" style="max-width: 4cm;">
          Selamat datang di website resmi Kelurahan Pendrikan Kidul. Silakan jelajahi layanan kami.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Bootstrap JS (Wajib disisipkan di akhir sebelum penutup </body>) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Script untuk menampilkan modal otomatis saat halaman dimuat -->
  <script>
    window.addEventListener('load', function () {
      var welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
      welcomeModal.show();
    });
  </script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
