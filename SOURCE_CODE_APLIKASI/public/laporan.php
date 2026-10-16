<div class="container-fluid py-2">

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="row">

          </div>
          <div class="row">
            <div class="col-lg-8" style="text-align:left; ">
              <p class="fs-4 text-uppercase">tanggal : <?= $_GET['tgl']; ?></p>
            </div>
            <div class="col-lg-3" style="text-align:right; ">
              <form class="input-group btn-group btn-group-sm" action="" method="get" aria-label="Small button group" id="search">
                <span class="input-group-text text-body"><button class=""><i class="fas fa-search" aria-hidden="true"></i></button></span>
                <input type="date" class="form-control" name="tgl" id="tanggal" onfocus="focused(this)" onfocusout="defocused(this)">
              </form>
            </div>
            <div class="col-lg-1" style="text-align:right; ">
              <a class="btn btn-primary btn-lg" href="public/printlaporan.php?tgl=<?= $_GET['tgl']; ?>" target="_blank">Print</a>
            </div>
            <div class="col-12">
              <div class="card mb-1">
                <div class="card-body px-2 pt-2 pb-2">
                  <div class="table-container">
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
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>


  <script>

  </script>