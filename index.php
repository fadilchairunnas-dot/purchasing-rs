<?php
session_start();
include 'koneksi.php';

// Proteksi halaman: Jika belum login, lempar ke login.php
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pengajuan Barang RS</title>
</head>
<body>

<div class="container" style="width: 80%; margin: 20px auto; font-family: Arial, sans-serif;">
    <div style="float: right;">
        Halo, <b><?= $_SESSION['nama_lengkap']; ?></b> (<?= $_SESSION['unit']; ?>) | <a href="logout.php" style="color: red; text-decoration: none; font-weight: bold;">Logout</a>
    </div>

    <h2>Form Pengajuan Barang RS</h2>

    <form action="simpan.php" method="POST">
        <div class="form-group" style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Pilih Barang:</label>
            <select name="nama_barang" required style="width: 100%; padding: 8px;">
                <option value="">-- Pilih Barang --</option>
                <?php
                $query_barang = mysqli_query($koneksi, "SELECT * FROM barang");
                while ($b = mysqli_fetch_assoc($query_barang)) {
                    if ($b['stok'] > 0) {
                        echo "<option value='".$b['nama_barang']."'>".$b['nama_barang']." (Stok: ".$b['stok']." ".$b['satuan'].")</option>";
                    } else {
                        echo "<option value='' disabled style='color: red;'>".$b['nama_barang']." - [STOK HABIS]</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Jumlah (Qty):</label>
            <input type="number" name="jumlah" min="1" required style="width: 100%; padding: 8px; box-sizing: border-box;">
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Satuan:</label>
            <input type="text" name="satuan" placeholder="Contoh: Box, Botol, Roll, Pcs" required style="width: 100%; padding: 8px; box-sizing: border-box;">
        </div>

        <!-- Input Unit Pengaju Terisi Otomatis & Lock (Readonly) -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Unit Pengaju:</label>
            <input type="text" name="unit_pengaju" value="<?= $_SESSION['unit']; ?>" readonly style="width: 100%; padding: 8px; background-color: #e9ecef; cursor: not-allowed; box-sizing: border-box;">
        </div>

        <button type="submit" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; cursor: pointer; font-weight: bold; border-radius: 4px;">Kirim Pengajuan</button>
    </form>

    <hr style="margin-top: 30px; margin-bottom: 20px;">

    <h3>Riwayat Pengajuan Barang</h3>
    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Unit Pengaju</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($koneksi, "SELECT * FROM pengajuan ORDER BY id_pengajuan DESC");
            while ($row = mysqli_fetch_assoc($query)) {
                echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['nama_barang']}</td>
                    <td>{$row['jumlah']}</td>
                    <td>{$row['satuan']}</td>
                    <td>{$row['unit_pengaju']}</td>
                    <td>{$row['status']}</td>
                    <td>{$row['tanggal_pengajuan']}</td>
                </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>