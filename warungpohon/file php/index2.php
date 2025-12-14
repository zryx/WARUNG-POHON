<?php
// index2.php (ADMIN)
include "db.php";
include "config.php";

// =========================
// HANDLE ADD / UPDATE / DELETE MENU
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // tambah menu
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $id_kategori = (int)$_POST['id_kategori'];
        $nama_menu   = $koneksi->real_escape_string($_POST['nama_menu']);
        $harga       = (int)$_POST['harga'];

        $koneksi->query("INSERT INTO menu (id_kategori, nama_menu, harga) VALUES ($id_kategori, '$nama_menu', $harga)");
        header("Location: index2.php");
        exit;
    }

    // update menu
    if (isset($_POST['action']) && $_POST['action'] === 'update') {
        $id_menu   = (int)$_POST['id_menu'];
        $nama_menu = $koneksi->real_escape_string($_POST['nama_menu']);
        $harga     = (int)$_POST['harga'];

        $koneksi->query("UPDATE menu SET nama_menu='$nama_menu', harga=$harga WHERE id_menu=$id_menu");
        header("Location: index2.php");
        exit;
    }

    // hapus menu
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id_menu = (int)$_POST['id_menu'];
        $koneksi->query("DELETE FROM menu WHERE id_menu=$id_menu");
        header("Location: index2.php");
        exit;
    }
}

// ambil kategori
$kategori_res = $koneksi->query("SELECT * FROM menu_kategori ORDER BY id_kategori");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Warung Pohon - Admin Menu</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<a href="nota2.php" class="logout-btn">Keluar</a>


<div class="container">
<div class="left">
<h2>ADMIN – KELOLA MENU</h2>

<?php while($k = $kategori_res->fetch_assoc()): ?>
<div class="kategori-box">
<h3><?php echo htmlspecialchars($k['nama_kategori']); ?></h3>

<?php
$idk = (int)$k['id_kategori'];
$menus = $koneksi->query("SELECT * FROM menu WHERE id_kategori=$idk ORDER BY id_menu");
while($m = $menus->fetch_assoc()):
?>

<div class="menu-item">
<form method="POST" style="display:flex; justify-content:space-between; width:100%; gap:10px;">
<input type="hidden" name="action" value="update">
<input type="hidden" name="id_menu" value="<?php echo $m['id_menu']; ?>">

<input type="text" name="nama_menu" value="<?php echo htmlspecialchars($m['nama_menu']); ?>" required style="flex:2;">
<input type="number" name="harga" value="<?php echo $m['harga']; ?>" required style="width:120px;">

<button type="submit">UPDATE</button>
</form>

<form method="POST" onsubmit="return confirm('Hapus menu ini?');" style="margin-top:6px;">
<input type="hidden" name="action" value="delete">
<input type="hidden" name="id_menu" value="<?php echo $m['id_menu']; ?>">
<button type="submit" style="background:#c0392b;">HAPUS</button>
</form>
</div>

<?php endwhile; ?>

<!-- FORM TAMBAH MENU -->
<div class="menu-item" style="background:#f4f6f8;">
<form method="POST" style="display:flex; gap:10px; width:100%;">
<input type="hidden" name="action" value="add">
<input type="hidden" name="id_kategori" value="<?php echo $idk; ?>">

<input type="text" name="nama_menu" placeholder="Nama menu baru" required style="flex:2;">
<input type="number" name="harga" placeholder="Harga" required style="width:120px;">
<button type="submit">TAMBAH</button>
</form>
</div>

</div>
<?php endwhile; ?>

</div>
</div>

</body>
</html>
