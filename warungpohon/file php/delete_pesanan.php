<?php
include "db.php";

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = intval($_GET['id']);

// Ambil data pesanan untuk cek bukti
$q = $koneksi->query("SELECT bukti FROM pesanan WHERE id_pesanan = $id");
$data = $q->fetch_assoc();

if ($data) {

    // Hapus bukti jika ada
    if (!empty($data['bukti']) && file_exists("uploads/" . $data['bukti'])) {
        unlink("uploads/" . $data['bukti']);
    }

    // Hapus item pesanan
    $koneksi->query("DELETE FROM pesanan_items WHERE id_pesanan = $id");

    // Hapus pesanan utama
    $koneksi->query("DELETE FROM pesanan WHERE id_pesanan = $id");
}

header("Location: nota2.php");
exit();
