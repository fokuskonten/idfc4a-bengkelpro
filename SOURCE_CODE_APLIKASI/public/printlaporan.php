<?php 
    
    require '../config/koneksi.php';
    function query($query)
    {
        global $conn;
        $result = mysqli_query($conn, $query);
        $rows   = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" type="image/x-icon" href="../favicon.ico?v=2">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png?v=2">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Laporan Transaksi - BengkelPro FokusKonten</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            padding: 20px;
        }
        .bg-primary {
            background-color: #2563eb !important;
            color: #ffffff !important;
        }
        .text-white, .text-white * {
            color: #ffffff !important;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }

        
        th, td {
            padding: 8px;
        }
        .table-title {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .text-right {
            text-align: right;
        }

        .sub-total {
            font-weight: bold;
        }
    </style>
</head>
<body>
<table class="table table-hover table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center" colspan="3">Uraian</th>
            <th class="text-center">Jumlah</th>
            <th class="text-center">Total</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th colspan="7">PEMASUKAN</th>
        </tr>
        <tr>
            <th class="text-center">1.</th>
            <th colspan="2">Penjualan</th>
            <th class="text-right"></th>
        </tr>
        <?php
        $tgl = $_GET['tgl'];
        $TotalPenjualan = 0;
        $penjualan = query("SELECT transaksi.*, detail_penjualan.*, barang.*
                          FROM transaksi INNER JOIN detail_penjualan ON transaksi.id_detail_penjualan = detail_penjualan.id_penjualan
                          INNER JOIN barang ON detail_penjualan.id_barang = barang.id_brg where tgl = '$tgl'");
        foreach ($penjualan as $datapenjualan) {
            $TotalPenjualan += $datapenjualan['total'];
        ?>
            <tr>
                <td></td>
                <td><?= $datapenjualan['no_transaksi']; ?></td>
                <td><?= $datapenjualan['nama_brg']; ?></td>
                <td class="text-center"><?= $datapenjualan['jumlah']; ?></td>
                <td class="text-right">Rp. <?= $datapenjualan['total']; ?></td>
            </tr>
        <?php
        }
        ?>
        <tr>
            <th colspan="3" class="text-center bg-primary text-white text-uppercase">total penjualan</th>
            <th class="text-center bg-primary text-white"></th>
            <th class="text-right bg-primary text-white">Rp. <?= $TotalPenjualan; ?></th>

        </tr>
        <tr>
            <th class="text-center">2.</th>
            <th colspan="2">Service</th>
            <th class="text-right"></th>
            <th></th>
        </tr>
        <?php
        $totalservice = 0;
        $service = query("SELECT transaksi.*, detail_service.*, barang.*
                            FROM transaksi INNER JOIN detail_service ON transaksi.id_detail_service = detail_service.id_service
                            INNER JOIN barang ON detail_service.id_barang = barang.id_brg where tgl= '$tgl'");
        foreach ($service as $dataservice) {
            $totalservice += $dataservice['total_harga'];
        ?>
            <tr>
                <td></td>
                <th><?= $dataservice['no_transaksi']; ?></th>
                <th><?= $dataservice['keterangan'] . '  --  ' . $dataservice['nama_brg']; ?></th>
                <td class="text-center"><?= $dataservice['jumlah']; ?></td>
                <td class="text-right">Rp. <?= $dataservice['total_harga']; ?></td>
            </tr>
        <?php } ?>
        <tr>
            <th colspan="3" class="text-center bg-primary text-white text-uppercase">total service</th>
            <th class="text-center bg-primary text-white"></th>
            <th class="text-right bg-primary text-white">Rp. <?= $totalservice; ?></th>

        <tr class="bg-primary text-white font-weight-bold">
            <td class="text-center text-uppercase bg-primary text-white" colspan="3">total pemasukan</td>
            <td class="text-center text-uppercase bg-primary text-white"></td>
            <td class="text-right bg-primary text-white">Rp. <?= $totalservice + $TotalPenjualan; ?></td>
        </tr>
        <tr>
            <th colspan="7">PENGELUARAN</th>
        </tr>
        <tr>
            <th class="text-center">1.</th>
            <th colspan="3">Pembelian</th>
            <th class="text-right"></th>
        </tr>
        <?php
        $totalpembelian = 0;
        $pembelian = query("SELECT transaksi.*, detail_pembelian.*, barang.*
                            FROM transaksi INNER JOIN detail_pembelian ON transaksi.id_detail_pembelian = detail_pembelian.id_pembelian
                            INNER JOIN barang ON detail_pembelian.id_barang = barang.id_brg where tgl = '$tgl'");
        foreach ($pembelian as $datapembelian) {
            $totalpembelian += $datapembelian['total'];
        ?>

            <tr>
                <th></th>
                <th><?= $datapembelian['no_transaksi']; ?></th>
                <th><?= $datapembelian['nama_brg']; ?></th>
                <td class="text-center"><?= $datapembelian['jumlah']; ?></td>
                <th class="text-right">Rp. <?= $datapembelian['total']; ?></th>
            </tr>
        <?php } ?>
        <tr class="bg-primary text-white font-weight-bold">
            <td class="text-center text-uppercase bg-primary text-white" colspan="3">total pembelian</td>
            <td class="text-right bg-primary text-white"></td>
            <td class="text-right bg-primary text-white">Rp. <?= $totalpembelian; ?></td>
        </tr>
        <tr class="bg-primary text-white font-weight-bold">
            <td class="text-center text-uppercase bg-primary text-white" colspan="3">Total kas</td>
            <td class="text-right bg-primary text-white"></td>
            <td class="text-right bg-primary text-white">Rp. <?= ($totalservice + $TotalPenjualan) - $totalpembelian; ?></td>
        </tr>
    </tbody>
</table>


<!-- <p class="text-center">Thank you for your Business.</p> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
		window.print();
	</script>
</body>
</html>