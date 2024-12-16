<?php
$conn = new mysqli("localhost", "root", "", "kasir_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fungsi pencarian barang
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($searchTerm) {
    $itemsQuery = $conn->prepare("SELECT * FROM items WHERE name LIKE ?");
    $searchParam = "%" . $searchTerm . "%";
    $itemsQuery->bind_param("s", $searchParam);
    $itemsQuery->execute();
    $items = $itemsQuery->get_result();
} else {
    $items = $conn->query("SELECT * FROM items");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gudang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./asset/Logo No Bg.PNG"> <!-- icon pada tab -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Atur scrollbar untuk browser berbasis WebKit */
        ::-webkit-scrollbar {
            width: 4px;
            /* Lebar scrollbar lebih ramping */
        }

        /* Jalur (track) scrollbar berwarna hitam */
        ::-webkit-scrollbar-track {
            background: #000;
            /* Warna hitam */
            border-radius: 2px;
            /* Agar lebih lembut dan minimalis */
        }

        /* Pegangan (thumb) scrollbar berwarna merah */
        ::-webkit-scrollbar-thumb {
            background-color: #FCA311;
            /* Warna merah */
            border-radius: 2px;
            /* Sudut yang lebih lembut */
        }

        /* Efek hover pada pegangan scrollbar */
        ::-webkit-scrollbar-thumb:hover {
            background-color: #FF5555;
            /* Sedikit pencerahan merah ketika hover */
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
            color: #ffffff;
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
            border-bottom: 5px solid var(--orange);
            /* Opsional: garis bawah */

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
            border: 5px solid #FCA311;
            /* Orange */
        }

        .sidebar.active {
            right: 0;
        }


        .sidebar h2 {
            text-align: center;
            /* Pusatkan teks secara horizontal */
            margin: 0 auto;
            /* Hapus margin tambahan */
            padding-bottom: 10px;
            /* Tambahkan jarak ke bawah untuk estetika */
            border-bottom: 2px solid var(--orange);
            /* Opsional: garis bawah untuk membedakan judul */
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
            position: absolute;
            /* Pastikan footer berada di posisi absolut relatif terhadap sidebar */
            bottom: 70px;
            /* Jarak dari bagian bawah sidebar */
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            /* Agar teks dan logo terpusat */
        }

        .sidebar-footer img {
            display: block;
            margin: 0 auto;
            width: 100px;
            /* Sesuaikan ukuran logo */
            height: auto;
        }

        .sidebar-footer p {
            margin: 5px 0 0;
            font-size: 14px;
            color: var(--white);
        }

        .header-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #ffb400;
            /* Orange */
            margin-bottom: 20px;
        }

        .container {
            background-color: #1E1E2F;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            border: 5px solid #FCA311;
            /* Orange */
        }

        .btn-primary {
            background-color: #ff9800;
            border-color: #ff9800;
        }

        .btn-primary:hover {
            background-color: #e68900;
            border-color: #e68900;
        }

        .btn-success {
            background-color: #4caf50;
            border-color: #4caf50;
        }

        .btn-success:hover {
            background-color: #43a047;
            border-color: #43a047;
        }

        table {
            background-color: #212533;
        }

        th,
        td {
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
            <a id="addItemBtnn" class="btn">Tambah Barang</a>
            <!-- <a href="javascript:void(0)" onclick="scrollToVerification()">Verifikasi Barang Baru</a> -->
            <a href="javascript:void(0)" class="logout" onclick="logout()">Logout</a>
        </div>
        <div class="sidebar-footer">
            <img src="./asset/Logo No Bg.PNG" alt="Logo Sidebar">
            <p>Designed by <strong>Dzaky Hanifah</strong></p>

        </div>
    </div>


    <div class="container">
        <h2 class="text-center header-title">Halaman Gudang</h2>

        <!-- Form Pencarian Barang -->
        <form method="GET" class="d-flex mb-4">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari nama barang..." value="<?= htmlspecialchars($searchTerm) ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        <!-- Tabel Stok Barang -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $items->fetch_assoc()): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>Rp <?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['stock'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Tombol Tambah Barang -->
        <div class="text-center mt-4">
            <button id="addItemBtn" class="btn btn-success">Tambah Barang</button>
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

        $(document).ready(function() {
            // Tambah Barang dengan SweetAlert2
            $('#addItemBtn').on('click', function() {
                Swal.fire({
                    title: 'Tambah Barang',
                    html: `
                    <form id="addItemForm" style="background-color: #333; color: #fff; padding: 15px; border: 2px solid orange; border-radius: 10px;">
                        <div class="mb-3">
                            <label for="itemName" class="form-label" style="color: orange;">Nama Barang</label>
                            <input type="text" id="itemName" class="form-control" required style="background-color: #444; color: #fff; border: 1px solid orange;">
                        </div>
                        <div class="mb-3">
                            <label for="itemPrice" class="form-label" style="color: orange;">Harga Barang</label>
                            <input type="number" id="itemPrice" class="form-control" required style="background-color: #444; color: #fff; border: 1px solid orange;">
                        </div>
                        <div class="mb-3">
                            <label for="itemStock" class="form-label" style="color: orange;">Jumlah Stok</label>
                            <input type="number" id="itemStock" class="form-control" required style="background-color: #444; color: #fff; border: 1px solid orange;">
                        </div>
                    </form>
                `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    preConfirm: () => {
                        const itemName = $('#itemName').val().trim();
                        const itemPrice = parseFloat($('#itemPrice').val());
                        const itemStock = parseInt($('#itemStock').val());

                        if (!itemName || isNaN(itemPrice) || isNaN(itemStock)) {
                            Swal.showValidationMessage('Semua field harus diisi dengan benar!');
                            return false;
                        }

                        return {
                            itemName,
                            itemPrice,
                            itemStock
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const {
                            itemName,
                            itemPrice,
                            itemStock
                        } = result.value;

                        $.post('gudang_add.php', {
                            name: itemName,
                            price: itemPrice,
                            stock: itemStock
                        }, function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Barang berhasil ditambahkan!',
                            }).then(() => {
                                location.reload();
                            });
                        }).fail(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat menambahkan barang.',
                            });
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Tambah Barang dengan SweetAlert2
            $('#addItemBtnn').on('click', function() {
                Swal.fire({
                    title: 'Tambah Barang',
                    html: `
                    <form id="addItemForm" style="background-color: #333; color: #fff; padding: 15px; border: 2px solid orange; border-radius: 10px;">
                        <div class="mb-3">
                            <label for="itemName" class="form-label" style="color: orange;">Nama Barang</label>
                            <input type="text" id="itemName" class="form-control" required style="background-color: #444; color: #fff; border: 1px solid orange;">
                        </div>
                        <div class="mb-3">
                            <label for="itemPrice" class="form-label" style="color: orange;">Harga Barang</label>
                            <input type="number" id="itemPrice" class="form-control" required style="background-color: #444; color: #fff; border: 1px solid orange;">
                        </div>
                        <div class="mb-3">
                            <label for="itemStock" class="form-label" style="color: orange;">Jumlah Stok</label>
                            <input type="number" id="itemStock" class="form-control" required style="background-color: #444; color: #fff; border: 1px solid orange;">
                        </div>
                    </form>
                `,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    preConfirm: () => {
                        const itemName = $('#itemName').val().trim();
                        const itemPrice = parseFloat($('#itemPrice').val());
                        const itemStock = parseInt($('#itemStock').val());

                        if (!itemName || isNaN(itemPrice) || isNaN(itemStock)) {
                            Swal.showValidationMessage('Semua field harus diisi dengan benar!');
                            return false;
                        }

                        return {
                            itemName,
                            itemPrice,
                            itemStock
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const {
                            itemName,
                            itemPrice,
                            itemStock
                        } = result.value;

                        $.post('gudang_add.php', {
                            name: itemName,
                            price: itemPrice,
                            stock: itemStock
                        }, function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Barang berhasil ditambahkan!',
                            }).then(() => {
                                location.reload();
                            });
                        }).fail(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat menambahkan barang.',
                            });
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>