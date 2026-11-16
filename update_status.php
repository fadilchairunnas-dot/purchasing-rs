<?php
include 'koneksi.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id_pengajuan = $_GET['id'];
    $status_baru  = $_GET['status'];

    $query = "UPDATE pengajuan SET status = '$status_baru' WHERE id_pengajuan = '$id_pengajuan'";

    if (mysqli_query($koneksi, $query)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Gagal memperbarui status: " . mysqli_error($koneksi);
    }
}
?>