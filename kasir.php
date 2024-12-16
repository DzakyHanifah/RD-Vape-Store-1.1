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

// Fetch items
$items = $conn->query("SELECT id, name, price FROM items");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./asset/Logo No Bg.PNG"> <!-- icon pada tab -->


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

        .total-section {
            margin-top: 1rem;
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            color: #ffb400;
            /* Orange */
        }

        .process-section {
            text-align: right;
            margin-top: 1rem;
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
            <!-- <a href="javascript:void(0)" onclick="scrollToReport()">Unduh Laporan</a> -->
            <!-- <a href="javascript:void(0)" onclick="scrollToVerification()">Verifikasi Barang Baru</a> -->
            <a href="javascript:void(0)" onclick="member()">Cari Member</a>
            <a href="javascript:void(0)" onclick="newmember()">New Member</a>
            <a href="javascript:void(0)" class="logout" onclick="logout()">Logout</a>
        </div>
        <div class="sidebar-footer">
            <img src="./asset/Logo No Bg.PNG" alt="Logo Sidebar">
            <p>Designed by <strong>Dzaky Hanifah</strong></p>
            
        </div>
    </div>
    <div class="container">
        <h1 class="header-title">Halaman Kasir</h1>
        <form id="kasirForm">
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="item" class="form-label">Pilih Barang</label>
                    <select id="item" class="form-select">
                        <option value="">Pilih Barang</option>
                        <?php while ($row = $items->fetch_assoc()): ?>
                            <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>">
                                <?= $row['name'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="quantity" class="form-label">Jumlah</label>
                    <input type="number" id="quantity" class="form-control" min="1" value="1">
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="button" id="addItem" class="btn btn-primary w-100">Tambahkan</button>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="cartItems"></tbody>
            </table>

            <!-- total harga -->
            <div class="total-section">
                Total: <span id="totalAmount">0</span>
            </div>

            <!-- status member/non -->
            

            <!-- metode pembayaran -->
            <div class="row">
                <div class="col-md-6">
                    <label for="paymentMethod">Metode Pembayaran:</label>
                    <select id="paymentMethod" class="form-control">
                        <option value="">Pilih</option>
                        <option value="tunai">Tunai</option>
                        <option value="non-tunai">Non-Tunai</option>
                    </select>
                </div>

                <div id="cashInput" style="display: none;" class="col-md-6">
                    <label for="cashGiven">Nominal yang Dibayarkan:</label>
                    <input type="number" id="cashGiven" class="form-control" placeholder="Masukkan nominal">
                </div>
                

                <div id="nonCashOptions" style="display: none;" class="col-md-6">
                    <label for="nonCashApp">Pilih Aplikasi:</label>
                    <select id="nonCashApp" class="form-control">
                        <option value="">Pilih</option>
                        <option value="linkaja">LinkAja</option>
                        <option value="ovo">OVO</option>
                        <option value="dana">DANA</option>
                        <option value="shopeepay">ShopeePay</option>
                    </select>
                </div>
            </div>

            <div class="process-section">
                <button type="submit" class="btn btn-success">Proses Transaksi</button>
            </div>
        </form>
    </div>

    <footer class="text-center py-3">
        <p class="mb-0">© 2024 RD Vape Store. All Rights Reserved.</p>
        <small>Designed by <strong>Dzaky Hanifah</strong></small>
    </footer>

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

function member() {
    let timerInterval;
    Swal.fire({
        title: "OTW Member!",
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
            window.location.href = "member.php";
        }
        });
}

// tambah member
function newmember(){
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
}
    </script>
    <script>
        $(document).ready(function() {
            let cart = [];
            let total = 0;

            // Add item to cart
            $('#addItem').on('click', function() {
                const itemId = $('#item').val();
                const itemName = $('#item option:selected').text();
                const itemPrice = parseFloat($('#item option:selected').data('price'));
                const itemQty = parseInt($('#quantity').val());

                if (!itemId || itemQty < 1) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Pilih barang dan masukkan jumlah valid!',
                    });
                    return;
                }

                const subtotal = itemPrice * itemQty;
                cart.push({
                    itemId,
                    itemName,
                    itemPrice,
                    itemQty,
                    subtotal
                });

                updateCart();
            });

            // Update cart display
            function updateCart() {
                total = 0;
                $('#cartItems').html('');
                cart.forEach((item, index) => {
                    total += item.subtotal;
                    $('#cartItems').append(`
                    <tr>
                        <td>${item.itemName}</td>
                        <td>${item.itemPrice.toFixed(2)}</td>
                        <td>${item.itemQty}</td>
                        <td>${item.subtotal.toFixed(2)}</td>
                        <td><button class="btn btn-danger btn-sm" onclick="removeItem(${index})">Hapus</button></td>
                    </tr>
                `);
                });
                $('#totalAmount').text(total.toFixed(2));
            }

            // Remove item from cart
            window.removeItem = function(index) {
                cart.splice(index, 1);
                updateCart();
            };

            // Show/hide payment options based on selected method
            $('#paymentMethod').on('change', function() {
                const paymentMethod = $(this).val();
                if (paymentMethod === 'tunai') {
                    $('#cashInput').show();
                    $('#nonCashOptions').hide();
                } else if (paymentMethod === 'non-tunai') {
                    $('#cashInput').hide();
                    $('#nonCashOptions').show();
                } else {
                    $('#cashInput').hide();
                    $('#nonCashOptions').hide();
                }
            });

            // Handle form submission
            $('#kasirForm').on('submit', function(e) {
                e.preventDefault();
                if (cart.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: 'Keranjang kosong!',
                    });
                    return;
                }

                const paymentMethod = $('#paymentMethod').val();
                const cashGiven = paymentMethod === 'tunai' ? parseFloat($('#cashGiven').val()) : null;
                const nonCashApp = paymentMethod === 'non-tunai' ? $('#nonCashApp').val() : null;

                if (paymentMethod === 'tunai' && (isNaN(cashGiven) || cashGiven < total)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: 'Nominal yang diberikan harus lebih besar atau sama dengan total belanja!',
                    });
                    return;
                }

                if (paymentMethod === 'non-tunai' && !nonCashApp) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Pilih aplikasi pembayaran non-tunai!',
                    });
                    return;
                }

                const change = paymentMethod === 'tunai' ? cashGiven - total : 0;

                // Simulate sending data to the server
                $.post('save_transaction.php', {
                    cart,
                    total,
                    paymentMethod,
                    cashGiven,
                    change_amount: change,
                    nonCashApp
                }, function(response) {
                    if (!response.success) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message,
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            confirmButtonText: 'Unduh Struk',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'download_receipt.php?id=' + response.transactionId;
                            }
                        });
                    }
                }, 'json').fail(function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: 'Terjadi kesalahan saat menyimpan transaksi.',
                    });
                });
            });
        });
    </script>



</body>
</html>