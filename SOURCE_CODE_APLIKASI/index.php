<?php
// FokusKonten PHP 8.2 Compatibility Shield
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
ini_set('display_errors', '0');
?><!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <link rel="icon" type="image/svg+xml" href="favicon.svg">
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/logo-ct-dark.png">
  <title>
    Sistem Informasi Bengkel | Dashboard
  </title>
  <!-- sweet allert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <!-- datatables -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.css" />

</head>

<?php

session_start();
require_once  'config/koneksi.php';
// Periksa apakah pengguna sudah login
if (isset($_SESSION["ses_username"]) == "") {
  header("location: ./login.php");
} else {
  $data_id = $_SESSION["ses_id"];
  $data_nama = $_SESSION["ses_nama"];
  $data_user = $_SESSION["ses_username"];
  $data_level = $_SESSION['ses_level'];
  $now = date_create();
  $formattedDate = $now->format('Y-m-d');
}

require './controllers/KategoriController.php';
require './controllers/BarangController.php';
require './controllers/ServiceController.php';
require './controllers/PembelianController.php';
require './controllers/PenjualanController.php';

?>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="?page=dashboard&act=view">
        <img src="./assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo" sizes="76x76">
        <span class="ms-1 font-weight-bold">BengkelPro</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?php if ($_GET['page'] == 'dashboard') {
                                echo 'active';
                              } ?>" href="?page=dashboard&act=view">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Master Data</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($_GET['page'] == 'barang') {
                                echo 'active';
                              } ?>" href="?page=barang&act=list">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-app text-info text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Barang</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link  <?php if ($_GET['page'] == 'kategori') {
                                echo 'active';
                              } ?>" href="?page=kategori&act=list">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-app text-info text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Kategori</span>
          </a>
        </li>
        <!-- transaction -->
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Transaksi</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($_GET['page'] == 'service') {
                                echo 'active';
                              } ?>" href="?page=service&act=list">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-world-2 text-danger text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Service</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($_GET['page'] == 'pembelian') {
                                echo 'active';
                              } ?>" href="?page=pembelian&act=list">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-basket text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Pembelian</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($_GET['page'] == 'penjualan') {
                                echo 'active';
                              } ?>" href="?page=penjualan&act=list">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-bag-17 text-secondary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Penjualan</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Laporan</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($_GET['page'] == 'laporan') {
                                echo 'active';
                              } ?>" href="?page=laporan&act=list&tgl=<?= $formattedDate; ?>">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-copy-04 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Laporan</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">

        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">

          </div>
          <ul class="navbar-nav  justify-content-start">
            <li class="nav-item d-flex align-items-center">
              <a href="#" onclick="return false;" class="nav-link text-white font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none"><?= $data_nama ?></span>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="logout.php" class="nav-link text-white p-0" onclick="return confirm('Anda yakin keluar dari aplikasi ?')">
                <i class="fas fa-power-off"></i>
              </a>
            </li>
            <!-- <li class="nav-item dropdown pe-2 d-flex align-items-center">
              <a href="#" onclick="return false;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-cog cursor-pointer"></i>
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="#" onclick="return false;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="./assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New message</span> from Laur
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          13 minutes ago
                        </p>
                      </div>
                    </div>
                  </a>
                </li>

              </ul>
            </li> -->
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->

    <!-- page  content here-->
    <?php
    if (isset($_GET['page'])) {
      $hal = $_GET['page'];

      switch ($hal) {
        case 'kategori':
          include('./public/category.php');
          break;
        case 'dashboard':
          include('./public/dashboard.php');
          break;
        case 'barang':
          include('./public/barang.php');
          break;
        case 'pembelian':
          include('./public/pembelian.php');
          break;
        case 'penjualan':
          include('./public/penjualan.php');
          break;
        case 'service':
          include('./public/service.php');
          break;
        case 'laporan':
          include('./public/laporan.php');
          break;

        default:
          echo "<center><br><br><br><br><br><br><br><br><br>
            <h1> Halaman tidak ditemukan !</h1></center>
            <br><br><br><br><br><br><br>";
          break;
      }
    } else {
      // include 'index.php';
    }
    ?>

    <footer class="footer pt-3">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-sm text-muted text-lg-start">
              &copy; <script>document.write(new Date().getFullYear())</script> <strong>BengkelPro</strong> &mdash; FokusKonten Official
            </div>
          </div>
          <div class="col-lg-6"></div>
        </div>
      </div>
    </footer>
    <!--   Core JS Files   -->

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.js"></script>

    <script src="./assets/js/core/popper.min.js"></script>
    <script src="./assets/js/core/bootstrap.min.js"></script>
    <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="./assets/js/plugins/chartjs.min.js"></script>

    <script>
      var win = navigator.platform.indexOf('Win') > -1;
      if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
          damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
      }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>
    <script>
      $(function() {
        if ($('#basicExample').length) {
          $('#basicExample').DataTable({
            'iDisplayLength': 5
          });
        }
      });
    </script>

    <script>
      const searchForm = document.getElementById('search');
    if (searchForm) {
      searchForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const dateInput = document.getElementById('tanggal');
        const dateValue = dateInput ? dateInput.value : '';
        const url = `index.php?page=laporan&act=list&tgl=${dateValue}`;
        window.location.href = url;
      });
    }
    </script>

    <?php



    $TotalPenjualan = 0;
    $TotalService = 0;
    $formattedDate = date('Y-m-d'); // Contoh format tanggal

    $query = mysqli_query($conn, "SELECT MONTHNAME(transaksi.tgl_transaksi) AS bulan, 
    COUNT(*) AS total_transaksi, SUM(detail_penjualan.total) AS total_penjualan, transaksi.tgl_transaksi as timestamp, 
    SUM(detail_service.total_harga) AS total_service, SUM(detail_pembelian.total) AS total_pembelian
    FROM transaksi LEFT JOIN detail_penjualan ON transaksi.id_detail_penjualan = detail_penjualan.id_penjualan 
      LEFT JOIN detail_service ON transaksi.id_detail_service = detail_service.id_service 
      LEFT JOIN detail_pembelian ON transaksi.id_detail_pembelian = detail_pembelian.id_pembelian GROUP BY MONTH(transaksi.tgl_transaksi)");

    $data = array();
    while ($row = mysqli_fetch_assoc($query)) {
      $data[] = array(
        'bulan' => $row['bulan'],
        'total' => $row['total_penjualan'] + $row['total_service'] + $row['total_pembelian']
      );
     
    }
    
    ?>

    <script>
      var chartEl = document.getElementById("chart-line");
      if (chartEl) {
        var ctx1 = chartEl.getContext("2d");
        var tgl = <?= json_encode(array_column($data, 'bulan')); ?>;
        var total = <?= json_encode(array_column($data, 'total')); ?>;
        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
        new Chart(ctx1, {
          type: "line",
          data: {
            labels: tgl,
            datasets: [{
              label: "",
              tension: 0.4,
              borderWidth: 0,
              pointRadius: 0,
              borderColor: "#5e72e4",
              backgroundColor: gradientStroke1,
              borderWidth: 3,
              fill: true,
              data: total,
              maxBarThickness: 6
            }],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { display: false }
            },
            interaction: {
              intersect: false,
              mode: 'index',
            },
            scales: {
              y: {
                grid: { drawBorder: false, display: true, drawOnChartArea: true, drawTicks: false, borderDash: [5, 5] },
                ticks: { display: true, padding: 10, color: '#fbfbfb', font: { size: 11, family: "Open Sans", style: 'normal', lineHeight: 2 } }
              },
              x: {
                grid: { drawBorder: false, display: false, drawOnChartArea: false, drawTicks: false, borderDash: [5, 5] },
                ticks: { display: true, color: '#ccc', padding: 20, font: { size: 11, family: "Open Sans", style: 'normal', lineHeight: 2 } }
              }
            }
          }
        });
      }
    </script>

  </main>
</body>

</html>