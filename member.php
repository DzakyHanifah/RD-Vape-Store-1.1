<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kasir_db";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Inisialisasi pencarian
$search = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
}

// Query untuk mengambil data dari tabel members
$sql = "SELECT id, name, phone, email, points, total_points, created_at FROM members";
if (!empty($search)) {
    $sql .= " WHERE name LIKE '%$search%' OR phone LIKE '%$search%' OR email LIKE '%$search%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Members</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <!-- navbar and sidebar -->
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
            <a href="javascript:void(0)" onclick="scrollToNewMember()">New Member</a>
            <a href="javascript:void(0)" onclick="kasir()">Kasir</a>
            <a href="javascript:void(0)" class="logout" onclick="logout()">Logout</a>
        </div>
        <div class="sidebar-footer">
            <img src="./asset/Logo No Bg.PNG" alt="Logo Sidebar">
            <p>Designed by <strong>Dzaky Hanifah</strong></p>

        </div>
    </div>

    <!-- tabel utama -->
    <div class="container mt-5">
        <h1 class="text-center header-title">Data Members</h1>
        
        <!-- Form Pencarian -->
        <form class="d-flex mb-4" method="GET" action="">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari member..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Points</th>
                    <th>Total Points</th>
                    <th>Created At</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Output data setiap baris
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["phone"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["points"] . "</td>";
                        echo "<td>" . $row["total_points"] . "</td>";
                        echo "<td>" . $row["created_at"] . "</td>";
                        
                        echo "<td><button class='btn btn-primary useMemberButton' data-id='" . $row["id"] . "'>Tambah point</button> 
                            <button class='btn btn-warning exchangePointsButton' data-id='" . $row["id"] . "'>Tukar Poin</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data</td></tr>";
                }
                ?>
            </tbody>
        </table>
        </div>

<!-- Tombol Tambah Member -->
<div id="new-member" class="text-center mt-4">
            <button class="btn btn-success" id="addMemberButton">Tambah Member</button>
        </div>
    </div>

    <!-- footer -->
    <footer class="text-center py-3">
        <p class="mb-0">© 2024 RD Vape Store. All Rights Reserved.</p>
        <small>Designed by <strong>Dzaky Hanifah</strong></small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- nav and sidebar -->
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

        function scrollToNewMember() {
    document.getElementById('new-member').scrollIntoView({
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

function kasir() {
    let timerInterval;
    Swal.fire({
        title: "kasir!",
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
            window.location.href = "kasir.php";
        }
        });
}

    </script>
    <!-- tombol trasnsksi  -->
    <script> 
        document.querySelectorAll('.useMemberButton').forEach(button => {
    button.addEventListener('click', function() {
        const memberId = this.getAttribute('data-id');

        Swal.fire({
            title: 'Masukkan ID Transaksi',
            input: 'text',
            inputLabel: 'ID Transaksi',
            inputPlaceholder: 'Masukkan ID transaksi',
            showCancelButton: true,
            confirmButtonText: 'Gunakan',
            preConfirm: (transactionId) => {
                if (!transactionId) {
                    Swal.showValidationMessage('ID transaksi harus diisi');
                }
                return transactionId;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const transactionId = result.value;

                // Kirim data ke server menggunakan fetch untuk mendapatkan harga transaksi
                fetch('get_transaction_price.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ transactionId })
                })
                .then(response => response.json())
                .then(responseData => {
                    if (responseData.success) {
                        const totalTransaction = responseData.price;
                        const pointsEarned = totalTransaction * 0.001;  // Poin = 0.1% dari total harga

                        // Kirim data ke server untuk update poin member
                        fetch('use_member.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ memberId, transactionId, pointsEarned })
                        }).then(response => response.json())
                          .then(responseData => {
                              if (responseData.success) {
                                  Swal.fire('Berhasil!', responseData.message, 'success')
                                    .then(() => location.reload());
                              } else {
                                  Swal.fire('Gagal!', responseData.message, 'error');
                              }
                          });
                    } else {
                        Swal.fire('Gagal!', 'ID transaksi tidak ditemukan.', 'error');
                    }
                });
            }
        });
    });
});

    </script>

    <script>
        document.querySelectorAll('.exchangePointsButton').forEach(button => {
    button.addEventListener('click', function() {
        const memberId = this.getAttribute('data-id');

        // Ambil data barang yang bisa ditukar dari server
        fetch('get_exchange_items.php')
            .then(response => response.json())
            .then(items => {
                let itemsHtml = '<select id="itemSelect" class="form-control">';
                items.forEach(item => {
                    itemsHtml += `<option value="${item.id}" data-points="${item.points_required}">${item.name} - ${item.points_required} Poin</option>`;
                });
                itemsHtml += '</select>';

                Swal.fire({
                    title: 'Tukar Poin',
                    html: `
                        <div class="mb-3">
                            <label for="itemSelect">Pilih Barang</label>
                            ${itemsHtml}
                        </div>
                        <div class="mb-3">
                            <input type="number" id="itemQuantity" class="form-control" placeholder="Jumlah Barang" min="1" value="1">
                        </div>
                    `,
                    confirmButtonText: 'Tukar',
                    showCancelButton: true,
                    preConfirm: () => {
                        const selectedItem = document.getElementById('itemSelect').value;
                        const quantity = document.getElementById('itemQuantity').value;
                        if (!selectedItem || quantity <= 0) {
                            Swal.showValidationMessage('Pilih barang dan jumlah yang valid');
                        }
                        return { selectedItem, quantity };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const data = result.value;
                        const item = items.find(i => i.id == data.selectedItem);
                        const totalPointsRequired = item.points_required * data.quantity;

                        // Kirim data ke server untuk proses penukaran
                        fetch('exchange_points.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ memberId, itemId: item.id, quantity: data.quantity, totalPointsRequired })
                        }).then(response => response.json())
                          .then(responseData => {
                              if (responseData.success) {
                                  Swal.fire('Berhasil!', 'Poin berhasil ditukar.', 'success')
                                    .then(() => location.reload());
                              } else {
                                  Swal.fire('Gagal!', 'Terjadi kesalahan saat penukaran.', 'error');
                              }
                          });
                    }
                });
            });
    });
});

    </script>

    <!-- tambah member baru  -->
    <script>
        document.getElementById('addMemberButton').addEventListener('click', function() {
            Swal.fire({
                title: 'Tambah Member Baru',
                html: `
                    <form id="addMemberForm" style="background-color: #333; color: #fff; padding: 15px; border: 2px solid orange; border-radius: 10px;">
                        <div class="mb-3">
                            <label for="Name" class="form-label" style="color: orange;">Nama</label>
                            <input type="text" id="name" class="form-control" required style="background-color: #444; color: #fff; border: 1px solid orange;">
                        </div>
                        <div class="mb-3">
                            <label for="Telepon" class="form-label" style="color: orange;">Telepon</label>
                            <input type="text" id="phone" class="form-control" required style="background-color: #444; color: #fff; border: 1px solid orange;">
                        </div>
                        <div class="mb-3">
                            <label for="Email" class="form-label" style="color: orange;">Email</label>
                            <input type="email" id="email" class="form-control" required style="background-color: #444; color: #fff; border: 1px solid orange;">
                        </div>
                    </form>
                `,
                confirmButtonText: 'Tambah',
                showCancelButton: true,
                preConfirm: () => {
                    const name = document.getElementById('name').value;
                    const phone = document.getElementById('phone').value;
                    const email = document.getElementById('email').value;

                    if (!name) {
                        Swal.showValidationMessage('Nama wajib diisi');
                    }

                    return { name, phone, email };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const data = result.value;

                    // Kirim data ke server menggunakan fetch
                    fetch('add_member.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(data)
                    }).then(response => response.json())
                      .then(responseData => {
                          if (responseData.success) {
                              Swal.fire('Berhasil!', 'Member berhasil ditambahkan.', 'success')
                                .then(() => location.reload());
                          } else {
                              Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                          }
                      });
                }
            });
        });
    </script>
</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>
