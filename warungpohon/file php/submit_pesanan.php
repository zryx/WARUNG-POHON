<?php
include "db.php";

$nama = trim($_POST['nama'] ?? '');
$no_telp = trim($_POST['no_telp'] ?? '');
$total_harga = (int)($_POST['total_harga'] ?? 0);
$qty = $_POST['qty'] ?? [];

if ($nama == '' || $no_telp == '') {
    die("Data tidak lengkap.");
}

$hitung_total = 0;
$items = [];

foreach ($qty as $id_menu => $jumlah) {
    $jumlah = (int)$jumlah;
    if ($jumlah <= 0) continue;

    $stmt = $koneksi->prepare("SELECT harga FROM menu WHERE id_menu = ?");
    $stmt->bind_param("i", $id_menu);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        $harga = (int)$row['harga'];
        $subtotal = $harga * $jumlah;
        $hitung_total += $subtotal;
        $items[] = ['id_menu' => $id_menu, 'jumlah' => $jumlah, 'subtotal' => $subtotal];
    }
    $stmt->close();
}

if (count($items) == 0) die("Tidak ada menu yang dipilih.");

// simpan pesanan
$stmt = $koneksi->prepare("INSERT INTO pesanan (nama, no_telp, total_harga) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $nama, $no_telp, $hitung_total);
$stmt->execute();   
$id_pesanan = $stmt->insert_id;
$stmt->close();

// simpan detail item
$stmt = $koneksi->prepare("INSERT INTO pesanan_items (id_pesanan, id_menu, jumlah, subtotal) VALUES (?, ?, ?, ?)");
foreach ($items as $it) {
    $stmt->bind_param("iiii", $id_pesanan, $it['id_menu'], $it['jumlah'], $it['subtotal']);
    $stmt->execute();
}
$stmt->close();

// setelah submit → pergi ke halaman upload bukti
header("Location: bayar.php?id=$id_pesanan");
exit;
?>
