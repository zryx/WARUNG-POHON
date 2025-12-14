<?php
// index.php
include "db.php";
include "config.php";

// ambil kategori dan menu
$kategori_res = $koneksi->query("SELECT * FROM menu_kategori ORDER BY id_kategori");


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Warung Pohon - Pesan & Reservasi</title>
<link rel="stylesheet" href="style.css">
    <script>
        // fungsi tambah/kurang & hitung total
        function tambah(id) 
            {
            const el = document.getElementById('qty_' + id);
            el.value = parseInt(el.value) + 1;
            hitungTotal();
            }
        function kurang(id) 
            {
            const el = document.getElementById('qty_' + id);
            if (parseInt(el.value) > 0) {
                el.value = parseInt(el.value) - 1;
                hitungTotal();
            }
        }
        function hitungTotal() {
            let total = 0;
            document.querySelectorAll('.menu-item').forEach(function(it){
                const harga = parseInt(it.dataset.harga);
                const id = it.dataset.id;
                const qty = parseInt(document.getElementById('qty_' + id).value) || 0;
                total += harga * qty;
            });
            document.getElementById('total_harga').innerText = total.toLocaleString('id-ID');
            document.getElementById('total_harga_input').value = total;
        }
        window.addEventListener('DOMContentLoaded', function(){
        hitungTotal();
        });
    </script>
</head>
<body>

<a href="/warungpohon/menu.html" class="logout-btn">Keluar</a>

<div class="container">
    <div class="left">
    <h2>FORM PEMESANAN MENU</h2>

        <form method="POST" action="submit_pesanan.php" id="formOrder">
        <div style="margin-bottom:12px;">
            <div class="input-group">
            <label>Nama</label>
            <input type="text" name="nama" required>
            </div>
            <div class="input-group">
            <label>Nomor Telp</label>
            <input type="text" name="no_telp" required>
            </div>
        </div>

        <?php while($k = $kategori_res->fetch_assoc()): ?>
            <div class="kategori-box">
            <h3><?php echo htmlspecialchars($k['nama_kategori']); ?></h3>

            <?php
                $idk = (int)$k['id_kategori'];
                $menus = $koneksi->query
                ("SELECT * FROM menu WHERE id_kategori = $idk ORDER BY id_menu");
                while($m = $menus->fetch_assoc()):
            ?>

                <div class="menu-item" data-harga="<?php echo (int)$m['harga']; ?>" data-id="<?php echo (int)$m['id_menu']; ?>">
                <span><?php echo htmlspecialchars($m['nama_menu']); ?> (Rp <?php echo number_format($m['harga']); ?>)</span>
                <div class="controls">
                    <button type="button" onclick="kurang(<?php echo $m['id_menu']; ?>)">-</button>
                    <input class="qty" type="text" id="qty_<?php echo $m['id_menu']; ?>" name="qty[<?php echo $m['id_menu']; ?>]" value="0" readonly>
                    <button type="button" onclick="tambah(<?php echo $m['id_menu']; ?>)">+</button>
                </div>
                </div>
            <?php endwhile; ?>
            </div>
        <?php endwhile; ?>

        <div class="total-bar">
            <div class="note">Total Harga: Rp <strong id="total_harga">0</strong></div>
            <div>
            <input type="hidden" name="total_harga" id="total_harga_input" value="0">
            <button type="submit" class="btn-primary">BAYAR →</button>
            </div>
        </div>
        </form>

</div>

</body>
</html>
