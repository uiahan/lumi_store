
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
<script src="https://unpkg.com/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

<style>
  /* Efek untuk navbar pada saat di-scroll */
  .navbar {
    transition: background-color 0.3s, backdrop-filter 0.3s;
  }

  /* Kelas untuk navbar yang akan berubah ketika di-scroll */
  .navbar-scrolled {
    background-color: rgba(255, 255, 255, 0.7) !important; /* Transparan */
    backdrop-filter: blur(9px); /* Efek blur */
  }
</style>

<nav class="navbar navbar-expand-lg py-3 shadow sticky-top px-5" id="navbar" style="background-color: #fff;">
  <div class="container-fluid px-5">
    <a class="navbar-brand fs-3 fw-bold" href="#" style="font-family: cursive; color: #2E5077;">
      <i class="fa-solid fa-shop"></i>Lumi<span>Store</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    </div>
  </div>
</nav>

<script>
  // Mendapatkan elemen navbar
  const navbar = document.getElementById('navbar');

  // Event listener untuk scroll
  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) { // Jika halaman discroll lebih dari 50px
      navbar.classList.add('navbar-scrolled'); // Tambahkan kelas untuk efek scroll
    } else {
      navbar.classList.remove('navbar-scrolled'); // Keluarkan kelas ketika scroll kembali ke atas
    }
  });
</script>
