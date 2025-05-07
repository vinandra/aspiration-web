<!-- Loading Screen -->
<div id="loading">
  <div class="bar"></div>
  <div class="bar"></div>
  <div class="bar"></div>
</div>

<!-- Style -->
<style>
  #loading {
    position: fixed;
    width: 100vw;
    height: 100vh;
    background: white;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px; /* Jarak antar batang */
    z-index: 9999;
    overflow: hidden;
  }

  .bar {
    width: 10px;            /* Lebar batang */
    height: 40px;           /* Tinggi awal batang */
    background-color: #C0392B; /* Warna merah Pixar */
    animation: bounce 1s infinite ease-in-out;
    border-radius: 3px;     /* Sedikit membulatkan sudut */
  }

  .bar:nth-child(2) {
    animation-delay: 0.2s;
  }

  .bar:nth-child(3) {
    animation-delay: 0.4s;
  }

  @keyframes bounce {
    0%, 100% {
      transform: scaleY(1);
    }
    50% {
      transform: scaleY(1.8); /* Memanjangkan batang secara vertikal */
    }
  }
</style>

<!-- Script -->
<script>
  // Hilangkan loading setelah 4 detik
  setTimeout(() => {
    document.getElementById('loading').style.display = 'none';
  }, 4000);
</script>
