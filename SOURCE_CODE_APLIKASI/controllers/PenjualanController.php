<?php
require './config/koneksi.php';

function addPenjualan($data)
{
    if (!empty($data)) {
        $no_transaksi = 'PNJ-' . uniqid();
        $jenis  = "penjualan";

        global $conn;
        $id_barang = $data['barang'];
        $jumlah = $data['jumlah'];
        if (!empty($id_barang)) {
            $harga = $conn->query("SELECT * from barang where id_brg = $id_barang");
            foreach ($harga as $row) {
                $price = $row['harga'];
                $stok =  $row['stok'];
            }
            $total = $price*$jumlah;
        }
        $now = date_create();
        $formattedDate = $now->format('Y-m-d');
        $stmt = $conn->prepare("INSERT INTO detail_penjualan (id_barang , tgl, jumlah, total) VALUES (?,?,?,?)");
        $stmt->bind_param("isii", $id_barang, $formattedDate, $jumlah, $total);
        if($stmt->execute()){
            $id_detail_penjualan = mysqli_insert_id($conn);
            $stmt2 = $conn->prepare("INSERT INTO transaksi (no_transaksi, jenis,id_detail_penjualan,tgl_transaksi) VALUES (?, ?, ?, ?)" );
            $stmt2->bind_param("ssis",$no_transaksi, $jenis, $id_detail_penjualan, $formattedDate);
            if($stmt2->execute()){
                if($stok >= 0){
                    $stmt3 = $conn->prepare("UPDATE barang SET stok=? WHERE id_brg=?" );
                    $newStok = $stok - $jumlah;
                    $stmt3->bind_param("ii",$newStok,$id_barang);
                    $stmt3->execute();
                    return mysqli_stmt_affected_rows($stmt2);
                }
            }
        }else{
            return false;
        }
    }
}

function editPenjualan($data){
    if (!empty($data)) {
        // var_dump($data);
        global $conn;
        $id_penjualan = $data['id_penjualan'];
        $id_barang = $data['barang'];
        $jumlah = $data['jumlah'];
        if (!empty($id_barang)) {
            $harga = $conn->query("SELECT * from barang where id_brg = $id_barang");
            foreach ($harga as $row) {
                $price = $row['harga'];
            }
            $total = $price*$jumlah;
        }
        $now = date_create();
        $formattedDate = $now->format('Y-m-d');
        $stmt = $conn->prepare("UPDATE detail_penjualan SET id_barang=?, tgl=?, jumlah=?, total=? WHERE id_penjualan=?");
        $stmt->bind_param("isiii", $id_barang, $formattedDate, $jumlah, $total, $id_penjualan);
        if($stmt->execute()){
            return mysqli_stmt_affected_rows($stmt);
        }else{
            return false;
        }
    }
}

function DeletePenjualan($data){
    if(!empty($data)){
        global $conn;
        $id_penjualan = base64_decode($data["kode"]);
        $stmt = $conn->prepare("DELETE FROM transaksi WHERE id_detail_penjualan=?");
        $stmt->bind_param("i", $id_penjualan);
        if($stmt->execute()){
            $stmt2 = $conn->prepare("DELETE FROM detail_penjualan WHERE id_penjualan=?");
            $stmt2->bind_param("i", $id_penjualan);
            $stmt2->execute();
            return mysqli_stmt_affected_rows($stmt2);
        }else{
            return false;
        }
    }
}
