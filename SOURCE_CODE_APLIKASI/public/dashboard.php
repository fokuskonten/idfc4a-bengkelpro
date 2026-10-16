<div class="container-fluid py-4">
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Month's Money</p>
                <?php
                $TotalPenjualan = 0;
                $TotalService = 0;
                $TotalPembelian = 0;
                $sql = query("SELECT month(transaksi.tgl_transaksi) AS bulan, 
                COUNT(*) AS total_transaksi, SUM(detail_penjualan.total) AS total_penjualan, 
                SUM(detail_service.total_harga) AS total_service, 
                SUM(detail_pembelian.total) AS total_pembelian 
                FROM transaksi 
                  LEFT JOIN detail_penjualan ON transaksi.id_detail_penjualan = detail_penjualan.id_penjualan 
                  LEFT JOIN detail_service ON transaksi.id_detail_service = detail_service.id_service 
                  LEFT JOIN detail_pembelian ON transaksi.id_detail_pembelian = detail_pembelian.id_pembelian 
                GROUP BY month(transaksi.tgl_transaksi) HAVING COUNT(*) > 1 ORDER BY bulan;");
                foreach ($sql as $data) {
                  $TotalPenjualan = $data['total_penjualan'];
                  $TotalService = $data['total_service'];
                  $TotalPembelian = $data['total_pembelian'];
                }
                ?>
                <h5 class="font-weight-bolder">
                  Rp. <?= $TotalPenjualan + $TotalService - $TotalPembelian; ?>
                </h5>
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Month's Sells</p>
                <h5 class="font-weight-bolder">
                  Rp. <?= $TotalPenjualan; ?>
                </h5>

              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">New Service</p>
                <h5 class="font-weight-bolder">
                  Rp. <?= $TotalService; ?>
                </h5>
                <!-- <p class="mb-0">
                      <span class="text-danger text-sm font-weight-bolder">-2%</span>
                      since last quarter
                    </p> -->
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">

              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Buy Stocks</p>
                <h5 class="font-weight-bolder">
                  Rp. <?= $TotalPembelian; ?>
                </h5>
                <!-- <p class="mb-0">
                      <span class="text-success text-sm font-weight-bolder">+5%</span> than last month
                    </p> -->
              </div>
            </div>
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
      <div class="card z-index-2 h-100">
        <div class="card-header pb-0 pt-3 bg-transparent">
          <h6 class="text-capitalize">Sales overview</h6>
          <!-- <p class="text-sm mb-0">
                <i class="fa fa-arrow-up text-success"></i>
                <span class="font-weight-bold">4% more</span> in 2021
              </p> -->
        </div>
        <div class="card-body p-3">
          <div class="chart">
            <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
          </div>
        </div>
      </div>
    </div>

  </div>

