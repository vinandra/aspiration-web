<!-- Loading Screen -->
<div id="loading">
    <h1 id="loading-text"></h1>
  </div>
  
  <!-- Style -->
  <style>
    #loading {
      position: fixed;
      width: 100vw;
      height: 100vh;
      background: white;
      color: #C0392B;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: sans-serif;
      z-index: 9999;
    }
  
    #loading-text {
      font-size: 2rem;
      border-right: 3px solid #C0392B;
      white-space: nowrap;
      overflow: hidden;
    }
  </style>
  
  <!-- Script -->
  <script>
    const text = 'Memuat, Harap Tunggu...';
    const speed = 150;
    const pause = 1000;
  
    let i = 0;
    let isDeleting = false;
    const el = document.getElementById('loading-text');
  
    function typeLoop() {
      if (isDeleting) {
        el.textContent = text.substring(0, i--);
      } else {
        el.textContent = text.substring(0, i++);
      }
  
      if (!isDeleting && i > text.length) {
        isDeleting = true;
        setTimeout(typeLoop, pause);
      } else if (isDeleting && i === 0) {
        isDeleting = false;
        setTimeout(typeLoop, speed);
      } else {
        setTimeout(typeLoop, speed);
      }
    }
  
    typeLoop();
  
    // Hilangkan loading setelah 10 detik
    setTimeout(() => {
      document.getElementById('loading').style.display = 'none';
    }, 4000); // 10000 ms = 10 detik
  </script>
  