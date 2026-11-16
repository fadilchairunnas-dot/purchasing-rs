<?php
// Tampilkan error jika ada masalah
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host     = "localhost";
$user     = "root";
$password = "";
$database = "db_purchasing_rs";
$port     = 3307;

$koneksi = mysqli_connect($host, $user, $password, $database, $port);

if (!$koneksi) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}
?>