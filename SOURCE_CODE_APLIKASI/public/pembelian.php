<div class="container-fluid py-2">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3" style="text-align:left; ">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addbarang">
                                Add Pembelian
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
                                                            Nama Barang</th>
                                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                                            Jumlah</th>
                                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                                            Total</th>
                                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                                            Tanggal</th>
                                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $sql = query("SELECT detail_pembelian.*, barang.*
                                                    FROM detail_pembelian 
                                                    INNER JOIN barang ON detail_pembelian.id_barang = barang.id_brg");
                                                    foreach ($sql as $data) :
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?= $no++; ?></td>
                                                            <td class="text-center"><?= $data['nama_brg']; ?></td>
                                                            <td class="text-center"><?= $data['jumlah']; ?></td>
                                                            <td class="text-center"><?= $data['total']; ?></td>
                                                            <td class="text-center"><?= $data['tgl']; ?></td>
                                                            <td class="text-center">
                                                                <a class="btn btn-primary btn-sm" href="?page=pembelian&action=edit&kode=<?= base64_encode($data['id_pembelian']); ?>" data-bs-toggle="modal" data-bs-target="#editbarang-<?= base64_encode($data['id_pembelian']); ?>">
                                                                    <span class="glyphicon glyphicon-pencil"></span>

                                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                                </a>
                                                                <a href="?page=pembelian&action=delete&kode=<?= base64_encode($data['id_pembelian']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure ?')">
                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>
                                                            </td>

                                                            <div class="modal fade" id="editbarang-<?= base64_encode($data['id_pembelian']); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit pembelian</h1>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="" method="post" class="row g-3">
                                                                                <div class="form-group col-md-12">
                                                                                    <input type="hidden" name="id_pembelian" value="<?= $data['id_pembelian'] ?>">
                                                                                    <label class="control-label">Nama pembelian</label>
                                                                                    <input type="text" class="form-control" placeholder="Nama pembelian" name="nama_kate_edit" required value="<?= $data['nama_kate']; ?>">
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                    <button type="submit" name="save_edit_kate" class="btn btn-primary">Save</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php
                                                    endforeach;
                                                        ?>
                                                        </tr>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Pembelian</h1>
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
                        <div class="form-group col-md-6">
                            <label class="control-label">jumlah</label>
                            <input type="number" class="form-control" placeholder="Jumlah Barang" name="jumlah" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="save_add_penjualan" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['save_add_penjualan'])) {
        if (addPembelian($_POST) > 0) {
            echo "<script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your data has been saved',
                    showConfirmButton: false,
                    timer: 1500
                    });
                </script>";
            echo  '<meta http-equiv=refresh content=2;url=?page=pembelian&action=list';
        } else {
            echo "<script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Oops..',
                    showConfirmButton: false,
                    timer: 1500
                    });
                </script>";
            echo  '<meta http-equiv=refresh content=2;url=?page=pembelian&action=list';
        }
    }

    if (isset($_GET["kode"])) {
        if (deletekate($_GET) > 0) {
            echo "<script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your data has been deleted',
                    showConfirmButton: false,
                    timer: 1500
                    });
                </script>";

            echo  '<meta http-equiv=refresh content=1;url=?page=pembelian&action=list';
        }
    }

    if (isset($_POST['save_edit_pembelian']) ) {
        if (editpembelian($_POST) > 0) {
            echo "<script>
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your data has been saved',
                        showConfirmButton: false,
                        timer: 1000
                        });
                    </script>";
            echo  '<meta http-equiv=refresh content=2;url=?page=pembelian&action=list';
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
            echo  '<meta http-equiv=refresh content=2;url=?page=pembelian&action=list';
        }
    }
    ?>