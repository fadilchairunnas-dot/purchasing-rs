<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_barang = $_POST['id_barang'];
    $stok_baru = $_POST['stok_baru'];

    $update = mysqli_query($koneksi, "UPDATE barang SET stok = '$stok_baru' WHERE id_barang = '$id_barang'");

    if ($update) {
        echo "<script>alert('Stok berhasil diperbarui!'); window.location='admin.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui stok!'); window.location='admin.php';</script>";
    }
}
?>