<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $stok        = (int)$_POST['stok'];
    $satuan      = mysqli_real_escape_string($koneksi, $_POST['satuan']);

    // Simpan barang baru beserta satuannya
    $query = mysqli_query($koneksi, "INSERT INTO barang (nama_barang, stok, satuan) VALUES ('$nama_barang', '$stok', '$satuan')");

    if ($query) {
        echo "<script>alert('Barang berhasil ditambahkan!'); window.location='admin.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan barang!'); window.location='admin.php';</script>";
    }
}
?>