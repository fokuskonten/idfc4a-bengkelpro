<div class="container-fluid py-4">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3" style="text-align:left; ">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addbarang">
                                Add Barang
                            </button>
                        </div>
                        <div class="col-sm-6" style="text-align:right; ">
                            <!-- <a href="" class="btn btn-info btn-outline m-b-10">Pdf</a>
                                        <a href="" class="btn btn-info btn-outline m-b-10">Excel</a> -->
                        </div>
                        <div class="col-sm-3">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-1">
                                <div class="card-body px-4 pt-2 pb-2">
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
                                                            Nama Kategori</th>
                                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                                            harga</th>
                                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                                            Stok</th>
                                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                                            Image</th>
                                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $sql = $conn->query("SELECT * FROM barang INNER JOIN kategori ON barang.id_kate = kategori.id_kate");

                                                    foreach ($sql as $data) :
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?= $no++; ?></td>
                                                            <td class="text-center" style="word-wrap: break-word;min-width: 160px;max-width: 10px;"><?= $data['nama_brg']; ?></td>
                                                            <td class="text-center"><?= $data['nama_kate']; ?></td>
                                                            <td class="text-center">Rp.<?= $data['harga']; ?></td>
                                                            <td class="text-center"><?= $data['stok']; ?></td>
                                                            <td class="text-center">
                                                                <img src="<?= './public/uploads/barang/' . $data['img']; ?>" width="100">
                                                            </td>
                                                            <td class="text-center">
                                                                <a class="btn btn-primary btn-sm" href="?page=kategori&action=edit&kode=<?= base64_encode($data['id_brg']); ?>" data-bs-toggle="modal" data-bs-target="#editbarang-<?= base64_encode($data['id_brg']); ?>">
                                                                    <span class="glyphicon glyphicon-pencil"></span>

                                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                                </a>
                                                                <a href="?page=barang&action=delete&kode=<?= base64_encode($data['id_brg']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure ?')">
                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>
                                                            </td>

                                                            <div class="modal fade" id="editbarang-<?= base64_encode($data['id_brg']); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Barang</h1>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body row">
                                                                            <form action="" method="post" class="g-3" enctype="multipart/form-data">
                                                                                <input  type="hidden" name="id_barang" value="<?= $data['id_brg']; ?>">
                                                                                <input  type="hidden" name="gambarLama" value="<?= $data['img']; ?>">
                                                                                <div class="form-group col-md-12 text-center">
                                                                                    <label class="control-label">Gambar</label><br>
                                                                                    <img src="<?= './public/uploads/barang/' . $data['img']; ?>" width="150">
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label class="control-label">Nama Barang</label>
                                                                                    <input type="text" class="form-control" placeholder="Nama Barang" value="<?= $data['nama_brg']; ?>" name="nama_brg" required>
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label class="control-label">Kategory</label>
                                                                                    <select class="form-control" name="kategory">
                                                                                        <?php
                                                                                        $id = base64_decode(base64_encode($data['id_kate']));
                                                                                        $sql = $conn->query("SELECT * FROM kategori ");
                                                                                        foreach ($sql as $kate) :
                                                                                        ?>
                                                                                            <option value="<?= $kate['id_kate']; ?>"><?= $kate['nama_kate']; ?></option>
                                                                                        <?php endforeach; ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group  col-md-4">
                                                                                    <label class="control-label">Harga</label>
                                                                                    <input type="number" class="form-control" placeholder="Harga" value="<?= $data['harga']; ?>" name="harga" required>
                                                                                </div>
                                                                                <div class="form-group col-md-4">
                                                                                    <label class="control-label">Gambar</label>
                                                                                    <input type="file" class="form-control" name="gambar"  required>
                                                                                </div>
                                                                                <div class="form-group col-md-4">
                                                                                    <label class="control-label">Stok</label>
                                                                                    <input type="number" class="form-control" name="stok" value="<?= $data['stok']; ?>" placeholder="Stok" required>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                                                                    <button type="submit" name="save_edit_barang" class="btn btn-primary">Save</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php
                                                    endforeach;
                                                    if (isset($_POST['save_edit_barang']) && $_POST['id_barang']) {
                                                        if ( Editbarang($_POST) >  0 ) {
                                                            echo "<script>
                                                                Swal.fire({
                                                                    position: 'top-end',
                                                                    icon: 'success',
                                                                    title: 'Your data has been saved',
                                                                    showConfirmButton: false,
                                                                    timer: 1000
                                                                    });
                                                                </script>";
                                                            echo  '<meta http-equiv=refresh content=2;url=?page=barang&action=list';
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
                                                            echo  '<meta http-equiv=refresh content=2;url=?page=barang&action=list';
                                                        }    
                                                    }
                                                        ?>
                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- *************************Basic table end -->
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Barang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" class="row g-3" enctype="multipart/form-data">
                        <div class="form-group col-md-6">
                            <label class="control-label">Nama Barang</label>
                            <input type="text" class="form-control" placeholder="Nama Barang" name="nama_brg" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Kategory</label>
                            <select class="form-control" name="kategory">
                                <?php
                                $sql = $conn->query("SELECT * FROM kategori");
                                foreach ($sql as $data) :
                                ?>
                                    <option value="<?= $data['id_kate']; ?>"><?= $data['nama_kate']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group  col-md-4">
                            <label class="control-label">Harga</label>
                            <input type="number" class="form-control" placeholder="Harga" name="harga" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label">Gambar</label>
                            <input type="file" class="form-control" name="gambar" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label">Stok</label>
                            <input type="number" class="form-control" name="stok" placeholder="Stok" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="save_add_barang" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['save_add_barang'])) {
        if (addbarang($_POST)  > 0) {
            echo "<script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Your data has been saved',
                showConfirmButton: false,
                timer: 1500
                });
            </script>";
            echo  '<meta http-equiv=refresh content=2;url=?page=barang&action=list';
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
            echo  '<meta http-equiv=refresh content=2;url=?page=barang&action=list';
        }


    }
    if (isset($_POST['save_edit_barang'])) {
        if (Editbarang($_POST)  > 0) {
            echo "<script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Your data has been saved',
                showConfirmButton: false,
                timer: 1500
                });
            </script>";
            echo  '<meta http-equiv=refresh content=2;url=?page=barang&action=list';
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
            echo  '<meta http-equiv=refresh content=2;url=?page=barang&action=list';
        }
    }

    if (isset($_GET["kode"])) {
        if (Deletebarang($_GET) > 0) {
            echo "<script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your data has been deleted',
                    showConfirmButton: false,
                    timer: 1500
                    });
                </script>";

            echo  '<meta http-equiv=refresh content=1;url=?page=barang&action=list';
        }
    }
