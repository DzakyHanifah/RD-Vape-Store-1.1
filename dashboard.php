<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="./asset/Logo No Bg.PNG"> <!-- icon pada tab -->
    <style>
        /* Atur scrollbar untuk browser berbasis WebKit */
    /* Mengatur scrollbar vertikal */
::-webkit-scrollbar {
    width: 4px; /* Lebar scrollbar vertikal */
}

/* Mengatur track scrollbar vertikal */
::-webkit-scrollbar-track {
    background: #000; /* Warna hitam */
    border-radius: 2px; /* Agar lebih lembut dan minimalis */
}

/* Mengatur thumb scrollbar vertikal */
::-webkit-scrollbar-thumb {
    background-color: #FCA311; /* Warna merah */
    border-radius: 2px; /* Sudut yang lebih lembut */
}

/* Efek hover pada thumb scrollbar vertikal */
::-webkit-scrollbar-thumb:hover {
    background-color: #FF5555; /* Sedikit pencerahan merah ketika hover */
}

/* Mengatur scrollbar horizontal */
::-webkit-scrollbar-horizontal {
    height: 2px; /* Tinggi scrollbar horizontal */
}

/* Mengatur track scrollbar horizontal */
::-webkit-scrollbar-track-horizontal {
    background: #000; /* Warna hitam */
    border-radius: 10px; /* Agar lebih lembut dan minimalis */
}

/* Mengatur thumb scrollbar horizontal */
::-webkit-scrollbar-thumb-horizontal {
    background-color: #FCA311; /* Warna merah */
    border-radius: 2px; /* Sudut yang lebih lembut */
}

/* Efek hover pada thumb scrollbar horizontal */
::-webkit-scrollbar-thumb-horizontal:hover {
    background-color: #FF5555; /* Sedikit pencerahan merah ketika hover */
}

    :root {
            --black: #000000;
            --oxford-blue: #14213d;
            --orange: #f77f00;
            --platinum: #e5e5e5;
            --white: #ffffff;
        }
        body {
            background-color: #121212;
            /* Oxford Blue */
            color: #ffffff;
            /* White */
            font-family: Arial, sans-serif;
        }
        /* Navbar */
        .navbar {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 0 20px;
                    background-color: var(--oxford-blue);
                    color: var(--white);
                    height: 60px;
                    position: relative;
                    border-bottom: 5px solid var(--orange); /* Opsional: garis bawah */
                }

                .navbar img {
                    height: 40px;
                }

                .navbar h1 {
                    font-size: 20px;
                    margin: 0;
                    position: absolute;
                    left: 50%;
                    transform: translateX(-50%);
                    color: var(--white);
                }

                .navbar button {
                    background-color: var(--orange);
                    color: var(--white);
                    border: none;
                    padding: 10px 15px;
                    cursor: pointer;
                    border-radius: 5px;
                    font-size: 16px;
                    transition: background-color 0.3s ease;
                }

                .navbar button:hover {
                    background-color: #e67600;
                }

                /* Sidebar */
                .sidebar {
                    position: fixed;
                    top: 0;
                    right: -100%;
                    width: 200px;
                    height: 100%;
                    background-color: var(--black);
                    color: var(--white);
                    padding: 20px;
                    box-shadow: -5px 0 10px rgba(0, 0, 0, 0.2);
                    transition: right 0.3s ease;
                    z-index: 1000;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                    border: 5px solid #FCA311; /* Orange */
                }

                .sidebar.active {
                    right: 0;
                }

                
                .sidebar h2 {
            text-align: center; /* Pusatkan teks secara horizontal */
            margin: 0 auto; /* Hapus margin tambahan */
            padding-bottom: 10px; /* Tambahkan jarak ke bawah untuk estetika */
            border-bottom: 2px solid var(--orange); /* Opsional: garis bawah untuk membedakan judul */
        }


        .sidebar a {
            display: block;
            margin: 15px 0;
            padding: 10px;
            color: var(--white);
            text-decoration: none;
            border-radius: 5px;
            background-color: var(--oxford-blue);
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #243a5e;
        }

        .sidebar .logout {
            background-color: var(--orange);
        }

        .sidebar .logout:hover {
            background-color: #e67600;
        }

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 999;
        }

        .overlay.active {
            display: block;
        }

        /* Tambahkan gaya untuk sidebar-footer */
        .sidebar-footer {
            position: absolute; /* Pastikan footer berada di posisi absolut relatif terhadap sidebar */
            bottom: 70px; /* Jarak dari bagian bawah sidebar */
            left: 50%;
            transform: translateX(-50%);
            text-align: center; /* Agar teks dan logo terpusat */
        }

        .sidebar-footer img {
            display: block;
            margin: 0 auto;
            width: 100px; /* Sesuaikan ukuran logo */
            height: auto;
        }

        .sidebar-footer p {
            margin: 5px 0 0;
            font-size: 14px;
            color: var(--white);
        }
/* carausel top */
        .carousel-inner img {
            width: 100%;
            height: 445px; /* Sesuai dimensi tinggi gambar */
            object-fit: cover;
            border-bottom: 5px solid var(--orange); /* Opsional: garis bawah untuk membedakan judul */
        }

        /* kategori */
        .category-icon {
    width: 80px;  /* Set width */
    height: 80px; /* Set height */
    object-fit: contain; /* Ensure the image maintains its aspect ratio */
}

/* Effect for hover on category card */
.category-card:hover {
    transform: scale(1.1); /* Membesarkan sedikit saat hover */
    background-color: #f0f0f0; /* Warna latar belakang saat hover */
    transition: all 0.3s ease-in-out; /* Transisi efek hover */
}

/* Optional: Menambahkan efek active saat kategori ditekan */
.category-card:active {
    transform: scale(0.95); /* Efek memperkecil saat kategori ditekan */
    background-color: #ddd; /* Warna latar belakang saat kategori ditekan */
}

/* Menambahkan border merah dan jarak antar kartu */
.category-card {
    border: 2px solid red; /* Garis border merah */
    margin-right: 20px; /* Memberikan jarak antar kartu */
    margin-bottom: 20px; /* Memberikan jarak bawah antar kartu */
}
/* border pada card produk */
.bordero{
    border: 5px solid #FCA311; /* Orange */
}
.dborder{
    border-bottom: 5px solid var(--orange); /* Opsional: garis bawah untuk membedakan judul */
}

        /* bagian bawah */
        footer {
            text-align: center;
            margin-top: 2rem;
            color: #ffb400;
            /* Orange */
            font-size: 14px;
        }
    </style>
  </head>
  <body>
  <div class="navbar">
        <img src="./asset/Logo No Bg.PNG" alt="Logo">
        <h1><strong>RD Vape Store</strong></h1>
        <button id="sidebarToggle">Menu</button>
    </div>

    <!-- Sidebar -->
    <div class="overlay" id="overlay"></div>
    <div class="sidebar" id="sidebar">
        <div>
            <h2>Menu</h2>
            <!-- <a href="javascript:void(0)" onclick="scrollToReport()">Unduh Laporan</a> -->
            <!-- <a href="javascript:void(0)" onclick="scrollToVerification()">Verifikasi Barang Baru</a> -->
            <a href="javascript:void(0)" class="logout" onclick="logout()">Logout</a>
        </div>
        <div class="sidebar-footer">
            <img src="./asset/Logo No Bg.PNG" alt="Logo Sidebar">
            <p>Designed by <strong>Dzaky Hanifah</strong></p>
            
        </div>
    </div>

    <!-- carausel -->
<div id="carouselExample" class="carousel slide " data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="./asset/carausel vape/143144_slider.png" class="d-block w-100" alt="Image 1">
        </div>
        <div class="carousel-item">
          <img src="./asset/carausel vape/154183_slider.png" class="d-block w-100" alt="Image 2">
        </div>
        <div class="carousel-item">
          <img src="./asset/carausel vape/164980_slider.png" class="d-block w-100" alt="Image 3">
        </div>
        <div class="carousel-item">
          <img src="./asset/carausel vape/563890_slider.png" class="d-block w-100" alt="Image 4">
        </div>
        <div class="carousel-item">
          <img src="./asset/carausel vape/600877_slider.png" class="d-block w-100" alt="Image 5">
         </div> <!-- gggggg-->
        <div class="carousel-item">
          <img src="./asset/carausel vape/695450_slider.jpg" class="d-block w-100" alt="Image 6">
        </div>
        <div class="carousel-item">
          <img src="./asset/carausel vape/792779_slider.png" class="d-block w-100" alt="Image 7">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <!-- Kategori -->
    <section id="categories" class="py-1">
    <div class="container ">
        <h2 class="text-center text-white dborder">Categories</h2>
        <div class="row">
            <div class="col-12">
                <!-- Wrapper for horizontal scroll -->
                <div class="d-flex overflow-auto" style="scroll-snap-type: x mandatory;">
                    <!-- Category 1 -->
                    <div class="card mb-4 category-card" style="flex: 0 0 auto; width: 200px; scroll-snap-align: start;">
                        <div class="card-body text-center" style="cursor: pointer;">
                            <img src="./asset/Logo No Bg.PNG" alt="Category 1" class="category-icon mb-3">
                            <p class="card-text">Category 1.</p>
                        </div>
                    </div>

                    <!-- Category 2 -->
                    <div class="card mb-4 category-card" style="flex: 0 0 auto; width: 200px; scroll-snap-align: start;">
                        <div class="card-body text-center" style="cursor: pointer;">
                            <img src="./asset/kategori/85268_category.png" alt="Category 2" class="category-icon mb-3">
                            <h5 class="card-title">Category 2</h5>
                            
                        </div>
                    </div>

                    <!-- Category 3 -->
                    <div class="card mb-4 category-card" style="flex: 0 0 auto; width: 200px; scroll-snap-align: start;">
                        <div class="card-body text-center" style="cursor: pointer;">
                            <img src="./asset/kategori/78419_category.png" alt="Category 3" class="category-icon mb-3">
                            <h5 class="card-title">Category 3</h5>
                            
                        </div>
                    </div>

                    <!-- Category 4 -->
                    <div class="card mb-4 category-card" style="flex: 0 0 auto; width: 200px; scroll-snap-align: start;">
                        <div class="card-body text-center" style="cursor: pointer;">
                            <img src="./asset/kategori/728423_category.png" alt="Category 4" class="category-icon mb-3">
                            <h5 class="card-title">Category 4</h5>
                            
                        </div>
                    </div>
                    <div class="card mb-4 category-card" style="flex: 0 0 auto; width: 200px; scroll-snap-align: start;">
                        <div class="card-body text-center" style="cursor: pointer;">
                            <img src="./asset/kategori/714039_category.png" alt="Category 1" class="category-icon mb-3">
                            <p class="card-text">Category 1.</p>
                        </div>
                    </div>

                    <!-- Category 2 -->
                    <div class="card mb-4 category-card" style="flex: 0 0 auto; width: 200px; scroll-snap-align: start;">
                        <div class="card-body text-center" style="cursor: pointer;">
                            <img src="./asset/kategori/658033_category.png" alt="Category 2" class="category-icon mb-3">
                            <h5 class="card-title">Category 2</h5>
                        
                        </div>
                    </div>

                    <!-- Category 3 -->
                    <div class="card mb-4 category-card" style="flex: 0 0 auto; width: 200px; scroll-snap-align: start;">
                        <div class="card-body text-center" style="cursor: pointer;">
                            <img src="./asset/kategori/585120_category.png" alt="Category 3" class="category-icon mb-3">
                            <h5 class="card-title">Category 3</h5>
                            
                        </div>
                    </div>

                    <!-- Category 4 -->
                    <div class="card mb-4 category-card" style="flex: 0 0 auto; width: 200px; scroll-snap-align: start;">
                        <div class="card-body text-center" style="cursor: pointer;">
                            <img src="./asset/kategori/381428_category.png" alt="Category 4" class="category-icon mb-3">
                            <h5 class="card-title">Category 4</h5>
                            
                        </div>
                    </div>
                    <!-- More categories -->
                    
                    <!-- Add more categories here following the same structure -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- produk -->
<div class="container my-5">
<h2 class="text-center text-white dborder">Product</h2>
  <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-4">
    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/Black-1.webp" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>
    <!-- Repeat for each product -->
    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/1.png" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/336015_product.png" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/351078_product.png" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/449475_product.png" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/722157_product.png" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/782157_product.png" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/841904_product.png" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/909832_product.png" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/989674_product.png" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/Logo No Bg.PNG" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>
    <!-- Repeat for each product -->
    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/225083_product.png" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/336015_product.png" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/351078_product.png" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/449475_product.png" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/722157_product.png" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/782157_product.png" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/841904_product.png" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/909832_product.png" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col">
      <a href="product-page.html" class="text-decoration-none">
        <div class="card bordero">
          <img src="./asset/product/989674_product.png" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Short description of the product.</p>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>


    <footer class="text-center py-3">
        <p class="mb-0">© 2024 RD Vape Store. All Rights Reserved.</p>
        <small>Designed by <strong>Dzaky Hanifah</strong></small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <!-- Navbar + sidebar -->
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        // Toggle sidebar and overlay
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        // Close sidebar when clicking on overlay
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });

        function scrollToReport() {
            document.getElementById('laporan-penjualan').scrollIntoView({
                behavior: 'smooth'
            });
        }
        function scrollToVerification() {
    document.getElementById('verifikasi-barang').scrollIntoView({
        behavior: 'smooth'
    });
}
    </script>

<!-- top carausel -->
<script>
      const carousel = document.querySelector('#carouselExample');
      const carouselInstance = new bootstrap.Carousel(carousel, {
        interval: 2000, // 2 detik
        ride: 'carousel' // Mulai otomatis
      });
    </script>

<!-- kategori -->


  </body>
</html>