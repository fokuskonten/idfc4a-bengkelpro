<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            padding: 20px;
        }

        .bg-primary {
            background-color: #007bff;
            color: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }


        th,
        td {
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
    <div class="invoice-header">

        <!-- Row start -->
        <div class="row fs-5">
            <div class="col-sm-6 gutters fw-bolder  text-primary text-uppercase fst-italic">
                BengkelPro
            </div>

            <div class="col-sm-6">
                <address class="text-right fs-6">
                    Layanan Servis & Suku Cadang Resmi<br />Sistem Bengkel Modern Terintegrasi
                </address>
            </div>
        </div>
        <!-- Row end -->


    </div>
    <?php
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

    if (!empty($_GET['kode'])) {
        require_once '../../config/koneksi.php';
        $id_service = base64_decode($_GET['kode']);
        $sql = query("SELECT transaksi.*, detail_service.*, barang.* FROM transaksi INNER JOIN detail_service ON transaksi.id_detail_service = detail_service.id_service 
        INNER JOIN barang ON detail_service.id_barang = barang.id_brg WHERE detail_service.id_service = '$id_service'");
    }
    ?>
    <table class="table table-hover table-striped table-bordered">
        <thead class="bg-primary text-dark">
           <?php 
                foreach($sql as $data):
           ?>
            <tr>
                <th colspan="6" class="text-center">Tanggal : <?= $data['tgl']; ?></th>
            </tr>
           <?php endforeach; ?>
            <tr>
                <th class="text-center" colspan="5">Uraian</th>
                <th class="text-center">Total</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($sql as $data) :
            ?>
            <tr>
                <th colspan="4">Service</th>
                <th class="text-center">jumlah</th>
                <th class="text-center"></th>
            </tr>

                <tr>
                    <th><?= $data['no_transaksi']; ?></th>
                    <td colspan="4"><?= $data['keterangan']; ?></td>
                    <td class="text-right">RP. <?= $data['total_harga_jasa']; ?></td>
                </tr>
                <tr>
                    <th></th>
                    <th colspan="3"><?= $data['nama_brg']; ?></th>
                    <td align="right"><?= $data['jumlah']; ?></td>
                    <td class="text-right">RP. <?= $data['harga'] * $data['jumlah'] ?></td>
                </tr>

            <tr class="bg-primary text-white font-weight-bold">
                <td class="text-center text-uppercase" colspan="5">TOTAL</td>
                <td class="text-right">Rp. <?= ($data['harga'] * $data['jumlah']) + $data['total_harga_jasa']  ?></td>
            </tr>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>


    <p class="text-center">Thank you for your Business.</p>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        window.print();
    </script>
</body>

</html>