<?php
function upload()
{
    $name_file  = $_FILES['gambar']['name'];
    $size = $_FILES["gambar"]["size"];
    $error = $_FILES['gambar']['error'];
    $tmp = $_FILES['gambar']['tmp_name'];

    $ekstensiaGambarValid = ['jpg', 'png', 'jpeg'];
    $ekstensi = explode('.', $name_file);
    $ekstensi = strtolower(end($ekstensi));

    // cek ekstensi gambar
    if (!in_array($ekstensi, $ekstensiaGambarValid)) {
        echo "<script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Oops..',
                    text: 'Ekstensi gambar tidak valid!',
                    showConfirmButton: false,
                    timer: 1500
                    });
                </script>";
        return false;
    }

    // cek ukuran gambar
    if ($size > 1000000) {
        echo "<script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Oops..',
                    text: 'Ukuran gambar terlalu besar!',
                    showConfirmButton: false,
                    timer: 1500
                    });
                </script>";
        return false;
    }

    $namaBaru = uniqid();
    $namaBaru .= '.';
    $namaBaru .=  $ekstensi;

    // gambar siap diapload
    move_uploaded_file($tmp, 'public/uploads/barang/' . $namaBaru);
    return $namaBaru;
}

function addbarang($data)
{
    global $conn;
    $nama_brg = $_POST['nama_brg'];
    $id_kate = $_POST['kategory'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $gambar = upload();

    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO barang(nama_brg, id_kate, harga, img, stok) VALUES ('$nama_brg', '$id_kate', '$harga','$gambar','$stok')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function  Editbarang($data)
{
    global $conn;
    $nama_brg = $data['nama_brg'];
    $id_kate = $data['kategory'];
    $harga = $data['harga'];
    $stok = $data['stok'];
    $id = $data['id_barang'];

    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $data['gambarLama'];
    } else {
        $gambar = upload();
    }
    mysqli_query($conn, "UPDATE barang SET nama_brg = '$nama_brg', id_kate = '$id_kate', harga = '$harga', img = '$gambar', stok = '$stok' WHERE id_brg='$id'");
    return  mysqli_affected_rows($conn);
}

function Deletebarang($data){
    global $conn;
    $id = base64_decode($data['kode']);
    mysqli_query($conn, "DELETE FROM barang where id_brg='$id'");
    return mysqli_affected_rows( $conn );
}
