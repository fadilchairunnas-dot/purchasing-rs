<?php
session_start();
include 'koneksi.php'; 

// Proteksi: Harus login dan role harus admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    echo "<script>alert('Akses ditolak! Halaman ini khusus Admin Purchasing.'); window.location='login.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Purchasing - Admin</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f6f9; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { border-bottom: 2px solid #007bff; padding-bottom: 8px; color: #333; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #dee2e6; padding: 10px; text-align: left; }
        th { background-color: #343a40; color: white; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        .btn { padding: 6px 10px; text-decoration: none; border-radius: 4px; color: white; font-size: 12px; margin-right: 2px; display: inline-block; }
        .btn-approve { background-color: #28a745; }
        .btn-kirim { background-color: #17a2b8; }
        .btn-reject { background-color: #dc3545; }
        .badge { padding: 5px 8px; border-radius: 4px; font-weight: bold; color: white; }
        .bg-Pending { background-color: #ffc107; color: black; }
        .bg-Approved { background-color: #28a745; }
        .bg-Proses-Pengiriman { background-color: #17a2b8; }
        .bg-Rejected { background-color: #dc3545; }
        .bg-Selesai { background-color: #6c757d; }
    </style>
</head>
<body>

<div class="container">
    <h2>Kelola Pengajuan Barang (Petugas Purchasing)</h2>
    <p><a href="index.php">← Kembali ke Form Pengajuan Unit</a></p>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Qty</th>
            <th>Unit</th>
            <th>Status Saat Ini</th>
            <th>Aksi Ubah Status</th>
        </tr>
        <?php
        $no = 1;
        $query = mysqli_query($koneksi, "SELECT * FROM pengajuan ORDER BY id_pengajuan DESC");

        if (!$query) {
            die("Query Error: " . mysqli_error($koneksi));
        }

        while ($row = mysqli_fetch_assoc($query)) {
            $status_class = str_replace(' ', '-', $row['status']);
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama_barang']; ?></td>
                <td><?= $row['jumlah'] . ' ' . $row['satuan']; ?></td>
                <td><?= $row['unit_pengaju']; ?></td>
                <td><span class="badge bg-<?= $status_class; ?>"><?= $row['status']; ?></span></td>
                <td>
                    <a href="update_status.php?id=<?= $row['id_pengajuan']; ?>&status=Approved" class="btn btn-approve">Setuju</a>
                    <a href="update_status.php?id=<?= $row['id_pengajuan']; ?>&status=Proses Pengiriman" class="btn btn-kirim">Proses Kirim</a>
                    <a href="update_status.php?id=<?= $row['id_pengajuan']; ?>&status=Rejected" class="btn btn-reject">Tolak</a>
                    <a href="update_status.php?id=<?= $row['id_pengajuan']; ?>&status=Selesai" class="btn" style="background-color: #6c757d; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px;">Selesai</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <hr style="margin-top: 40px;">
  <!-- Form Tambah Barang Baru -->
<div style="background-color: #f8f9fa; border: 1px solid #dee2e6; padding: 15px; border-radius: 5px; margin-top: 30px; margin-bottom: 20px;">
    <h4 style="margin-top: 0; margin-bottom: 10px;">+ Tambah Barang Baru</h4>
    <form action="tambah_barang.php" method="POST" style="display: flex; gap: 10px; align-items: center;">
        <input type="text" name="nama_barang" placeholder="Nama Barang (misal: Tinta Printer)" required style="padding: 6px; width: 220px;">
        <input type="number" name="stok" placeholder="Jumlah Stok" min="0" required style="padding: 6px; width: 100px;">
        <input type="text" name="satuan" placeholder="Satuan (misal: botol/box/pcs)" required style="padding: 6px; width: 150px;">
        <button type="submit" style="background-color: #28a745; color: white; border: none; padding: 7px 15px; border-radius: 3px; cursor: pointer;">Simpan Barang</button>
    </form>
</div>
<h3>Kelola Stok Barang</h3>
<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #343a40; color: white;">
            <th>No</th>
            <th>Nama Barang</th>
            <th>Stok Saat Ini</th>
            <th>Aksi Update Stok</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no_b = 1;
        $data_b = mysqli_query($koneksi, "SELECT * FROM barang");
        while ($b = mysqli_fetch_assoc($data_b)) {
        ?>
        <tr>
            <td><?= $no_b++; ?></td>
            <td><?= $b['nama_barang']; ?></td>
            <td><b><?= $b['stok'] . ' ' . $b['satuan']; ?></b></td>
            <td>
                <form action="update_stok.php" method="POST" style="display: flex; gap: 5px;">
                    <input type="hidden" name="id_barang" value="<?= $b['id_barang']; ?>">
                    <input type="number" name="stok_baru" value="<?= $b['stok']; ?>" min="0" style="width: 70px; padding: 4px;">
                    <button type="submit" style="background-color: #007bff; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">Update</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

      
    </thead>
    <tbody>
    
    </tbody>
</table>
</div>

</body>
</html>