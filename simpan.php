<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang  = $_POST['nama_barang'];
    $jumlah       = $_POST['jumlah'];
    $satuan       = $_POST['satuan'];
    $unit_pengaju = $_POST['unit_pengaju'];

    $query = "INSERT INTO pengajuan (nama_barang, jumlah, satuan, unit_pengaju, status) 
              VALUES ('$nama_barang', '$jumlah', '$satuan', '$unit_pengaju', 'Pending')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: index.php?status=sukses");
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
}
?>