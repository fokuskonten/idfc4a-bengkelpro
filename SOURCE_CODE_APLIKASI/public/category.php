<div class="container-fluid py-2">

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3" style="text-align:left; ">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addbarang">
                                Add kategori
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
                                                        <th class="text-left text-uppercase text-xs font-weight-bolder">
                                                            Nama Kategori</th>
                                                        <th class="text-center text-uppercase text-xs font-weight-bolder">
                                                            Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $sql = query("SELECT * FROM kategori ORDER BY  id_kate ASC");
                                                    foreach ($sql as $data) :
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?= $no++; ?></td>
                                                            <td class="text-left"><?= $data['nama_kate']; ?></td>
                                                            <td class="text-center">
                                                                <a class="btn btn-primary btn-sm" href="?page=kategori&action=edit&kode=<?= base64_encode($data['id_kate']); ?>" data-bs-toggle="modal" data-bs-target="#editbarang-<?= base64_encode($data['id_kate']); ?>">
                                                                    <span class="glyphicon glyphicon-pencil"></span>

                                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                                </a>
                                                                <a href="?page=kategori&action=delete&kode=<?= base64_encode($data['id_kate']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure ?')">
                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>
                                                            </td>

                                                            <div class="modal fade" id="editbarang-<?= base64_encode($data['id_kate']); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Kategori</h1>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="" method="post" class="row g-3">
                                                                                <div class="form-group col-md-12">
                                                                                    <input type="hidden" name="id_kate" value="<?= $data['id_kate'] ?>">
                                                                                    <label class="control-label">Nama kategori</label>
                                                                                    <input type="text" class="form-control" placeholder="Nama Kategori" name="nama_kate_edit" required value="<?= $data['nama_kate']; ?>">
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Kategori</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" class="row g-3">
                        <div class="form-group col-md-12">
                            <label class="control-label">Nama kategori</label>
                            <input type="text" class="form-control" placeholder="Nama Kategori" name="nama_kate" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="save_add_kate" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['save_add_kate'])) {      
        if (addkate($_POST) > 0) {
            echo "<script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your data has been saved',
                    showConfirmButton: false,
                    timer: 1500
                    });
                </script>";
            echo  '<meta http-equiv=refresh content=2;url=?page=kategori&action=list';
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
            echo  '<meta http-equiv=refresh content=2;url=?page=kategori&action=list';
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

            echo  '<meta http-equiv=refresh content=1;url=?page=kategori&action=list';
        }
    }

    if (isset($_POST['save_edit_kate']) && isset($_POST['id_kate'])) {
        if (editkate($_POST) > 0) {
            echo "<script>
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your data has been saved',
                        showConfirmButton: false,
                        timer: 1000
                        });
                    </script>";
            echo  '<meta http-equiv=refresh content=2;url=?page=kategori&action=list';
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
            echo  '<meta http-equiv=refresh content=2;url=?page=kategori&action=list';
        }
    }
    ?>