<?php
include "db.php";

// Ambil semua pesanan
$q = $koneksi->query("SELECT * FROM pesanan ORDER BY id_pesanan ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Semua Struk</title>

<style>
    body {
        background: #f0f0f0;
        font-family: monospace;
        padding: 20px;
    }

    .logout-btn {
        position: fixed;
        top: 20px;
        left: 20px;
        background: #2c3e50;
        color: #fff;
        padding: 10px 18px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        font-size: 14px;
        box-shadow: 0 0 5px rgba(0,0,0,0.3);
    }
    .logout-btn:hover {
        background: #c0392b;
    }

    .menu-btn {
        position: fixed;
        top: 20px;
        left: 20px;
        background: #2c3e50;
        color: #fff;
        padding: 10px 18px;
        border-radius: 6px;
        margin-left  : 1100px;
        text-decoration: none;
        font-weight: bold;
        font-size: 14px;
        box-shadow: 0 0 5px rgba(0,0,0,0.3);
    }
    .menu-btn:hover {
        background: #c0392b;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 kolom */
        gap: 20px;
        max-width: 1200px;
        margin: auto;
    }

    .struk {
        background: #fff;
        border: 1px dashed #000;
        padding: 15px;
        width: 100%;
        box-sizing: border-box;
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
        margin-top: 10px;
        border: 1px solid #000;
    }

</style>
</head>
<body>

<a href="login.php" class="logout-btn">Keluar</a>
<a href="index2.php" class="menu-btn">FORM MENU</a>

<h1 style="text-align:center;margin-bottom:30px;">SEMUA STRUK PESANAN</h1>

<div class="grid">

<?php while ($row = $q->fetch_assoc()): ?>

<?php
    // AUTO FIX JIKA DATA LAMA MASIH MENGANDUNG "uploads/"
    if (strpos($row['bukti'], 'uploads/') === 0) {
        $row['bukti'] = str_replace('uploads/', '', $row['bukti']);
    }
?>


    <?php
        // Ambil item pesanan untuk setiap struk
        $id = $row['id_pesanan'];
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
            <h4 style="text-align:center;">Bukti</h4>
            <img src="uploads/<?= $row['bukti'] ?>" alt="Bukti Pembayaran">
        <?php else: ?>
            <p style="text-align:center;color:#777;">(Belum upload bukti)</p>
        <?php endif; ?>


        <div style="text-align:right; margin-top:10px;">
            <a href="#" 
            class="delete-btn" 
            data-id="<?= $row['id_pesanan'] ?>"
            style= "padding:5px 10px; background:#c0392b; color:#fff; text-decoration:none; border-radius:4px;">
            Delete
            </a>
        </div>

    </div>

<?php endwhile; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        let id = this.getAttribute('data-id');

        Swal.fire({
            title: "Yakin ingin menghapus?",
            text: "Data ini tidak bisa dipulihkan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Terhapus!",
                    text: "Data berhasil dihapus.",
                    icon: "success",
                    timer: 1200,
                    showConfirmButton: false
                });

                setTimeout(() => {
                    window.location.href = "delete_pesanan.php?id=" + id;
                }, 1300);
            }
        });
    });
});
</script>

</body>
</html>
