<div class="container-fluid py-2">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3" style="text-align:left; ">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addbarang">
                                Add New Services
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-1">
                                <div class="card-body px-4 pt-2 pb-2 ">
                                    <div class="table-container">
                                        <!-- <h5 class="table-title">Basic Example</h5> -->
                                        <div class="table-responsive">
                                            <table id="basicExample" class="table m-0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center text-uppercase text-xs font-weight-bolder">No
                                                        </th>
                                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                                            No Transaksi</th>
                                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                                            Jenis</th>
                                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                                            barang</th>
                                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                                            jumlah</th>
                                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                                            keterangan</th>
                                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                                            Total</th>
                                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $sql = query("SELECT transaksi.*, detail_service.*, barang.*
                                                    FROM transaksi
                                                    INNER JOIN detail_service ON transaksi.id_detail_service = detail_service.id_service
                                                    INNER JOIN barang ON detail_service.id_barang = barang.id_brg");
                                                    foreach ($sql as $data) :
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?= $no++; ?></td>
                                                            <td class="text-center"><?= $data['no_transaksi']; ?></td>
                                                            <td class="text-center"><?= $data['jenis']; ?></td>

                                                            <td class="text-center  text-wrap"><?= $data['nama_brg']; ?></td>
                                                            <td class="text-center"><?= $data['jumlah']; ?></td>

                                                            <td class="text-center"><?= $data['keterangan']; ?></td>
                                                            <td class="text-center">Rp.<?= $data['total_harga']; ?></td>
                                                            <td class="text-center">
                                                                <a href="./public/invoice/printService.php?kode=<?= base64_encode($data['id_detail_service']); ?>" class="btn btn-secondary btn-sm">
                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                    <i class="fa fa-print" aria-hidden="true"></i>
                                                                </a>
                                                                <a class="btn btn-primary btn-sm" href="?page=service&action=edit&kode=<?= base64_encode($data['id_detail_service']); ?>" data-bs-toggle="modal" data-bs-target="#editbarang-<?= base64_encode($data['id_detail_service']); ?>">
                                                                    <span class="glyphicon glyphicon-pencil"></span>

                                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                                </a>
                                                                <a href="?page=service&action=delete&kode=<?= base64_encode($data['id_detail_service']); ?>"  class="btn btn-danger btn-sm" onclick="return confirm('Are you sure ?')">
                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>
                                                            </td>
                                                        </tr>

                                                        <!-- Edit -->
                                                        <div class="modal fade" id="editbarang-<?= base64_encode($data['id_detail_service']); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Services</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body row">
                                                                        <form action="" method="post" class="row g-3">
                                                                            <input type="hidden" name="id_transaksi" value="<?= base64_encode($data['id_transaksi']); ?>">
                                                                            <input type="hidden" name="id_detail_service" value="<?= base64_encode($data['id_detail_service']); ?>">
                                                                            <input type="hidden" name="id_penjualan" value="<?= base64_encode($data['id_detail_penjualan']); ?>">
                                                                            <div class="form-group col-md-6">
                                                                                <label class="control-label">Barang</label>
                                                                                <select class="form-control" name="barang">
                                                                                    <option value="<?= $data['id_brg']; ?>"><?= $data['nama_brg']; ?></option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group col-md-3">
                                                                                <label class="control-label">jumlah</label>
                                                                                <input type="number" class="form-control" placeholder="Jumlah Barang" name="jumlah" required value="<?= $data['jumlah']; ?>">
                                                                            </div>
                                                                            <div class="form-group col-md-3">
                                                                                <label class="control-label">Harga Jasa</label>
                                                                                <input type="number" class="form-control" placeholder="Harga Jasa" name="jasa" required value="<?= $data['total_harga_jasa']; ?>">
                                                                            </div>
                                                                            <div class="form-group col-md-12">
                                                                                <label class="control-label">keterangan</label>
                                                                                <textarea class="form-control" name="keterangan" id="" rows="3"><?= $data['keterangan']; ?></textarea>
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                <button type="submit" name="save_edit_service" class="btn btn-primary">Save</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- print -->

                                                    <?php
                                                    endforeach;
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- *************************
									Basic table end -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="addbarang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Services</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" class="row g-3">
                        <div class="form-group col-md-6">
                            <label class="control-label">Barang</label>
                            <select class="form-control" name="barang" id="" required>
                                <option value="0">-</option>
                                <?php
                                $sql = $conn->query("SELECT * FROM barang");
                                foreach ($sql as $brg) :
                                ?>
                                    <option value="<?= $brg['id_brg']; ?>"><?= $brg['nama_brg']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label">jumlah</label>
                            <input type="number" class="form-control" placeholder="Jumlah Barang" name="jumlah" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label">Harga Jasa</label>
                            <input type="number" class="form-control" placeholder="Harga Jasa" name="jasa" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">keterangan</label>
                            <textarea class="form-control" name="keterangan" id="" rows="3"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="save_add_service" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php
    if (isset($_POST['save_add_service'])) {
        if (addService($_POST) > 0) {
            echo "<script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your data has been saved',
                    showConfirmButton: false,
                    timer: 1500
                    });
                </script>";
            echo  '<meta http-equiv=refresh content=2;url=?page=service&action=list';
        } else {
            echo "<script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Oops..',
                    text: 'Something went wrong!',
                    showConfirmButton: false,
                    timer: 1500
                    });
                </script>";
            echo  '<meta http-equiv=refresh content=2;url=?page=service&action=list';
        }
    }

    if (isset($_GET["kode"]) && $_GET["action"]== 'delete') {
        if (deleteService($_GET) > 0) {
            echo "<script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your data has been deleted',
                    showConfirmButton: false,
                    timer: 1500
                    });
                </script>";
            echo  '<meta http-equiv=refresh content=1;url=?page=service&action=list';
        }
    }

    if (isset($_POST['save_edit_service']) && isset($_POST['id_transaksi'])) {
        if (editService($_POST) > 0) {
            echo "<script>
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your data has been saved',
                        showConfirmButton: false,
                        timer: 1000
                        });
                    </script>";
            echo  '<meta http-equiv=refresh content=2;url=?page=service&action=list';
        } else {
            echo "<script>
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Ooppss..',
                            showConfirmButton: false,
                            timer: 1000
                            });
                        </script>";
            echo  '<meta http-equiv=refresh content=2;url=?page=service&action=list';
        }
    }


    ?>