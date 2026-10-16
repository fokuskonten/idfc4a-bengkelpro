 <?php

    require './config/koneksi.php';

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

    function addkate($data)
    {
        global $conn;
        $nama_kate = $data['nama_kate'];
        $stmt = $conn->prepare("INSERT INTO kategori (nama_kate) VALUES (?)");
        $stmt->bind_Param("s", $nama_kate);
        $stmt->execute();
        return mysqli_stmt_affected_rows($stmt);
    }

    function editkate($data)
    {
        global $conn;
        $nama_kate = $data['nama_kate_edit'];
        $id = $data['id_kate'];
        $stmt = $conn->prepare("UPDATE kategori SET nama_kate = ? WHERE id_kate=?");
        $stmt->bind_param("si", $nama_kate, $id);
        $stmt->execute();
        return  mysqli_stmt_affected_rows($stmt);
    }

    function deletekate($data)
    {
        global $conn;
        $id = base64_decode($data['kode']);
        $stmt = $conn->prepare("DELETE FROM kategori where id_kate=?");
        $stmt->bind_Param("i", $id);
        $stmt->execute();
        return mysqli_stmt_affected_rows($stmt);
    }
