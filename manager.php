<?php
$conn = new mysqli("localhost", "root", "", "kasir_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data for charts
$weeklySales = $conn->query("
    SELECT DATE(created_at) as date, SUM(total) as total 
    FROM transactions 
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
    GROUP BY DATE(created_at)
");

$monthlySales = $conn->query("
    SELECT DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total) as total 
    FROM transactions 
    GROUP BY DATE_FORMAT(created_at, '%Y-%m')
");

$yearlySales = $conn->query("
    SELECT YEAR(created_at) as year, SUM(total) as total 
    FROM transactions 
    GROUP BY YEAR(created_at)
");

// Fetch best-selling items
$bestSellingItems = $conn->query("
    SELECT i.name, SUM(td.quantity) as total_quantity 
    FROM transaction_details td
    JOIN items i ON td.item_id = i.id
    GROUP BY i.name
    ORDER BY total_quantity DESC
    LIMIT 5
");

// Fetch least-selling items
$leastSellingItems = $conn->query("
    SELECT i.name, SUM(td.quantity) as total_quantity 
    FROM transaction_details td
    JOIN items i ON td.item_id = i.id
    GROUP BY i.name
    ORDER BY total_quantity ASC
    LIMIT 5
");

// Ambil data barang yang statusnya 'pending'
$pendingItems = $conn->query("SELECT * FROM pending_items");
$message = ''; // Variabel untuk menyimpan pesan

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
    $action = isset($_POST['action']) ? $_POST['action'] : null;

    if ($id && $action) {
        $pendingItemQuery = $conn->prepare("SELECT * FROM pending_items WHERE id = ?");
        $pendingItemQuery->bind_param("i", $id);
        $pendingItemQuery->execute();
        $pendingItem = $pendingItemQuery->get_result()->fetch_assoc();

        if ($pendingItem) {
            if ($action === 'approve') {
                $stmt = $conn->prepare("INSERT INTO items (name, price, stock) VALUES (?, ?, ?)");
                $stmt->bind_param("sii", $pendingItem['name'], $pendingItem['price'], $pendingItem['stock']);
                $stmt->execute();

                $deleteStmt = $conn->prepare("DELETE FROM pending_items WHERE id = ?");
                $deleteStmt->bind_param("i", $id);
                $deleteStmt->execute();

                $message = json_encode(['status' => 'success', 'type' => 'approve']);
            } elseif ($action === 'reject') {
                $deleteStmt = $conn->prepare("DELETE FROM pending_items WHERE id = ?");
                $deleteStmt->bind_param("i", $id);
                $deleteStmt->execute();

                $message = json_encode(['status' => 'success', 'type' => 'reject']);
            }
        } else {
            $message = json_encode(['status' => 'error', 'msg' => 'Barang dengan ID ini tidak ditemukan']);
        }
    } else {
        $message = json_encode(['status' => 'error', 'msg' => 'Permintaan tidak valid']);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penjualan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="icon" type="image/x-icon" href="./asset/Logo No Bg.PNG"> <!-- icon pada tab -->
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom Styles -->
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
            background-color: #121212;
            /* Black */
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

        /* Atur jarak kanan-kiri agar lebih ramping dan responsif */
        .container {
            margin-top: 20px;
            padding-left: 10px;
            padding-right: 10px;
            max-width: 1200px;
        }

        /* Untuk layar yang lebih kecil */
        @media (max-width: 768px) {
            .container {
                padding-left: 5px;
                padding-right: 5px;
            }
        }

        .card {
            background-color: #1c1c2b;
            /* Oxford Blue */
            border: 5px solid #FCA311;
            /* Orange */
            border-radius: 10px;
            color: #FCA311;
            /* Orange */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .btn-primary {
            background-color: #ff6700;
            /* Orange (web) */
            border-color: #ff6700;
        }

        .btn-primary:hover {
            background-color: #e65c00;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            display: none;
            /* Sembunyikan tombol navigasi */
            background-color: #ffffff;
            /* White */
            border-radius: 50%;
        }

        .badge {
            font-size: 0.9em;
            background-color: #ff6700;
            /* Orange (web) */
            color: #ffffff;
        }
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
            <a href="javascript:void(0)" onclick="scrollToReport()">Unduh Laporan</a>
            <a href="javascript:void(0)" onclick="scrollToVerification()">Verifikasi Barang Baru</a>
            <a href="javascript:void(0)" class="logout" onclick="logout()">Logout</a>
        </div>
        <div class="sidebar-footer">
            <img src="./asset/Logo No Bg.PNG" alt="Logo Sidebar">
            <p>Designed by <strong>Dzaky Hanifah</strong></p>
            
        </div>
    </div>

    <div class="container">
        <!-- Carousel -->
        <div id="salesCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="card p-4">
                        <h2 class="text-center">Mingguan</h2>
                        <canvas id="weeklyChart"></canvas>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="card p-4">
                        <h2 class="text-center">Bulanan</h2>
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="card p-4">
                        <h2 class="text-center">Tahunan</h2>
                        <canvas id="yearlyChart"></canvas>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#salesCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#salesCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Best Selling & Least Selling -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card p-3">
                    <h5>Barang Terlaris</h5>
                    <ul class="list-group">
                        <?php while ($row = $bestSellingItems->fetch_assoc()): ?>
                            <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                                <?= htmlspecialchars($row['name']) ?>
                                <span class="badge"><?= $row['total_quantity'] ?> terjual</span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3">
                    <h5>Barang Tidak Laris</h5>
                    <ul class="list-group">
                        <?php while ($row = $leastSellingItems->fetch_assoc()): ?>
                            <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                                <?= htmlspecialchars($row['name']) ?>
                                <span class="badge bg-danger"><?= $row['total_quantity'] ?> terjual</span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Download Report -->
        <div id="laporan-penjualan" class="card p-4 mt-4">
            <h5>Laporan Penjualan</h5>
            <form action="generate_report.php" method="GET">
                <div class="row">
                    <div class="col-md-8">
                        <select name="report_type" class="form-control bg-dark text-light">
                            <option value="weekly">Laporan Mingguan</option>
                            <option value="monthly">Laporan Bulanan</option>
                            <option value="yearly">Laporan Tahunan</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">Unduh Laporan</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Verifikasi Barang Baru -->
        <div id="verifikasi-barang" class="card p-4 mt-4">
            <h5>Verifikasi Barang Baru</h5>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($item = $pendingItems->fetch_assoc()): ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td><?= $item['name'] ?></td>
                            <td>Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td><?= $item['stock'] ?></td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Setujui</button>
                                    <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Tolak</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <footer class="text-center py-3">
        <p class="mb-0">© 2024 RD Vape Store. All Rights Reserved.</p>
        <small>Designed by <strong>Dzaky Hanifah</strong></small>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
function logout() {
    Swal.fire({
        title: 'Anda yakin?',
        text: 'Anda akan keluar dari sesi ini.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f77f00', // Warna tombol konfirmasi
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, logout',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to index.html or logout logic
            window.location.href = "index.html";
        }
    });
}

    </script>

    <script>
<?php if ($message): ?>
const response = <?php echo $message; ?>;
if (response.status === 'success') {
    if (response.type === 'approve') {
        // Jika disetujui, tampilkan popup dengan animasi centang hijau
        Swal.fire({
            title: 'Berhasil!',
            text: 'Barang telah disetujui dan ditambahkan ke stok.',
            icon: 'success',
            confirmButtonText: 'OK',
        });
    } else if (response.type === 'reject') {
        // Jika ditolak, tampilkan konfirmasi untuk memastikan penolakan
        Swal.fire({
            title: 'Konfirmasi Penolakan',
            text: 'Apakah Anda yakin ingin menolak barang ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Tolak',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Barang Ditolak!',
                    text: 'Barang telah berhasil ditolak.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                });
            }
        });
    }
} else if (response.status === 'error') {
    Swal.fire({
        title: 'Error',
        text: response.msg,
        icon: 'error',
        confirmButtonText: 'OK',
    });
}
<?php endif; ?>
</script>
    <script>
        // Placeholder data
        /*const weeklyData = [{ date: 'Senin', total: 200 }, { date: 'Selasa', total: 300 }];
        const monthlyData = [{ month: 'Jan', total: 5000 }, { month: 'Feb', total: 4500 }];
        const yearlyData = [{ year: '2023', total: 50000 }];*/

        const weeklySales = <?= json_encode($weeklySales->fetch_all(MYSQLI_ASSOC)) ?>;
        const monthlySales = <?= json_encode($monthlySales->fetch_all(MYSQLI_ASSOC)) ?>;
        const yearlySales = <?= json_encode($yearlySales->fetch_all(MYSQLI_ASSOC)) ?>;

        function renderChart(canvasId, data, labelKey, valueKey, title) {
            new Chart(document.getElementById(canvasId), {
                type: 'line',
                data: {
                    labels: data.map(d => d[labelKey]),
                    datasets: [{
                        label: 'Penjualan',
                        data: data.map(d => d[valueKey]),
                        borderColor: '#ff6700',
                        backgroundColor: 'rgba(255, 103, 0, 0.2)',
                        borderWidth: 2,
                        pointRadius: 10
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: title
                        }
                    }
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            renderChart('weeklyChart', weeklySales, 'date', 'total', 'Penjualan Mingguan');
            renderChart('monthlyChart', monthlySales, 'month', 'total', 'Penjualan Bulanan');
            renderChart('yearlyChart', yearlySales, 'year', 'total', 'Penjualan Tahunan');
        });
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>