<?php
include "db.php";

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) die("ID tidak valid.");

$q = $koneksi->query("SELECT * FROM pesanan WHERE id_pesanan = $id");
$data = $q->fetch_assoc();
if (!$data) die("Pesanan tidak ditemukan.");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Upload Bukti Pembayaran</title>

<style>
    body {
        background: #d6d6d6;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .wrapper {  
        align-item : center;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 5px;
    }

    .card {
        background: #4a4a4a;
        width: 450px;
        border-radius: 8px;
        padding: 25px;
        text-align: center;
        color: white;
        box-shadow: 0 0 10px rgba(0,0,0,0.3);
    }

    .receipt {
        width: 230px;
        margin: 0 auto 20px auto;
        background: white;
        padding: 15px;
        border-radius: 5px;
        color: black;
        font-size: 12px;
        text-align: left;
    }

    .qris {
        width: 230px;
        margin-top: 15px;
        border-radius: 5px;
    }

    .label-text {
        margin-top: 20px;
        font-size: 18px;
        font-weight: bold;
    }

    .file-row {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        color: #d1d1d1;
        font-size: 16px;
    }

    .btn {
        margin-top: 25px;
        padding: 10px 25px;
        font-size: 16px;
        background: white;
        border: none;
        border-radius: 20px;
        cursor: pointer;
    }

    .btn:hover {
        background: #eeeeee;
    }

    .qris
    {
        height : 300px;
        width: ;
    }
</style>

</head>
<body>

<div class="wrapper">
<div class="card">

    <!-- STRUK PESANAN (dummy / bisa ganti dinamis nanti) -->
    <div class="receipt">
        <b>WARUNG POHON</b><br><br>
        ID Pesanan: <?= $data['id_pesanan'] ?><br>
        Nama: <?= $data['nama'] ?><br>
        Telp: <?= $data['no_telp'] ?><br><br>

        Total: <b>Rp <?= number_format($data['total_harga']) ?></b>
    </div>

    <!-- QRIS -->
    <img src="BAYAR.png" class="qris">

    <div class="label-text">
        silahkan scan qris diatas ini dan berikan
        bukti pada button dibawah ini
    </div>

    <form method="POST" action="bayar_proses.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data['id_pesanan'] ?>">

        <div class="file-row">
            <b>Photo</b> :
            <input type="file" name="bukti" required>
        </div>

        <button class="btn" type="submit">kirim bukti</button>
    </form>

</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
<?php if (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Anda belum memilih foto bukti pembayaran.",
    });
<?php endif; ?>

<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    Swal.fire({
        title: "Berhasil!",
        text: "Bukti pembayaran berhasil dikirim.",
        icon: "success"
    }).then(() => {
        window.location.href = "nota.php?id=<?= $data['id_pesanan'] ?>";
    });
<?php endif; ?>
</script>

</body>
</html>
