<?php
include "db.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) die("ID tidak valid.");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Struk Pesanan ID <?= $id ?></title>

<style>
    body {
        background: #f4f4f4;
        font-family: monospace;
        padding: 20px;
    }

    .struk {
        width: 350px;
        background: #fff;
        border: 1px dashed #000;
        padding: 15px;
        margin: 0 auto;
    }

    .judul {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        border-bottom: 1px dashed #000;
        padding-bottom: 5px;
        margin-bottom: 10px;
    }

    .line {
        border-bottom: 1px dashed #000;
        margin: 7px 0;
    }

    .item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 3px;
        font-size: 13px;
    }

    .total {
        display: flex;
        justify-content: space-between;
        font-weight: bold;
        margin-top: 5px;
        font-size: 14px;
    }

    img {
        width: 100%;
        margin-top: 20px;
        border: 1px solid #000;
    }
</style>
</head>
<body>

<?php
// Ambil pesanan
$stmt = $koneksi->prepare("SELECT * FROM pesanan WHERE id_pesanan = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

$items = $koneksi->query("
    SELECT pi.*, m.nama_menu 
    FROM pesanan_items pi
    JOIN menu m ON pi.id_menu = m.id_menu
    WHERE pi.id_pesanan = $id
");
?>

<div class="struk">

    <div class="judul">WARUNG POHON</div>

    <div><b>ID Pesanan:</b> <?= $row['id_pesanan'] ?></div>
    <div><b>Nama:</b> <?= $row['nama'] ?></div>
    <div><b>Telp:</b> <?= $row['no_telp'] ?></div>

    <div class="line"></div>

    <?php while($it = $items->fetch_assoc()): ?>
        <div class="item">
            <span><?= $it['nama_menu'] ?> × <?= $it['jumlah'] ?></span>
            <span>Rp <?= number_format($it['subtotal']) ?></span>
        </div>
    <?php endwhile; ?>

    <div class="line"></div>

    <div class="total">
        <span>Total:</span>
        <span>Rp <?= number_format($row['total_harga']) ?></span>
    </div>

    <div class="line"></div>

<?php if (!empty($row['bukti']) && file_exists("uploads/" . $row['bukti'])): ?>
    <h4 style="text-align:center;">Bukti Pembayaran</h4>
    <img src="uploads/<?= $row['bukti'] ?>" alt="Bukti Pembayaran">
<?php elseif (!empty($row['bukti'])): ?>
    <p style="color:red;">File bukti tidak ditemukan di folder uploads/.</p>
<?php else: ?>
    <p style="text-align:center;"><b>Bukti pembayaran belum diupload.</b></p>
<?php endif; ?>

<a href="/warungpohon/index.html" class="btn">Kembali</a>

<style>
.btn {
    display: inline-block;
    padding: 10px 20px;
    background: #292727ba;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: bold;
}
.btn:hover {
    background: #d20202dd;
}
</style>


</div>

</body>
</html>
