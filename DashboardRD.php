<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kasir_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data produk dari tabel "products"
$sql = "SELECT id, name, price, stock, image_url FROM products";
$result = $conn->query($sql);

// Ambil ranking member
$rank_sql = "SELECT id, name, points, total_points FROM members ORDER BY total_points DESC Limit 7";//Limit 7";
$rank_result = $conn->query($rank_sql);
$members = [];
if ($rank_result->num_rows > 0) {
    while ($row = $rank_result->fetch_assoc()) {
        $members[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./asset/Logo No Bg.PNG"> <!-- icon pada tab -->
    <!-- Custom CSS -->
    <style>
            /* Atur scrollbar untuk browser berbasis WebKit */
    ::-webkit-scrollbar {
        width: 4px; /* Lebar scrollbar lebih ramping */
    }

    /* Jalur (track) scrollbar berwarna hitam */
    ::-webkit-scrollbar-track {
        background: #000; /* Warna hitam */
        border-radius: 2px; /* Agar lebih lembut dan minimalis */
    }

    /* Pegangan (thumb) scrollbar berwarna merah */
    ::-webkit-scrollbar-thumb {
        background-color: #FCA311; /* Warna merah */
        border-radius: 2px; /* Sudut yang lebih lembut */
    }

    /* Efek hover pada pegangan scrollbar */
    ::-webkit-scrollbar-thumb:hover {
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
            background-color: #000000;
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
                    left: 10%;
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
        .container {
            background-color: #192841;
            /* Slightly lighter Oxford Blue */
            padding: 2rem;
            border-radius: 8px;
            border: 5px solid #FCA311; /* Orange */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            margin-top: 2rem;
            color: #ffffff;
            /* White */
        }

        .header-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #ffb400;
            /* Orange */
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #ffb400;
            /* Orange */
            border: none;
            color: #000000;
            /* Black for contrast */
        }

        .btn-primary:hover {
            background-color: #e69c00;
            /* Darker Orange */
        }

        .btn-danger {
            background-color: #ff4d4d;
            /* Red */
            color: #ffffff;
            /* White */
            border: none;
        }

        .btn-success {
            background-color: #1c3a63;
            /* Oxford Blue */
            border: none;
            color: #ffffff;
            /* White */
        }

        .btn-success:hover {
            background-color: #172e4d;
            /* Darker Oxford Blue */
        }

        .form-control,
        .form-select {
            background-color: #ffffff;
            /* White */
            color: #000000;
            /* Black */
        }

        .form-label {
            font-weight: bold;
        }

        .table {
            border: 2px solid orange; /* Warna oranye untuk garis tabel */
            margin-top: 1rem;
            background-color: #ffffff;
            /* White */
            color: #000000;
            /* Black */
        }

        .table th {
            background-color: #192841;
            /* Slightly lighter Oxford Blue */
            color: #ffffff;
            /* White */
        }

        .table td {
            color: #000000;
            /* Black */
        }
        /* Opsional: Menambahkan hover effect */
        .table tr:hover {
            background-color: #f5f5f5; /* Warna abu terang saat hover */
        }

/* produk */
.product-card {
    margin-top: 10px;
    transition: transform 0.3s;
    border: none; /* Menghilangkan border card */
    border-radius: 10px;
    overflow: hidden; /* Memastikan gambar tidak keluar dari card */
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
}

.product-image {
    margin-top: 10px;
    width: 100%; /* Gambar memenuhi lebar card */
    height: 200px; /* Tetap tinggi yang konsisten */
    object-fit: cover; /* Menjaga proporsi gambar */
}

.card-body {
    padding: 2px;
}

.card-title {
    font-size: 16px;
    font-weight: bold;
}

.card-text {
    font-size: 14px;
}

.price-text {
    color: #ff4500; /* Warna mencolok untuk harga promo */
    font-weight: bold;
}

/* Responsif untuk perangkat kecil */
@media (max-width: 768px) {
    .product-card {
        margin-bottom: 20px;
    }

    .product-image {
        height: 120px; /* Gambar lebih kecil */
    }
}


        .navbar {
            background-color: #343a40;
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
    
        /* member rank  */
        .podium {
            color: #000000;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 5px;
            margin: 0;
            padding: 0;
        }
        .podium .name {
    font-size: 18px;
    font-weight: bold;
    margin: 0; /* Hilangkan margin default */
}

.podium .points {
    font-size: 16px;
    color: #555; /* Berikan warna abu-abu untuk poin */
    margin: 0; /* Hilangkan margin default */
}

        .podium div {
            text-align: center;
            background-color: #f8f9fa;
            border: 2px solid #000000;
            border-radius: 10px;
            padding: 20px;
            width: 150px;
        }
        .podium .second {
            height: 150px;
        }
        .podium .first {
            height: 200px;
            background-color: #ffd700; /* Gold */
        }
        .podium .third {
            height: 120px;
            background-color: #FED8B1; /* brown  */
            padding: 5px;
        }
        .ranking-table {
            margin-top: 50px;
        }

        .table-bordered{
            border: 5px solid #FCA311; /* Orange */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
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
            <!-- <a href="javascript:void(0)" onclick="member()">Cari Member</a> -->
            <a href="javascript:void(0)" class="logout" onclick="login()">LOGIN <br><small>Staff Only</small></a>
        </div>
        <div class="sidebar-footer">
            <img src="./asset/Logo No Bg.PNG" alt="Logo Sidebar">
            <p>Designed by <strong>Dzaky Hanifah</strong></p>
            
        </div>
    </div>

    <!-- Carousel Container -->
<div id="carouselExampleIndicators" class="carousel slide mx-auto" style="max-width: 1600px;" data-bs-ride="carousel" data-bs-interval="2000">
    <!-- Indicators -->
    <div class="carousel-indicators" id="carouselIndicators"></div>

    <!-- Carousel Items -->
    <div class="carousel-inner" id="carouselInner"></div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- member rank  -->
<div class="container my-5">
    <div class="row">
        <!-- Kolom untuk Rank 1, 2, 3 -->
        <div class="col-md-6">
            <h2 class="text-center mb-4">Top Member Rankings</h2>
            <!-- Podium -->
            <div class="podium">
                <?php if (count($members) > 1): ?>
                    <div class="second">
                        <h3>#2</h3>
                        <p class="name"><strong><?= htmlspecialchars($members[1]['name']); ?></strong></p>
                        <p class="points"><?= htmlspecialchars($members[1]['total_points']); ?> Points</p>
                    </div>
                <?php endif; ?>
                <?php if (count($members) > 0): ?>
                    <div class="first">
                        <h3>#1</h3>
                        <p class="name"><strong><?= htmlspecialchars($members[0]['name']); ?></strong></p>
                        <p class="points"><?= htmlspecialchars($members[0]['total_points']); ?> Points</p>
                    </div>
                <?php endif; ?>
                <?php if (count($members) > 2): ?>
                    <div class="third">
                        <h3>#3</h3>
                        <p class="name"><strong><?= htmlspecialchars($members[2]['name']); ?></strong></p>
                        <p class="points"><?= htmlspecialchars($members[2]['total_points']); ?> Points</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Kolom untuk Ranking 4 dan seterusnya -->
        <div class="col-md-6">
            <h2 class="text-center mb-4">Ranking 4 and Beyond</h2>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Rank</th>
                        <th>Name</th>
                        
                        <th>Total Points</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Menampilkan member ke-4 dan seterusnya
                    for ($i = 3; $i < count($members); $i++): 
                    ?>
                        <tr>
                            <td class="text-center"><?= $i + 1 ?></td>
                            <td class="text-center"><?= htmlspecialchars($members[$i]['name']); ?></td>
                            <!-- <td><?= htmlspecialchars($members[$i]['points']); ?></td> -->
                            <td class="text-center"><?= htmlspecialchars($members[$i]['total_points']); ?> points</td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


    <!-- Produk Section -->
    <div class="container">
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="card product-card shadow-sm">
                        <?php if (!empty($row['image_url'])): ?>
                            <img src="<?= htmlspecialchars($row['image_url']) ?>" class="product-image" alt="<?= htmlspecialchars($row['name']) ?>">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/300x200" class="product-image" alt="No Image">
                        <?php endif; ?>
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
                            <p class="price-text">Rp <?= number_format($row['price'], 0, ',', '.') ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-muted">Tidak ada produk yang tersedia saat ini.</p>
            </div>
        <?php endif; ?>
    </div>
</div>


    <!-- Footer -->
    <footer class="text-center py-4 mt-4 bg-dark text-light">
        <p class="mb-0">&copy; <?= date("Y") ?> Vape Store. All Rights Reserved.</p>
        <small>Designed by <strong>Dzaky Hanifah</strong></small>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        
        // Logout function with SweetAlert2
function login() {
    let timerInterval;
    Swal.fire({
        title: "Login!",
        timer: 2000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
            const timer = Swal.getPopup().querySelector("b");
            timerInterval = setInterval(() => {
            timer.textContent = `${Swal.getTimerLeft()}`;
            }, 100);
        },
        willClose: () => {
            clearInterval(timerInterval);
            
        }
        }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log("I was closed by the timer");
            window.location.href = "index.html";
        }
        });
}

    </script>
    <script>
    // Array berisi path gambar
    const images = [
        './asset/carausel vape/143144_slider.png',
        './asset/carausel vape/154183_slider.png',
        './asset/carausel vape/164980_slider.png',
        './asset/carausel vape/563890_slider.png',
        './asset/carausel vape/600877_slider.png'
    ];

    const indicatorsContainer = document.getElementById('carouselIndicators');
    const innerContainer = document.getElementById('carouselInner');

    // Loop untuk menambahkan gambar dan indikator
    images.forEach((image, index) => {
        // Membuat indikator
        const indicator = document.createElement('button');
        indicator.type = 'button';
        indicator.setAttribute('data-bs-target', '#carouselExampleIndicators');
        indicator.setAttribute('data-bs-slide-to', index);
        indicator.setAttribute('aria-label', `Slide ${index + 1}`);
        if (index === 0) {
            indicator.classList.add('active');
            indicator.setAttribute('aria-current', 'true');
        }
        indicatorsContainer.appendChild(indicator);

        // Membuat elemen gambar carousel
        const carouselItem = document.createElement('div');
        carouselItem.classList.add('carousel-item');
        if (index === 0) carouselItem.classList.add('active');

        const img = document.createElement('img');
        img.src = image;
        img.classList.add('d-block', 'w-100');
        img.style.height = '445px';
        img.style.objectFit = 'cover';
        img.alt = `Slide ${index + 1}`;

        carouselItem.appendChild(img);
        innerContainer.appendChild(carouselItem);
    });
</script>
<script>
    // Mengatur interval carousel secara dinamis
    const carouselElement = document.querySelector('#carouselExampleIndicators');
    const carousel = new bootstrap.Carousel(carouselElement, {
        interval: 2000, // Waktu pergantian slide dalam milidetik (2000ms = 2 detik)
        ride: 'carousel'
    });
</script>
</body>
</html>

<?php
$conn->close();
?>
