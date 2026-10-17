<?php
// FokusKonten PHP 8.2 Compatibility & Session Guard
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
ini_set('display_errors', '0');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/koneksi.php';

// Periksa apakah pengguna sudah login
if (empty($_SESSION["ses_username"])) {
    header("Location: login.php");
    exit;
}

$data_id = $_SESSION["ses_id"] ?? 1;
$data_nama = $_SESSION["ses_nama"] ?? 'Administrator';
$data_user = $_SESSION["ses_username"] ?? 'admin';
$data_level = $_SESSION['ses_level'] ?? 'admin';
$now = date_create();
$formattedDate = $now->format('Y-m-d');

require_once './controllers/KategoriController.php';
require_once './controllers/BarangController.php';
require_once './controllers/ServiceController.php';
require_once './controllers/PembelianController.php';
require_once './controllers/PenjualanController.php';

// Default routing ke dashboard jika tidak ada parameter page
if (empty($_GET['page'])) {
    header("Location: index.php?page=dashboard&act=view");
    exit;
}
?><!DOCTYPE html>
<html lang="id">

<head>
  <link rel="manifest" href="./manifest.json?v=2">
  <link rel="icon" type="image/x-icon" href="./favicon.ico?v=2">
  <link rel="shortcut icon" href="./favicon.ico?v=2">
  <link rel="icon" type="image/png" sizes="192x192" href="./assets/img/favicon.png?v=2">
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="180x180" href="./assets/img/apple-icon.png?v=2">
  <title>BengkelPro - Software Kasir Bengkel Resmi FokusKonten</title>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Fonts and icons -->
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
  <!-- FokusKonten Clean Light Minimalist Theme (Anti-Dark & Anti-Circus) -->
  <link rel="stylesheet" href="./assets/css/fokuskonten-theme.css?v=3" />
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 shadow-sm" id="sidenav-main">
    <div class="sidenav-header p-3 d-flex align-items-center" style="height: auto !important; min-height: 85px;">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0 d-flex align-items-center" href="?page=dashboard&act=view">
        <img src="./assets/img/logo.png?v=3" class="navbar-brand-img rounded-circle me-3 shadow-sm border border-2 border-primary" style="width: 52px !important; height: 52px !important; min-width: 52px !important; max-width: 52px !important; min-height: 52px !important; max-height: 52px !important; aspect-ratio: 1 / 1 !important; object-fit: cover !important; border-radius: 50% !important; flex-shrink: 0 !important;" alt="BengkelPro">
        <div>
          <span class="font-weight-bold text-dark d-block fs-6 leading-tight">BengkelPro</span>
          <span class="text-xs text-primary font-weight-bold d-block mt-1" style="font-size: 0.75rem; letter-spacing: 0.3px;">by FokusKonten</span>
        </div>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?php if ($_GET['page'] == 'dashboard') echo 'active'; ?>" href="?page=dashboard&act=view">
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
          <a class="nav-link <?php if ($_GET['page'] == 'barang') echo 'active'; ?>" href="?page=barang&act=list">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-app text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Barang</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($_GET['page'] == 'kategori') echo 'active'; ?>" href="?page=kategori&act=list">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-bullet-list-67 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Kategori</span>
          </a>
        </li>
        <!-- Transaksi -->
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Transaksi</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($_GET['page'] == 'service') echo 'active'; ?>" href="?page=service&act=list">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-settings text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Service</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($_GET['page'] == 'pembelian') echo 'active'; ?>" href="?page=pembelian&act=list">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-basket text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Pembelian</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($_GET['page'] == 'penjualan') echo 'active'; ?>" href="?page=penjualan&act=list">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-cart text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Penjualan</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Laporan</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($_GET['page'] == 'laporan') echo 'active'; ?>" href="?page=laporan&act=list&tgl=<?= $formattedDate; ?>">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-copy-04 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Laporan</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
  <main class="main-content position-relative border-radius-lg">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
          <ul class="navbar-nav justify-content-start">
            <li class="nav-item d-flex align-items-center me-3">
              <span class="badge bg-white text-primary text-xs font-weight-bold shadow-sm px-3 py-2">
                <i class="fa fa-user me-1"></i> <?= htmlspecialchars($data_nama); ?>
              </span>
            </li>
            <li class="nav-item d-flex align-items-center">
              <a href="logout.php" class="btn btn-sm btn-outline-white mb-0 text-white font-weight-bold" onclick="return confirm('Anda yakin keluar dari aplikasi?')">
                <i class="fas fa-power-off me-1"></i> Keluar
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->

    <!-- Page Content -->
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
          echo "<div class='container-fluid py-5 text-center'>
            <div class='card p-5 shadow-sm'>
              <h3 class='text-dark font-weight-bolder'>Halaman Tidak Ditemukan</h3>
              <p class='text-muted text-sm'>Silakan pilih menu navigasi di sebelah kiri.</p>
              <a href='?page=dashboard&act=view' class='btn btn-primary mt-3'>Kembali ke Dashboard</a>
            </div>
          </div>";
          break;
      }
    }
    ?>

    <footer class="footer pt-3 mt-4">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-sm text-muted text-lg-start">
              &copy; <script>document.write(new Date().getFullYear())</script> <strong>BengkelPro</strong> &mdash; Powered by <a href="https://fokuskonten.my.id" target="_blank" class="text-primary font-weight-bold">FokusKonten</a>
            </div>
          </div>
          <div class="col-lg-6"></div>
        </div>
      </div>
    </footer>

    <!-- Core JS Files -->
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
        var options = { damping: '0.5' };
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
      }
    </script>

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

  </main>
</body>

</html>