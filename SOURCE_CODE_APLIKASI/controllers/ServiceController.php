<?php

function addService($data)
{
    global $conn;
    if (isset($data)) {
        global $conn;
        $barang = $data['barang'];
        $jumlah = $data['jumlah'];
        $jasa = $data['jasa'];
        $keterangan = $data['keterangan'];
        $harga = $conn->query("SELECT * from barang where id_brg = $barang");
        foreach ($harga as $row) {
            $price = $row['harga'];
            $stok = $row['stok'];
        }
        $total = ($price * $jumlah) + $jasa;
        $totalHarga = $price * $jumlah;
        $no_transaksi = 'SRV-' . uniqid();
        $jenis  = "service";
        $now = date_create();
        $formattedDate = $now->format('Y-m-d');
        // input table detail_service

        if ($stok >= $jumlah && !empty($barang)) {
            $stmt1 = $conn->prepare("INSERT INTO detail_service (id_barang, jumlah, keterangan, total_harga_jasa, total_harga, tgl) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt1->bind_param("iisiis", $barang, $jumlah, $keterangan, $jasa, $total, $formattedDate);

            if ($stmt1->execute()) {
                $id_detail_service = mysqli_insert_id($conn);

                $stmt2 = $conn->prepare("INSERT INTO detail_penjualan (id_barang, tgl, jumlah, total) VALUES (?, ?,  ?, ?)");
                $stmt2->bind_param("isii", $barang, $formattedDate, $jumlah, $totalHarga);

                if ($stmt2->execute()) {
                    $id_penjualan = mysqli_insert_id($conn);

                    $stmt3 = $conn->prepare("INSERT INTO transaksi (no_transaksi, jenis, id_detail_service, id_detail_penjualan, tgl_transaksi) VALUES (?, ?,?,?,?)");
                    $stmt3->bind_param("ssiis", $no_transaksi, $jenis, $id_detail_service,  $id_penjualan, $formattedDate);

                    if ($stmt3->execute()) {
                        $sisa = $stok - $jumlah;

                        if ($stok >= 0) {
                            $stmt4 = $conn->prepare("UPDATE barang SET stok=? WHERE id_brg=?");
                            $stmt4->bind_param("ii", $sisa, $barang);
                        } else {
                            $batasstock = 0;
                            $stmt4 = $conn->prepare("UPDATE barang SET stok=? WHERE id_brg=?");
                            $stmt4->bind_param("ii", $batasstock, $barang);
                        }

                        if ($stmt4->execute()) {
                            return mysqli_stmt_affected_rows($stmt4);
                            $stmt4->close();
                        } else {
                            return false;
                        }
                        $stmt3->close();
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }

                $stmt2->close();
            } else {
                return false;
            }
            $stmt1->close();
        } else {
            return false;
        }
    }
}


function editService($data)
{
  global $conn;
  $barang = $data['barang'];

  if (isset($data)) {
    $id_detail_service = base64_decode($data['id_detail_service']);
    $id_penjualan = base64_decode($data['id_penjualan']);
    // Ambil data detail service lama
    $cekTransaksi = $conn->query("SELECT * FROM transaksi WHERE id_detail_service = '$id_detail_service'");
        foreach ($cekTransaksi  as $row) {
        $id_penjualan = $row['id_detail_penjualan'];
    }

    $cekPenjualan = $conn->query("SELECT * FROM detail_penjualan WHERE id_penjualan = '$id_penjualan'");
        foreach ($cekPenjualan as $penjualan){
            $id_barang = $penjualan['id_barang'];
    }

    $cekBarang = $conn->query("SELECT * FROM barang WHERE id_brg = '$barang'");
        foreach ($cekBarang as $barangs){
            $price = $barangs['harga'];
            $stok =  $barangs['stok'];
        }


    // Dapatkan data baru
    $jumlah = $data['jumlah'];
    $jasa = $data['jasa'];
    $keterangan = $data['keterangan'];
    $now = date_create();
    $formattedDate = $now->format('Y-m-d');
    $total = ($price * $jumlah) + $jasa;
    $totalHarga = $price * $jumlah;

    // Update detail service
    $stmt = $conn->prepare("UPDATE detail_service SET id_barang=?,  jumlah=?, keterangan=?, total_harga_jasa=?, total_harga=? ,tgl=? WHERE id_service=?");
    $stmt->bind_param("iisiisi", $barang,  $jumlah, $keterangan, $jasa, $total, $formattedDate, $id_detail_service);
    if($stmt->execute()){
        return mysqli_stmt_affected_rows($stmt);
    }else{
        return false;
    }
  }
}

function deleteService($data)
{
  global $conn;

  if (isset($data['kode'])) {
    $id_detail_service = base64_decode($data['kode']);

    // Ambil data detail service
    $stmt = $conn->prepare("SELECT * FROM transaksi WHERE id_detail_service = ?");
    $stmt->bind_param("i", $id_detail_service);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $id_penjualan = $row['id_detail_penjualan'];

    // Hapus detail service
    $stmt = $conn->prepare("DELETE FROM detail_service WHERE id_service = ?");
    $stmt->bind_param("i", $id_detail_service);

    // Hapus detail penjualan
    $stmt2 = $conn->prepare("DELETE FROM detail_penjualan WHERE id_penjualan = ?");
    $stmt2->bind_param("i", $id_penjualan);

    // Hapus transaksi
    $stmt3 = $conn->prepare("DELETE FROM transaksi WHERE id_detail_service = ?");
    $stmt3->bind_param("i", $id_detail_service);

    // Jalankan hapus
    if ($stmt3->execute() && $stmt2->execute() && $stmt->execute()) {
      return true;
    } else {
      echo "Terjadi kesalahan saat menghapus data.";
      return false;
    }

    // Tutup koneksi
    $stmt->close();
    $stmt2->close();
    $stmt3->close();
  }
}


